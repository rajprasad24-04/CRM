"""
Email service for the client portal.
Handles OTP emails and welcome emails.

If MAIL_ENABLED=false in .env, emails are skipped silently
and the caller shows the OTP on screen instead.
"""

from flask import render_template
from flask_mail import Mail, Message
from services.pdf_service import generate_registration_pdf
from services.docx_service import generate_welcome_letter
from config.authentication import (
    MAIL_ENABLED, MAIL_SERVER, MAIL_PORT,
    MAIL_USE_TLS, MAIL_USERNAME, MAIL_PASSWORD, MAIL_FROM,
)

# Single Mail instance — call init_mail(app) once in app.py
mail = Mail()


def init_mail(app):
    """Attach Flask-Mail to the Flask app."""
    app.config['MAIL_SERVER']         = MAIL_SERVER
    app.config['MAIL_PORT']           = MAIL_PORT
    app.config['MAIL_USE_TLS']        = MAIL_USE_TLS
    app.config['MAIL_USERNAME']       = MAIL_USERNAME
    app.config['MAIL_PASSWORD']       = MAIL_PASSWORD
    app.config['MAIL_DEFAULT_SENDER'] = MAIL_FROM
    mail.init_app(app)


def send_otp_email(to_email, code):
    """
    Send a 6-digit OTP to to_email.
    Returns True if sent, False if skipped (MAIL_ENABLED=false) or failed.
    """
    if not MAIL_ENABLED:
        return False   # caller will show OTP on screen

    try:
        msg = Message(
            subject='Your Wealixir Verification Code',
            recipients=[to_email],
        )
        msg.body = (
            f'Your Wealixir verification code is: {code}\n\n'
            f'This code is valid for 5 minutes.\n\n'
            f'If you did not request this, please ignore this email.'
        )
        msg.html = f'''
        <div style="font-family:Arial,sans-serif;max-width:480px;margin:auto;border-radius:12px;overflow:hidden;border:1px solid #e0e0e0;">
          <div style="background:linear-gradient(135deg,#1e3a5f,#2d5f8a);padding:24px;text-align:center;">
            <img src="https://via.placeholder.com/160x40/2d5f8a/ffffff?text=Wealixir"
                 alt="Wealixir" style="height:36px;">
          </div>
          <div style="padding:32px;">
          <h2 style="color:#1e3a5f;margin-bottom:8px;">Verification Code</h2>
          <p style="color:#555;margin-bottom:24px;">Use the code below to verify your email address.</p>
          <div style="background:#f4f6f9;border-radius:8px;padding:24px;text-align:center;font-size:36px;font-weight:bold;letter-spacing:10px;color:#1e3a5f;">
            {code}
          </div>
          <p style="color:#888;font-size:12px;margin-top:24px;">This code expires in <strong>5 minutes</strong>.<br>If you did not request this, please ignore this email.</p>
          </div>
          <div style="background:#f4f6f9;padding:16px;text-align:center;border-top:1px solid #e0e0e0;">
            <p style="color:#aaa;font-size:11px;margin:0;">&copy; 2026 Wealixir. All rights reserved.</p>
          </div>
        </div>
        '''
        mail.send(msg)
        return True

    except Exception as e:
        print(f'[Email] OTP send failed: {e}')
        return False


def send_welcome_email(to_email, name, registration_data: dict = None):
    """
    Send a welcome email after successful registration.
    Returns True if sent, False if skipped or failed.
    """
    if not MAIL_ENABLED:
        print(f'[Email] Welcome email skipped (MAIL_ENABLED=false) for {to_email}')
        return False

    try:
        msg = Message(
            subject='Welcome to Wealixir — Registration Confirmed',
            recipients=[to_email],
        )
        msg.body = (
            f'Dear {name},\n\n'
            f'Thank you for registering with Wealixir. '
            f'Your details have been received and our team will be in touch shortly.\n\n'
            f'If you have any questions, feel free to reply to this email.\n\n'
            f'Warm regards,\n'
            f'Team Wealixir'
        )
        # Loads from templates/emails/welcome.html — edit that file to change the email design
        msg.html = render_template('emails/welcome.html', name=name, to_email=to_email)

        # Attach PDF report if data was provided
        if registration_data:
            pdf_bytes = generate_registration_pdf(registration_data)
            msg.attach(
                filename='registration_summary.pdf',
                content_type='application/pdf',
                data=pdf_bytes,
            )

        # Attach personalised welcome letter
        # letter_bytes = generate_welcome_letter(name)
        # msg.attach(
        #     filename='Welcome Letter.docx',
        #     content_type='application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        #     data=letter_bytes,
        # )

        mail.send(msg)
        print(f'[Email] Welcome email sent to {to_email}')
        return True

    except Exception as e:
        print(f'[Email] Welcome email failed: {e}')
        return False
