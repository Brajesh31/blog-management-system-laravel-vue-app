# Development

Read [Installation](installation.md) to configure dependencies, `.env`, and a local database. This page describes the normal change and verification workflow.

## Run the application

For frontend hot reload, use two terminals from the repository root:

```powershell
php artisan serve
```

```powershell
npm run dev
```

Alternatively, `composer run dev` starts the Laravel server, database-backed queue listener, Pail log viewer, and Vite through Composer's `dev` script. Use `npm run build` when you need to verify the compiled production assets and TypeScript types.

## Where changes belong

- Add or change HTTP endpoints in `routes/web.php` or `routes/auth.php`. The app does not currently define a separate API route file.
- Put request handling in `app/Http/Controllers/`; validate input with an existing or new Form Request under `app/Http/Requests/`.
- Put persistent domain behavior and relationships in `app/Models/` and schema changes in `database/migrations/`.
- Add Inertia page components under `resources/js/Pages/`, reusable Vue components under `resources/js/Components/`, and shared layout behavior under `resources/js/Layouts/`.
- Keep Inertia response prop names and shapes synchronized with TypeScript declarations and Vue page interfaces.
- Put automated behavior coverage in `tests/Feature/` or `tests/Unit/`. Tests are written with Pest and use Laravel's testing helpers.

The [Architecture](architecture.md) guide describes the request flow. The [Database](database.md) guide lists the current tables and relationships.

## Backend and data changes

- Validate all user input on the server, even when a Vue form also validates it.
- Check authentication, email verification, and resource ownership at the route or controller/policy boundary. A hidden or disabled frontend control is not an access check.
- Treat stored TipTap HTML and uploaded files as untrusted input. Choose safe rendering and storage behavior before enabling those features for real users.
- For schema changes, add a new reversible migration instead of rewriting a migration that may have run elsewhere. Consider existing rows, foreign keys, indexes, and deletion behavior.
- Use factories for isolated test records. Review the seeders before running them: `php artisan db:seed` generates 30 users and 50 posts and must be limited to a disposable local database.

## Frontend changes

- The frontend entry point is `resources/js/app.ts`; Vite configuration is in `vite.config.js`.
- Follow existing Vue 3 and TypeScript patterns and keep interactive controls usable by keyboard and on narrow screens.
- Show validation errors and meaningful loading, empty, and failure states for each workflow.
- Do not rely on client-side checks to protect private data or authorize a server operation.

## Checks before submitting a change

Run the checks relevant to the change:

```powershell
php artisan test
vendor/bin/pint --test
npm run build
```

`npm run build` runs `vue-tsc` and Vite. PHP formatting is provided by Laravel Pint; there is no separate project formatter script. Configure PHPUnit to use a dedicated disposable test database before running feature tests: the SQLite environment overrides in `phpunit.xml` are commented out, and feature tests refresh database state. Never run tests against production or a local database with data you need.

Report commands that could not be run and include manual verification details in the pull request. Follow [Contributing](../CONTRIBUTING.md) for review expectations.
