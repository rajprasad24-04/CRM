# Wealixir Client Portal

Financial services client registration portal with OTP-verified email, OneDrive sync, and PDF welcome emails.

**Stack:** FastAPI (Python) + React 19 + Vite + SQLite

---

## Prerequisites

- Python 3.11+
- Node.js 18+
- A `.env` file at the project root (see setup below)

---

## First-time setup

### 1. Configure environment variables

```bash
cp .env.example .env
```

Edit `.env` — at minimum set `SECRET_KEY`. Set `MAIL_ENABLED=false` to skip email during local development (OTP will appear in the API response instead).

Generate a strong secret key:
```bash
python -c "import secrets; print(secrets.token_hex(32))"
```

### 2. Start the backend

```bash
cd backend
pip install -r requirements.txt
uvicorn main:app --reload --port 8000
```

API: http://localhost:8000
Docs: http://localhost:8000/docs

### 3. Start the frontend

```bash
cd frontend
npm install
npm run dev
```

App: http://localhost:5173
The Vite dev server proxies all `/api/*` requests to the FastAPI backend.

---

## Project structure

```
backend/              FastAPI application (port 8000)
  main.py             Endpoints: /api/send-otp, /api/verify-otp,
                      /api/submit, /api/records, /api/session-state
  models.py           Pydantic v2 request/response models
  database.py         SQLite access (../registrations.db)
  config/
    authentication.py Reads all settings from .env
  services/
    email_service.py  OTP + welcome emails via smtplib
    onedrive.py       Microsoft Graph API integration
    pdf_service.py    Registration summary PDF (fpdf2)
    docx_service.py   DOCX generation

frontend/             React 19 + Vite application (port 5173)
  src/
    App.jsx           React Router — / and /records routes
    api.js            Axios client
    components/
      RegistrationPage.jsx  3-step registration flow
      RecordsPage.jsx       View all submitted registrations
      steps/
        Step1Email.jsx      Enter email, request OTP
        Step2OTP.jsx        Enter and verify OTP
        Step3Details.jsx    Personal details form

registrations.db      SQLite database (auto-created on first run)
```

---

## Environment variables

| Variable | Required | Description |
|---|---|---|
| `SECRET_KEY` | Yes | Signs session cookies — must be long and random |
| `MAIL_ENABLED` | No | `true` to send real emails, `false` for dev mode |
| `MAIL_SERVER` | No | SMTP host (default: `smtp.gmail.com`) |
| `MAIL_PORT` | No | SMTP port (default: `587`) |
| `MAIL_USE_TLS` | No | Enable STARTTLS (default: `true`) |
| `MAIL_USERNAME` | If MAIL_ENABLED | SMTP login |
| `MAIL_PASSWORD` | If MAIL_ENABLED | SMTP password / App Password |
| `MAIL_FROM` | No | Sender address (defaults to `MAIL_USERNAME`) |
| `ONEDRIVE_TENANT_ID` | No | Azure AD tenant — leave blank to disable OneDrive |
| `ONEDRIVE_CLIENT_ID` | No | Azure app client ID |
| `ONEDRIVE_CLIENT_SECRET` | No | Azure app client secret |
| `ONEDRIVE_DRIVE_ID` | No | OneDrive drive ID |
| `ONEDRIVE_FOLDER_NAME` | No | Root folder name (default: `Wealixir Registrations`) |
