# Installation

This guide sets up the application for local development. It does not configure a production deployment; use [Deployment](deployment.md) for that.

## Prerequisites

- PHP 8.2 or newer with the extensions required by Laravel 12, including PDO and the driver for your database.
- Composer.
- Node.js and npm compatible with the Vite 6 toolchain in `package-lock.json`.
- MySQL or another Laravel-supported database. MySQL is the sample configuration.
- Git, if you are cloning the repository.

Check the installed tools:

```powershell
php --version
composer --version
node --version
npm --version
```

## Get the source and install dependencies

```powershell
git clone https://github.com/Brajesh31/blog-management-system-laravel-vue-app.git
Set-Location blog-management-system-laravel-vue-app
composer install
npm ci
```

`composer install` installs the locked PHP dependencies. `npm ci` installs the exact JavaScript dependency versions from `package-lock.json`.

## Configure the local environment

Create a local environment file from the safe template:

```powershell
Copy-Item .env.example .env
```

Edit `.env` and set `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` for your local database. For MySQL, create a dedicated database and a local application user, for example:

```sql
CREATE DATABASE blog_management_system_laravel_vue_app
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'blog_app'@'localhost' IDENTIFIED BY 'choose-a-local-password';
GRANT ALL PRIVILEGES ON blog_management_system_laravel_vue_app.* TO 'blog_app'@'localhost';
```

Use a unique local password; do not copy production credentials into `.env`. The sample uses `MAIL_MAILER=log`, which records outgoing mail in the Laravel log instead of sending it. Set a real mail provider only when you need to test delivery.

Generate the application key and create the schema:

```powershell
php artisan key:generate
php artisan migrate
```

Post images are stored on Laravel's `public` filesystem disk. If you are testing image uploads, create the public storage link once:

```powershell
php artisan storage:link
```

## Optional generated development data

The repository seeders create synthetic records: 30 users and 50 posts. The user factory assigns the same development password (`password123`) to factory-created users. Run seeders only against a disposable local database, never against production or a database containing real accounts:

```powershell
php artisan db:seed
```

Review `database/seeders/` and `database/factories/` before using the generated accounts. The sample data is for development and is not a set of production credentials.

## Build and start the application

Build the frontend once:

```powershell
npm run build
```

For active development, run the application and Vite in separate terminals:

```powershell
php artisan serve
```

```powershell
npm run dev
```

The Composer `dev` script starts the Laravel development server, a queue listener, Pail logs, and Vite together:

```powershell
composer run dev
```

Open the local URL printed by Artisan, usually `http://127.0.0.1:8000`. The development server is not intended to be exposed to the public internet.

## Testing database configuration

`phpunit.xml` selects the testing app environment and in-memory cache, mail, queue, and session drivers. Its SQLite `DB_CONNECTION` and `DB_DATABASE` overrides are commented out, so tests can otherwise inherit database settings from the process or local environment. Before running feature tests, configure a separate disposable test database (or deliberately enable an appropriate SQLite test connection). Never point tests at a database containing data you need; the feature suite uses database refresh behavior.

See [Development](development.md) for the day-to-day workflow and [Troubleshooting](troubleshooting.md) for common setup issues.
