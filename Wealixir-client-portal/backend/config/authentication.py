import os
from dotenv import load_dotenv

# .env lives two levels up: backend/config/ -> backend/ -> project root
load_dotenv(dotenv_path=os.path.join(os.path.dirname(__file__), '..', '..', '.env'))

SECRET_KEY = os.getenv('SECRET_KEY', 'change-this-in-env')
MAIL_ENABLED  = os.getenv('MAIL_ENABLED', 'false').lower() == 'true'
MAIL_SERVER   = os.getenv('MAIL_SERVER', 'smtp.gmail.com')
MAIL_PORT     = int(os.getenv('MAIL_PORT', 587))
MAIL_USE_TLS  = os.getenv('MAIL_USE_TLS', 'true').lower() == 'true'
MAIL_USERNAME = os.getenv('MAIL_USERNAME', '')
MAIL_PASSWORD = os.getenv('MAIL_PASSWORD', '')
MAIL_FROM     = os.getenv('MAIL_FROM', MAIL_USERNAME)
ONEDRIVE_TENANT_ID     = os.getenv('ONEDRIVE_TENANT_ID', '')
ONEDRIVE_CLIENT_ID     = os.getenv('ONEDRIVE_CLIENT_ID', '')
ONEDRIVE_CLIENT_SECRET = os.getenv('ONEDRIVE_CLIENT_SECRET', '')
ONEDRIVE_DRIVE_ID      = os.getenv('ONEDRIVE_DRIVE_ID', '')
ONEDRIVE_FOLDER_NAME   = os.getenv('ONEDRIVE_FOLDER_NAME', 'Wealixir Registrations')
