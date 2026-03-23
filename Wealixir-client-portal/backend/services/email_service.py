"""Email service — plain smtplib/email.mime, no Flask-Mail dependency."""

from __future__ import annotations

import smtplib
from email.mime.base import MIMEBase
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email import encoders

from config.authentication import (
    MAIL_ENABLED,
    MAIL_FROM,
    MAIL_PASSWORD,
    MAIL_PORT,
    MAIL_SERVER,
    MAIL_USE_TLS,
    MAIL_USERNAME,
)
from services.pdf_service import generate_registration_pdf


# ---------------------------------------------------------------------------
# Internal helpers
# ---------------------------------------------------------------------------

def _smtp_connection() -> smtplib.SMTP:
    """Open and return an authenticated SMTP connection."""
    server = smtplib.SMTP(MAIL_SERVER, MAIL_PORT)
    server.ehlo()
    if MAIL_USE_TLS:
        server.starttls()
        server.ehlo()
    server.login(MAIL_USERNAME, MAIL_PASSWORD)
    return server


def _send(msg: MIMEMultipart) -> bool:
    """Deliver a pre-built MIME message; returns True on success."""
    try:
        with _smtp_connection() as server:
            server.sendmail(MAIL_FROM or MAIL_USERNAME, msg['To'], msg.as_string())
        return True
    except Exception as exc:  # noqa: BLE001
        print(f'[EmailService] Send failed: {exc}')
        return False


# ---------------------------------------------------------------------------
# OTP email
# ---------------------------------------------------------------------------

_OTP_HTML_TEMPLATE = """\
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your OTP – Wealixir</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:Helvetica,Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:40px 0;">
    <tr>
      <td align="center">
        <table width="520" cellpadding="0" cellspacing="0"
               style="background:#ffffff;border-radius:8px;overflow:hidden;
                      box-shadow:0 2px 12px rgba(0,0,0,.08);">
          <!-- header -->
          <tr>
            <td style="background:#1e3a5f;padding:24px 32px;text-align:center;">
              <span style="color:#ffffff;font-size:22px;font-weight:700;
                           letter-spacing:1px;">Wealixir</span>
            </td>
          </tr>
          <!-- body -->
          <tr>
            <td style="padding:36px 40px 28px;">
              <p style="margin:0 0 12px;color:#1e3a5f;font-size:16px;font-weight:600;">
                Your One-Time Password
              </p>
              <p style="margin:0 0 24px;color:#555;font-size:14px;line-height:1.6;">
                Use the code below to verify your email address.
                It expires in <strong>5 minutes</strong>.
              </p>
              <!-- OTP box -->
              <div style="background:#f0f4fa;border:1px solid #c8d8ee;border-radius:6px;
                          padding:20px;text-align:center;margin-bottom:24px;">
                <span style="font-size:36px;font-weight:700;letter-spacing:10px;
                             color:#1e3a5f;">{otp_code}</span>
              </div>
              <p style="margin:0;color:#888;font-size:12px;line-height:1.5;">
                If you did not request this, please ignore this email.
              </p>
            </td>
          </tr>
          <!-- footer -->
          <tr>
            <td style="background:#f9fafb;padding:16px 40px;text-align:center;
                       border-top:1px solid #e8edf3;">
              <span style="color:#aaa;font-size:11px;">
                &copy; 2024 Wealixir &mdash; info@wealixir.com
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
"""


def send_otp_email(to_email: str, code: str) -> bool:
    """Send a 6-digit OTP to *to_email*. Returns True on successful delivery."""
    if not MAIL_ENABLED:
        print(f'[EmailService] MAIL_ENABLED=false — OTP for {to_email}: {code}')
        return False

    msg = MIMEMultipart('alternative')
    msg['Subject'] = 'Your Wealixir OTP Code'
    msg['From'] = MAIL_FROM or MAIL_USERNAME
    msg['To'] = to_email

    html_body = _OTP_HTML_TEMPLATE.format(otp_code=code)
    msg.attach(MIMEText(f'Your OTP is: {code}. It expires in 5 minutes.', 'plain'))
    msg.attach(MIMEText(html_body, 'html'))

    return _send(msg)


# ---------------------------------------------------------------------------
# Welcome / confirmation email (with PDF attachment)
# ---------------------------------------------------------------------------

