"""Pydantic v2 request / response models for all API endpoints."""

from __future__ import annotations

import re
from typing import Optional

from pydantic import BaseModel, EmailStr, field_validator

_PAN_RE    = re.compile(r'^[A-Z]{5}[0-9]{4}[A-Z]$')
_MOBILE_RE = re.compile(r'^[6-9][0-9]{9}$')


# ---------------------------------------------------------------------------
# Request models
# ---------------------------------------------------------------------------


class SendOtpRequest(BaseModel):
    email: EmailStr

    @field_validator('email', mode='before')
    @classmethod
    def normalise_email(cls, v: str) -> str:
        return v.strip().lower()


class VerifyOtpRequest(BaseModel):
    otp: str

    @field_validator('otp')
    @classmethod
    def otp_must_be_digits(cls, v: str) -> str:
        v = v.strip()
        if not v.isdigit() or len(v) != 6:
            raise ValueError('OTP must be a 6-digit number.')
        return v


class SubmitRegistrationRequest(BaseModel):
    name: str
    dob: str
    pan_number: str
    mobile: str
    address: Optional[str] = ''
    city: Optional[str] = ''
    notes: Optional[str] = ''

    @field_validator('name', 'dob', 'pan_number', 'mobile')
    @classmethod
    def required_not_empty(cls, v: str) -> str:
        if not v or not v.strip():
            raise ValueError('This field is required.')
        return v.strip()

    @field_validator('pan_number')
    @classmethod
    def pan_format(cls, v: str) -> str:
        v = v.strip().upper()
        if not _PAN_RE.match(v):
            raise ValueError('PAN must be in the format AAAAA9999A (e.g. ABCDE1234F).')
        return v

    @field_validator('mobile')
    @classmethod
    def mobile_format(cls, v: str) -> str:
        v = v.strip()
        if not _MOBILE_RE.match(v):
            raise ValueError('Mobile must be a 10-digit Indian number starting with 6–9.')
        return v


# ---------------------------------------------------------------------------
# Response models
# ---------------------------------------------------------------------------


class SendOtpResponse(BaseModel):
    success: bool
    message: str
    dev_otp: Optional[str] = None  # populated only when MAIL_ENABLED=false


class VerifyOtpResponse(BaseModel):
    success: bool
    message: str
    email: str


class SubmitResponse(BaseModel):
    success: bool
    message: str
    name: str


class RegistrationRecord(BaseModel):
    id: int
    name: str
    pan_number: str
    email: str
    mobile: str
    dob: str
    city: Optional[str] = None
    address: Optional[str] = None
    notes: Optional[str] = None
    submitted_at: Optional[str] = None


class SessionStateResponse(BaseModel):
    step: int
    email: str
