"""
DOCX service — personalises the welcome letter template with the client's name.

Template file: templates/emails/welcome_letter.docx
The template currently has "Pratik Kawade" as the client name placeholder.
This function replaces it with the actual client name and returns bytes.

To update the letter content in future, just edit welcome_letter.docx directly.
The only rule: keep "Pratik Kawade" as the name in the greeting line.
"""

import io
import os
from docx import Document

TEMPLATE_PATH = os.path.join(
    os.path.dirname(os.path.dirname(__file__)),
    'templates', 'emails', 'welcome_letter.docx'
)

PLACEHOLDER = '{{CLIENT_NAME}}'   # text in the template to replace


def generate_welcome_letter(client_name: str) -> bytes:
    """
    Open the welcome letter template, replace the placeholder name
    with client_name, and return the modified file as bytes.
    """
    doc = Document(TEMPLATE_PATH)

    for para in doc.paragraphs:
        if PLACEHOLDER in para.text:
            for run in para.runs:
                if PLACEHOLDER in run.text:
                    run.text = run.text.replace(PLACEHOLDER, client_name)

    buf = io.BytesIO()
    doc.save(buf)
    return buf.getvalue()
