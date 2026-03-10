# Wealixir CRM

Wealixir CRM is a Laravel 9 application for managing client records, client-linked credentials, financial service data, internal notices, and admin audit trails. The codebase uses server-rendered Blade views, Laravel Breeze authentication, Spatie role/permission controls, and Vite/Tailwind for assets.

## What the application does

- Maintains a central client directory with family-level grouping and relationship-manager ownership.
- Stores client-specific credentials in encrypted form and requires password confirmation before revealing them.
- Tracks per-client financial service values across insurance, investments, taxation, and other service buckets.
- Imports client records from Excel or CSV files.
- Shows dashboard analytics for client counts, account types, yearly and monthly joins, missing data, and total service values.
- Provides an internal notice board with banners, likes, and comments.
- Tracks login/logout events, model create/update/delete events, and password reveal actions in an audit log.
- Supports admin-managed users, roles, and direct permission assignment.

## Tech stack

- PHP `^8.0.2`
- Laravel `^9.19`
- Laravel Breeze for auth scaffolding
- Spatie `laravel-permission` for RBAC
- Laravel Sanctum
- Maatwebsite Excel for imports
- Vite, Tailwind CSS, Alpine.js
- Pest and PHPUnit for tests

## Core modules

### Client management

Implemented in [app/Http/Controllers/ClientController.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Http/Controllers/ClientController.php).

- Create, view, edit, delete, and paginate clients.
- Supports global search plus column-specific filters.
- Supports missing-field filtering for PAN, DOB, address, mobile, email, RM, and partner.
- Supports CSV export for the filtered result set or the full accessible dataset.
- Restricts non-admin users to clients where `rm_user_id` matches the logged-in user.

### Client passwords

Implemented in [app/Http/Controllers/ClientPasswordController.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Http/Controllers/ClientPasswordController.php) and [app/Models/Password.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Models/Password.php).

- Stores passwords encrypted through Eloquent mutators.
- Supports CRUD under each client.
- Reveal action returns plaintext only after `password.confirm` middleware passes.
- Reveal attempts are rate-limited to `5` per minute per user/IP in [app/Providers/RouteServiceProvider.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Providers/RouteServiceProvider.php).
- Each reveal creates an audit-log entry.

### Financial data

Implemented in [app/Http/Controllers/FinancialDataController.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Http/Controllers/FinancialDataController.php).

- Each client has a single financial-data record.
- Buckets include insurance, investments, taxes, accounting, and other values.
- Dashboard totals are aggregated from this dataset.

### Imports

Implemented in [app/Http/Controllers/ImportController.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Http/Controllers/ImportController.php) and [app/Imports/ClientsImport.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Imports/ClientsImport.php).

- Accepts `.xlsx`, `.xls`, and `.csv` files up to 2 MB.
- Uses heading-row import mapping.
- Converts Excel serial dates to `Y-m-d`.

### Notice board

Implemented in [app/Http/Controllers/NoticeBoardController.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Http/Controllers/NoticeBoardController.php) and [app/Http/Controllers/NoticeInteractionController.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Http/Controllers/NoticeInteractionController.php).

- Admins or users with `notices.manage` can create, update, and delete notices.
- Notices can have optional banner images stored on the `public` disk.
- Authenticated users can like notices and add comments.
- The internal applications page surfaces active notices with recent engagement.

### Admin and audit

Implemented in [app/Http/Controllers/Admin/UserController.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Http/Controllers/Admin/UserController.php), [app/Http/Controllers/Admin/AuditLogController.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Http/Controllers/Admin/AuditLogController.php), and [app/Observers/AuditableObserver.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Observers/AuditableObserver.php).

- Admin-only user management for creating and updating users, roles, and direct permissions.
- Audit log browsing with filters by user, action, model, record ID, and date range.
- CSV export for audit logs.
- Observer-based auditing for `Client`, `FinancialData`, `Password`, `Notice`, `NoticeComment`, `NoticeLike`, and `User`.

## Access model

### Roles

Seeded roles from [database/seeders/RoleSeeder.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/database/seeders/RoleSeeder.php):

- `admin`
- `manager`
- `user`

### Permissions

Seeded permissions from [database/seeders/PermissionSeeder.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/database/seeders/PermissionSeeder.php):

- `dashboard.view`
- `profile.view`
- `profile.update`
- `profile.delete`
- `clients.view`
- `clients.create`
- `clients.update`
- `clients.delete`
- `client_passwords.view`
- `client_passwords.create`
- `client_passwords.update`
- `client_passwords.delete`
- `financial_data.view`
- `financial_data.create`
- `financial_data.update`
- `financial_data.delete`
- `import.view`
- `import.create`
- `audit_logs.view`
- `notices.manage`

Notes:

- The `admin` role receives all seeded permissions.
- Any existing user with email `admin@wealixir.com` is promoted to `admin` during role seeding.
- Users without roles are assigned the `user` role during role seeding.
- Non-admin users are scoped to their own clients and related financial/password data via `rm_user_id`.

## Key routes

Routes are defined in [routes/web.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/routes/web.php).

- `/dashboard` for analytics
- `/clients` for client listing and CSV export
- `/clients/{id}` for client details and family view
- `/clients/{clientId}/passwords` for encrypted client credentials
- `/clients/{clientId}/financial-data` for client financial data
- `/client_import` for spreadsheet import
- `/admin/users` for user administration
- `/admin/notices` for notice management
- `/audit-logs` for audit review
- `/internal-applications` for the internal app landing page
- `/wealixir-policies` for the policies page

