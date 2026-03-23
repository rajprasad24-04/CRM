"""Wealixir Client Portal — FastAPI backend.

Run from the backend/ directory:
    uvicorn main:app --reload --port 8000
"""

from __future__ import annotations

import secrets
from contextlib import asynccontextmanager
from datetime import datetime, timedelta, timezone
from typing import Any, AsyncGenerator

from fastapi import BackgroundTasks, FastAPI, HTTPException, Request, status
from fastapi.exceptions import RequestValidationError
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
from starlette.middleware.sessions import SessionMiddleware

from config.authentication import SECRET_KEY
from database import get_all_registrations, init_db, save_registration
from models import (
    RegistrationRecord,
    SendOtpRequest,
    SendOtpResponse,
    SessionStateResponse,
    SubmitRegistrationRequest,
    SubmitResponse,
    VerifyOtpRequest,
    VerifyOtpResponse,
)
from services.email_service import send_otp_email, send_welcome_email
from services.onedrive import append_registration, create_client_folder


# ---------------------------------------------------------------------------
# Lifespan — runs init_db() once on startup
# ---------------------------------------------------------------------------

@asynccontextmanager
async def lifespan(app: FastAPI) -> AsyncGenerator[None, None]:
    init_db()
    yield


# ---------------------------------------------------------------------------
# Application factory
# ---------------------------------------------------------------------------

app = FastAPI(
    title='Wealixir Client Portal API',
    description='Financial services client registration — OTP-verified email flow.',
    version='1.0.0',
    lifespan=lifespan,
)


# Flatten Pydantic validation errors to a single string for frontend compatibility
@app.exception_handler(RequestValidationError)
async def validation_exception_handler(request: Request, exc: RequestValidationError) -> JSONResponse:
    messages = '; '.join(
        err.get('msg', 'Validation error') for err in exc.errors()
    )
    return JSONResponse(status_code=422, content={'detail': messages})

# CORS — allow the Vite dev server and, in production, the real origin
app.add_middleware(
    CORSMiddleware,
    allow_origins=['http://localhost:5173'],
    allow_methods=['*'],
    allow_headers=['*'],
    allow_credentials=True,
)

# Signed-cookie session middleware (itsdangerous under the hood)
app.add_middleware(
    SessionMiddleware,
    secret_key=SECRET_KEY,
    session_cookie='wealixir_session',
    max_age=60 * 60,          # 1 hour
    same_site='lax',
    https_only=False,          # set True behind TLS in production
)


# ---------------------------------------------------------------------------
# Helper
# ---------------------------------------------------------------------------

def _session(request: Request) -> dict[str, Any]:
    """Shorthand to access the Starlette session dict."""
    return request.session  # type: ignore[return-value]


# ---------------------------------------------------------------------------
# Endpoints
# ---------------------------------------------------------------------------

@app.post(
    '/api/send-otp',
    response_model=SendOtpResponse,
    status_code=status.HTTP_200_OK,
    summary='Step 1 — generate and send a 6-digit OTP to the given email',
    tags=['OTP flow'],
)
async def send_otp(body: SendOtpRequest, request: Request) -> SendOtpResponse:
    """Validate the email, generate an OTP, store it in the signed session cookie,
    and attempt delivery via SMTP.  When ``MAIL_ENABLED=false`` the OTP is also
    returned in the response body (``dev_otp``) to aid local development.
    """
    email = body.email  # already stripped/lowercased by the validator
    code = str(secrets.randbelow(900_000) + 100_000)
    expires = (datetime.now(timezone.utc) + timedelta(minutes=5)).isoformat()

    sess = _session(request)
    sess['otp_code'] = code
    sess['otp_email'] = email
    sess['otp_expires'] = expires
    sess['otp_step'] = 2
    sess['otp_verified'] = False

    sent = send_otp_email(email, code)

    if sent:
        message = f'OTP sent to {email}. Check your inbox.'
        return SendOtpResponse(success=True, message=message)
    else:
        # MAIL_ENABLED=false or SMTP error — surface OTP for dev/testing
        message = f'Testing mode — OTP generated for {email}.'
        return SendOtpResponse(success=True, message=message, dev_otp=code)


