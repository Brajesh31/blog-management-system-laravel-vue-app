# Troubleshooting

Start by checking the command output and Laravel log. For local development, use `composer run dev` to see the web server, queue listener, Pail output, and Vite process together. The default Laravel log is under `storage/logs/`. Remove passwords, tokens, personal data, and private post content before sharing logs in an issue.

## Application fails to start

- Confirm PHP is 8.2 or newer and Composer dependencies are installed with `composer install`.
- Confirm Node.js/npm are available and install frontend dependencies with `npm ci`.
- If Laravel reports that the application key is missing, run `php artisan key:generate` only for the intended local `.env`.
- Verify that the web server or `php artisan serve` points to the repository's `public/` directory as the web root.

## Database connection or migration errors

- Check that the database server is running, the database exists, and `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env` match it.
- After changing environment values, clear stale local configuration with `php artisan config:clear`.
- Check migration state with `php artisan migrate:status`; apply pending local migrations with `php artisan migrate`.
- The default session, cache, and queue drivers use database tables. Confirm the relevant migrations have run when those drivers are enabled.
- Avoid `migrate:fresh`, `migrate:refresh`, or rollback commands on a database with data you need. These commands can delete or change data.

## Feature tests connect to the wrong database

The database environment overrides in `phpunit.xml` are commented out. Tests may inherit database settings from `.env` or the process environment, while feature tests refresh database state. Configure a dedicated disposable test database or deliberately enable a separate SQLite test connection before running tests. Do not use production credentials or a database containing valuable data.

## Vite assets are missing

- For development, run `npm run dev` in a separate terminal and keep it running while browsing.
- For a built deployment, install dependencies and run `npm run build`; confirm `public/build/manifest.json` exists in the deployed release.
- If dependency installation appears inconsistent with the lockfile, use `npm ci` rather than `npm install`.
- Check the browser console and the Laravel response for the first missing asset or JavaScript error.

## A post route errors or shows no page

The `GET /posts` controller currently renders an Inertia component named `Posts/Index`, but that Vue page is absent from the repository. Running Vite or clearing cache will not create the missing page. The post detail, edit, update, and delete controller actions are also unfinished. See [HTTP routes](api.md) and the [Roadmap](../ROADMAP.md).

## Login or email verification behavior is unexpected

- The dashboard and post creation routes require an authenticated user with verified email.
- The username profile route is also currently behind authentication.
- Check that cookies are accepted, the session driver is configured, and the `sessions` table exists when using database sessions.
- For local development, `MAIL_MAILER=log` writes mail to the application log instead of sending it. Configure a real mail transport to test delivery.
- Behind a reverse proxy, configure trusted proxies and HTTPS consistently; do not weaken cookie settings to work around a production proxy problem.

## Image upload or image URL fails

- The post creation request accepts JPEG, PNG, JPG, GIF, and WebP images up to 2 MB.
- Confirm `storage/` is writable by the PHP runtime and the `public` disk is configured.
- Run `php artisan storage:link` for local public-disk uploads and verify the generated link points to `storage/app/public`.
- A file being accepted by validation does not make its content safe to display. Keep uploads on the intended disk and review access rules before production use.

## Queue jobs do not run

The sample queue driver is database-backed. Confirm migrations have created the `jobs` table and run a supervised queue worker in the environment that should process work. Inspect failed jobs and application logs. Do not run development log or queue processes as a production service without proper supervision.

For production issues, keep debug mode disabled and follow the safer operational checks in [Deployment](deployment.md) and [Security](../SECURITY.md).
