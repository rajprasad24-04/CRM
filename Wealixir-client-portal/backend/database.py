import sqlite3
import os

# DB lives in the project root, one level above backend/
DB_PATH = os.path.join(os.path.dirname(__file__), '..', 'registrations.db')


def get_connection() -> sqlite3.Connection:
    conn = sqlite3.connect(DB_PATH)
    conn.row_factory = sqlite3.Row
    return conn


def init_db() -> None:
    conn = get_connection()
    try:
        conn.execute('''
            CREATE TABLE IF NOT EXISTS registrations (
                id          INTEGER PRIMARY KEY AUTOINCREMENT,
                name        TEXT    NOT NULL,
                dob         TEXT    NOT NULL,
                pan_number  TEXT    NOT NULL,
                email       TEXT    NOT NULL,
                mobile      TEXT    NOT NULL,
                address     TEXT,
                city        TEXT,
                notes       TEXT,
                submitted_at TEXT   DEFAULT (datetime('now'))
            )
        ''')
        conn.commit()
    finally:
        conn.close()


def get_all_registrations() -> list[sqlite3.Row]:
    conn = get_connection()
    try:
        rows = conn.execute('SELECT * FROM registrations ORDER BY id DESC').fetchall()
    finally:
        conn.close()
    return rows


def save_registration(
    name: str,
    dob: str,
    pan_number: str,
    email: str,
    mobile: str,
    address: str,
    city: str,
    notes: str,
) -> int:
    conn = get_connection()
    try:
        cursor = conn.execute(
            '''INSERT INTO registrations (name, dob, pan_number, email, mobile, address, city, notes)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?)''',
            (name, dob, pan_number, email, mobile, address or None, city or None, notes or None),
        )
        conn.commit()
        new_id: int = cursor.lastrowid  # type: ignore[assignment]
    finally:
        conn.close()
    return new_id
