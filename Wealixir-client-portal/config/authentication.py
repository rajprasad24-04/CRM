"""
Central place for all confidential credentials.
All values are read from the .env file.
Add your credentials to .env — never hardcode them here.
"""

import os
from dotenv import load_dotenv

load_dotenv()

# ── Flask ──────────────────────────────────────────────
SECRET_KEY = os.getenv('SECRET_KEY', 'change-this-in-env')

# ── Email (Gmail App Password / SMTP) ─────────────────
MAIL_ENABLED  = os.getenv('MAIL_ENABLED', 'false').lower() == 'true'
MAIL_SERVER   = os.getenv('MAIL_SERVER', 'smtp.gmail.com')
MAIL_PORT     = int(os.getenv('MAIL_PORT', 587))
MAIL_USE_TLS  = os.getenv('MAIL_USE_TLS', 'true').lower() == 'true'
MAIL_USERNAME = os.getenv('MAIL_USERNAME', '')
MAIL_PASSWORD = os.getenv('MAIL_PASSWORD', '')
MAIL_FROM     = os.getenv('MAIL_FROM', MAIL_USERNAME)

# ── Microsoft OneDrive (Azure App Registration) ───────
ONEDRIVE_TENANT_ID     = os.getenv('ONEDRIVE_TENANT_ID', '')
ONEDRIVE_CLIENT_ID     = os.getenv('ONEDRIVE_CLIENT_ID', '')
ONEDRIVE_CLIENT_SECRET = os.getenv('ONEDRIVE_CLIENT_SECRET', '')
ONEDRIVE_DRIVE_ID      = os.getenv('ONEDRIVE_DRIVE_ID', '')
ONEDRIVE_FOLDER_NAME   = os.getenv('ONEDRIVE_FOLDER_NAME', 'Wealixir Registrations')