_WELCOME_HTML_TEMPLATE = """\
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Registration Confirmed – Wealixir</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:Helvetica,Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:40px 0;">
    <tr>
      <td align="center">
        <table width="560" cellpadding="0" cellspacing="0"
               style="background:#ffffff;border-radius:8px;overflow:hidden;
                      box-shadow:0 2px 12px rgba(0,0,0,.08);">
          <!-- header -->
          <tr>
            <td style="background:#1e3a5f;padding:28px 40px;text-align:center;">
              <span style="color:#fff;font-size:22px;font-weight:700;
                           letter-spacing:1px;">Wealixir</span><br/>
              <span style="color:#a8c4e0;font-size:12px;">Client Portal</span>
            </td>
          </tr>
          <!-- greeting -->
          <tr>
            <td style="padding:36px 40px 8px;">
              <p style="margin:0 0 8px;color:#1e3a5f;font-size:18px;font-weight:600;">
                Welcome, {name}!
              </p>
              <p style="margin:0;color:#555;font-size:14px;line-height:1.7;">
                Your registration with Wealixir has been successfully completed.
                Please find your registration summary attached to this email as a PDF.
              </p>
            </td>
          </tr>
          <!-- summary table -->
          <tr>
            <td style="padding:24px 40px 8px;">
              <table width="100%" cellpadding="0" cellspacing="0"
                     style="border:1px solid #e2e8f0;border-radius:6px;overflow:hidden;
                            font-size:13px;">
                <tr style="background:#f0f4fa;">
                  <td style="padding:10px 16px;color:#1e3a5f;font-weight:600;
                              width:40%;border-bottom:1px solid #e2e8f0;">Email</td>
                  <td style="padding:10px 16px;color:#333;
                              border-bottom:1px solid #e2e8f0;">{email}</td>
                </tr>
                <tr>
                  <td style="padding:10px 16px;color:#1e3a5f;font-weight:600;
                              border-bottom:1px solid #e2e8f0;">Mobile</td>
                  <td style="padding:10px 16px;color:#333;
                              border-bottom:1px solid #e2e8f0;">{mobile}</td>
                </tr>
                <tr style="background:#f0f4fa;">
                  <td style="padding:10px 16px;color:#1e3a5f;font-weight:600;
                              border-bottom:1px solid #e2e8f0;">PAN Number</td>
                  <td style="padding:10px 16px;color:#333;
                              border-bottom:1px solid #e2e8f0;">{pan_number}</td>
                </tr>
                <tr>
                  <td style="padding:10px 16px;color:#1e3a5f;font-weight:600;">
                    Submitted At</td>
                  <td style="padding:10px 16px;color:#333;">{submitted_at}</td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- closing -->
          <tr>
            <td style="padding:20px 40px 36px;">
              <p style="margin:0;color:#555;font-size:13px;line-height:1.7;">
                Our team will review your information and get in touch shortly.
                If you have any questions, reply to this email or contact
                <a href="mailto:info@wealixir.com" style="color:#1e3a5f;">
                  info@wealixir.com
                </a>.
              </p>
            </td>
          </tr>
          <!-- footer -->
          <tr>
            <td style="background:#f9fafb;padding:16px 40px;text-align:center;
                       border-top:1px solid #e8edf3;">
              <span style="color:#aaa;font-size:11px;">
                &copy; 2024 Wealixir &mdash; info@wealixir.com
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
"""


def send_welcome_email(to_email: str, name: str, registration_data: dict) -> bool:  # type: ignore[type-arg]
    """Send a welcome / confirmation email with a PDF summary attachment."""
    if not MAIL_ENABLED:
        print(f'[EmailService] MAIL_ENABLED=false — skipping welcome email for {to_email}')
        return False

    msg = MIMEMultipart('mixed')
    msg['Subject'] = f'Welcome to Wealixir, {name}! — Registration Confirmed'
    msg['From'] = MAIL_FROM or MAIL_USERNAME
    msg['To'] = to_email

    html_body = _WELCOME_HTML_TEMPLATE.format(
        name=name,
        email=registration_data.get('email', '-'),
        mobile=registration_data.get('mobile', '-'),
        pan_number=registration_data.get('pan_number', '-'),
        submitted_at=registration_data.get('submitted_at', '-'),
    )
    alternative = MIMEMultipart('alternative')
    plain_text = (
        f'Dear {name},\n\n'
        'Your Wealixir registration is complete. '
        'Please see the attached PDF for your summary.\n\n'
        'Thank you,\nWealixir Team'
    )
    alternative.attach(MIMEText(plain_text, 'plain'))
    alternative.attach(MIMEText(html_body, 'html'))
    msg.attach(alternative)

    # Generate and attach PDF
    try:
        pdf_bytes = generate_registration_pdf(registration_data)
        pdf_part = MIMEBase('application', 'pdf')
        pdf_part.set_payload(pdf_bytes)
        encoders.encode_base64(pdf_part)
        pdf_part.add_header(
            'Content-Disposition',
            'attachment',
            filename=f'Wealixir_Registration_{name.replace(" ", "_")}.pdf',
        )
        msg.attach(pdf_part)
    except Exception as exc:  # noqa: BLE001
        print(f'[EmailService] PDF generation failed, sending without attachment: {exc}')

    return _send(msg)