@app.post(
    '/api/verify-otp',
    response_model=VerifyOtpResponse,
    status_code=status.HTTP_200_OK,
    summary='Step 2 — verify the OTP entered by the user',
    tags=['OTP flow'],
)
async def verify_otp(body: VerifyOtpRequest, request: Request) -> VerifyOtpResponse:
    sess = _session(request)
    stored_code: str | None = sess.get('otp_code')
    expires_str: str | None = sess.get('otp_expires')

    if not stored_code or not expires_str:
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail='Session expired. Please start again.',
        )

    if datetime.now(timezone.utc) > datetime.fromisoformat(expires_str):
        sess['otp_step'] = 1
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail='OTP expired. Please request a new one.',
        )

    attempts: int = sess.get('otp_attempts', 0) + 1
    if attempts > 5:
        sess.clear()
        raise HTTPException(
            status_code=status.HTTP_429_TOO_MANY_REQUESTS,
            detail='Too many failed attempts. Please start again.',
        )
    sess['otp_attempts'] = attempts

    if body.otp != stored_code:
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail='Incorrect OTP. Please try again.',
        )

    sess['otp_verified'] = True
    sess['otp_step'] = 3
    email: str = sess.get('otp_email', '')

    return VerifyOtpResponse(
        success=True,
        message='Email verified! Please fill in your details below.',
        email=email,
    )


@app.post(
    '/api/submit',
    response_model=SubmitResponse,
    status_code=status.HTTP_200_OK,
    summary='Step 3 — submit the full registration form',
    tags=['Registration'],
)
async def submit_registration(
    body: SubmitRegistrationRequest,
    request: Request,
    background_tasks: BackgroundTasks,
) -> SubmitResponse:
    """Persist the registration, sync to OneDrive, and send a welcome email.
    Requires a previously verified OTP session.
    """
    sess = _session(request)

    if not sess.get('otp_verified'):
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail='Please verify your email first.',
        )

    email: str = sess.get('otp_email', '')
    name = body.name
    dob = body.dob
    pan_number = body.pan_number
    mobile = body.mobile
    address = body.address or ''
    city = body.city or ''
    notes = body.notes or ''

    # Persist to SQLite
    new_id = save_registration(name, dob, pan_number, email, mobile, address, city, notes)
    submitted_at = datetime.now(timezone.utc).strftime('%Y-%m-%d %H:%M:%S')

    registration_data = {
        'name': name,
        'email': email,
        'mobile': mobile,
        'dob': dob,
        'pan_number': pan_number,
        'address': address,
        'city': city,
        'notes': notes,
        'submitted_at': submitted_at,
    }

    # Run slow I/O (OneDrive + email) in the background so the response returns immediately
    background_tasks.add_task(
        append_registration, new_id, name, dob, pan_number, email, mobile, address, city, notes, submitted_at
    )
    background_tasks.add_task(create_client_folder, name, pan_number)
    background_tasks.add_task(send_welcome_email, email, name, registration_data)

    # Clear session on success
    sess.clear()

    return SubmitResponse(
        success=True,
        message=f'Thank you {name}! Your registration is complete.',
        name=name,
    )


@app.get(
    '/api/records',
    response_model=list[RegistrationRecord],
    status_code=status.HTTP_200_OK,
    summary='List all registrations (newest first)',
    tags=['Records'],
)
async def get_records() -> list[RegistrationRecord]:
    """Return every registration row as a JSON array."""
    rows = get_all_registrations()
    return [
        RegistrationRecord(
            id=row['id'],
            name=row['name'],
            pan_number=row['pan_number'],
            email=row['email'],
            mobile=row['mobile'],
            dob=row['dob'],
            city=row['city'],
            address=row['address'],
            notes=row['notes'],
            submitted_at=row['submitted_at'],
        )
        for row in rows
    ]


@app.get(
    '/api/session-state',
    response_model=SessionStateResponse,
    status_code=status.HTTP_200_OK,
    summary='Return OTP step and email from the current session',
    tags=['OTP flow'],
)
async def session_state(request: Request) -> SessionStateResponse:
    """Used by the React frontend to restore multi-step state on page refresh."""
    sess = _session(request)
    return SessionStateResponse(
        step=sess.get('otp_step', 1),
        email=sess.get('otp_email', ''),
    )
