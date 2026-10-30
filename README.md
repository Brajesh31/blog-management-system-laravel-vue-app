# Blog Management System

Blog Management System is a Laravel application with a Vue 3 and TypeScript interface rendered through Inertia.js. The repository contains account and profile flows, a post creation flow, post and social-feature database models, and the Laravel/Vite development setup.

> **Project status:** this repository is an in-progress application. Some routes and database structures are present before their corresponding pages or controller behavior are complete. See [Current implementation](#current-implementation) before relying on a feature.

## Contents

- [Technology](#technology)
- [Requirements](#requirements)
- [Install and run locally](#install-and-run-locally)
- [Current implementation](#current-implementation)
- [Repository layout](#repository-layout)
- [Tests and build](#tests-and-build)
- [Documentation](#documentation)
- [Security](#security)
- [Contributing](#contributing)
- [License](#license)

## Technology

- PHP 8.2 or newer and Laravel 12
- Inertia.js 2, Vue 3, and TypeScript
- Vite 6, Tailwind CSS 4, Pinia, and TipTap
- MySQL as the default application database
- Laravel Breeze authentication scaffolding, Pest, and PHPUnit

The server routes and controllers are in `routes/` and `app/Http/`. Inertia pages and components are in `resources/js/`. There is no separate REST API implementation in this repository.

## Requirements

Install PHP 8.2+, Composer, Node.js with npm, and a supported database server. For the default configuration, create a MySQL database and a database user for the application. Composer and npm dependencies are described in `composer.lock` and `package-lock.json`.

## Install and run locally

From the repository root, install dependencies and create the local environment file:

```powershell
composer install
npm ci
Copy-Item .env.example .env
```

Update `.env` with the local database name, username, and password. Then generate the application key, migrate the database, and build the frontend:

```powershell
php artisan key:generate
php artisan migrate
npm run build
```

Start the Laravel server with `php artisan serve` and, in a second terminal, run `npm run dev`. The Composer `dev` script can also start the Laravel server, queue listener, Pail log viewer, and Vite together:

```powershell
composer run dev
```

The sample environment uses the `log` mailer, so mail is written to application logs during local development. Configure a real mail transport before enabling email delivery outside development. See [Installation](docs/installation.md) for database setup and additional details.

## Current implementation

The code and database currently provide these areas:

| Area | Current state |
| --- | --- |
| Registration, login, logout, email verification, password reset and confirmation | Laravel authentication routes and controllers are present; feature tests cover the core flows. |
| Own profile | Authenticated profile edit, update, and account deletion routes are implemented. |
| Username profile | A profile controller and page exist, but the route is currently inside the authenticated route group. |
| Post creation | Verified users can submit a title, TipTap HTML content, optional image, and draft/published visibility. The request validates images up to 2 MB. |
| Post feed | A paginated/searching controller action exists, but it renders `Posts/Index`, which is not currently present under `resources/js/Pages/`. |
| Post detail and editing | Routes exist, but the `show`, `edit`, `update`, and `destroy` controller actions are unfinished. |
| Comments, likes, bookmarks, tags, notifications | Migrations and Eloquent relationships exist; complete route and interface workflows are not currently wired up. |

Treat the feature list as an implementation snapshot, not a promise that every route is production-ready. In particular, post ownership policies and sanitization of rich HTML content need attention before the post lifecycle is exposed in production. The [Roadmap](ROADMAP.md) tracks the known next steps.

## Repository layout

```text
app/                 Laravel controllers, requests, middleware, models
bootstrap/           Laravel application bootstrap
config/              Framework and service configuration
database/             Migrations, factories, and seeders
docs/                 Installation, architecture, API, and operations docs
resources/js/         Inertia Vue pages, components, and TypeScript
resources/css/        Tailwind application stylesheet
routes/               Web, authentication, and console routes
tests/                Pest feature and unit tests
```

## Tests and build

Run the Laravel test suite with:

```powershell
php artisan test
```

Build the frontend with:

```powershell
npm run build
```

The build script runs `vue-tsc` before Vite. `phpunit.xml` configures the testing environment, but its SQLite database overrides are commented out. Configure a separate disposable test database (or deliberately enable a separate SQLite test connection) before running feature tests, which refresh database state. See [Installation](docs/installation.md#testing-database-configuration).

## Documentation

- [Architecture](docs/architecture.md)
- [Installation](docs/installation.md)
- [Development](docs/development.md)
- [Deployment](docs/deployment.md)
- [HTTP routes](docs/api.md)
- [Database](docs/database.md)
- [Troubleshooting](docs/troubleshooting.md)
- [FAQ](docs/faq.md)

## Security

Do not commit `.env`, credentials, production data, or private uploads. Use HTTPS, disable debug mode in production, restrict database access, and review the known authorization and rich-content gaps before deployment. Read [SECURITY.md](SECURITY.md) for the reporting process and deployment guidance.

## Contributing

Bug reports and focused contributions are welcome. Read [CONTRIBUTING.md](CONTRIBUTING.md) before opening a pull request. Please use the private reporting guidance in [SECURITY.md](SECURITY.md) for suspected vulnerabilities.

## License

This project is distributed under the MIT License. See [LICENSE](LICENSE) for the complete terms.

Last updated: 2026-10-30 21:18 UTC