## Database overview

### Main tables

- `users`
- `clients`
- `passwords`
- `financial_data`
- `notices`
- `notice_likes`
- `notice_comments`
- `audit_logs`
- Spatie permission tables

### Client fields

The client schema is created in [database/migrations/2024_11_06_094626_create_clients_table.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/database/migrations/2024_11_06_094626_create_clients_table.php) and later relaxed by [database/migrations/2026_02_07_000001_make_client_fields_nullable.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/database/migrations/2026_02_07_000001_make_client_fields_nullable.php).

Important fields:

- Identity and grouping: `family_code`, `client_code`, `family_head`, `client_name`, `pan_card_number`
- Dates: `dob`, `doa`, `date_of_join`, `close_date`
- Ownership: `rm`, `rm_user_id`, `partner`
- Contact: primary and secondary mobile/email fields
- Address: `address`, `city`, `state`, `zip_code`
- Metadata: `category`, `referred_by`, `tax_status`, `notes`

### Financial data fields

The `financial_data` table supports:

- Insurance: `life`, `health`, `pa`, `critical`, `motor`, `general`
- Investments: `fd`, `mf`, `pms`
- Tax and compliance: `income_tax`, `gst`, `tds`, `pt`, `vat`, `roc`, `cma`
- Other services: `accounting`, `others`

## Import format

Client import uses heading rows. Supported headings are derived from [app/Imports/ClientsImport.php](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/app/Imports/ClientsImport.php):

- `account_type`
- `family_code`
- `client_code`
- `family_head`
- `abbr`
- `client_name`
- `gender`
- `pan_card_number`
- `dob`
- `doa`
- `date_of_join`
- `close_date`
- `category`
- `rm`
- `partner`
- `primary_mobile_number`
- `primary_email_number`
- `secondary_mobile_number`
- `secondary_email_number`
- `address`
- `city`
- `state`
- `zip_code`
- `referred_by`
- `tax_status`
- `notes`

Notes:

- Date columns may be standard date strings or Excel numeric serial dates.
- `pan_card_number` must remain unique.
- Import logic currently maps the textual `rm` field but does not assign `rm_user_id`.

## Local setup

### Prerequisites

- PHP 8.0+
- Composer
- Node.js and npm
- A database supported by Laravel

### Install

```bash
composer install
npm install
```

### Environment

The current [.env.example](C:/Users/techl/OneDrive/Desktop/Wealixir-crm-main/.env.example) is not a valid Laravel environment template. Create `.env` manually for now using normal Laravel 9 settings.

At minimum configure:

- `APP_NAME`
- `APP_ENV`
- `APP_KEY`
- `APP_DEBUG`
- `APP_URL`
- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `FILESYSTEM_DISK=public`

Then generate the app key:

```bash
php artisan key:generate
```

### Database and storage

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Why `storage:link` matters:

- Notice banners are stored on the `public` disk.
- Without the symlink, uploaded banners will not be publicly reachable.

### Development servers

Run the Laravel app:

```bash
php artisan serve
```

Run the Vite dev server in a second terminal:

```bash
npm run dev
```

For production assets:

```bash
npm run build
```

## Creating the first admin user

The seeders do not create a default user account. If you want the seeded admin promotion logic to apply automatically, create a user with the email `admin@wealixir.com` before running `php artisan db:seed`.

If a user already exists and needs admin access later, assign the role manually, for example through Tinker:

```bash
php artisan tinker
```

```php
$user = App\Models\User::where('email', 'admin@wealixir.com')->first();
$user->assignRole('admin');
```

## Testing

The project is configured for Pest and PHPUnit.

```bash
php artisan test
```

Current state of the test suite in the repository:

- Mostly Laravel Breeze auth/profile tests
- No meaningful coverage yet for CRM-specific features such as clients, imports, notices, password reveal, permissions, or audit logging

## Project structure

```text
app/
  Http/Controllers/        Web controllers for CRM, admin, auth, imports, notices
  Imports/                 Excel and CSV import mapping
  Models/                  Eloquent models
  Observers/               Audit observer
  Providers/               Service providers and rate limiters
database/
  migrations/              Schema for CRM, audit, notice, and permission tables
  seeders/                 Roles and permissions seeders
resources/
  css/                     Tailwind entrypoint
  js/                      Vite/Alpine entrypoint
  views/                   Blade templates
routes/
  web.php                  Main web routes
tests/
  Feature/, Unit/          Pest test suites
```

## Operational notes and caveats

- `.env.example` should be fixed before relying on onboarding automation.
- Passwords are encrypted at rest, but the reveal endpoint returns plaintext JSON to authenticated users who pass password confirmation.
- Audit logging excludes hidden attributes such as model `password` fields, but other sensitive non-hidden attributes should still be reviewed carefully.
- Importing clients with only the `rm` text column does not automatically establish ownership through `rm_user_id`.
- The repository currently contains only limited automated coverage for CRM-specific behavior.

## Recommended next improvements

- Replace `.env.example` with a valid Laravel template for predictable setup.
- Add feature tests for role scoping, password reveal, import validation, notices, and audit logs.
- Add a documented sample import file for client onboarding.
- Add seed data for a local demo admin account and example CRM records if that fits your deployment process.
