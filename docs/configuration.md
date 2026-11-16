# ⚙️ Configuration

Laravel reads runtime settings from environment variables and files in `config/`. Keep local, test, staging and production values isolated.

## Create local environment

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Never commit `.env`, `APP_KEY`, database/mail credentials, session identifiers or database dumps.

## Important setting groups

| Variable group | Purpose | Guidance |
|---|---|---|
| `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_DEBUG`, `APP_URL` | App identity, mode, encryption, debug and URL | Production uses `APP_ENV=production`, `APP_DEBUG=false`, HTTPS |
| `LOG_CHANNEL`, `LOG_LEVEL` | Application logging | Avoid private content and secrets in logs |
| `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Database | Dedicated least-privilege DB user; separate test DB |
| `SESSION_DRIVER`, `SESSION_LIFETIME`, `SESSION_ENCRYPT` | Session persistence | Use secure cookie settings and reasonable lifetime |
| `CACHE_STORE` | Cache backend | Database store requires migrations |
| `QUEUE_CONNECTION` | Queue backend | Database queue requires tables and a worker |
| `FILESYSTEM_DISK` | Default storage | Review visibility of user files |
| `MAIL_MAILER` and mail credentials | Email delivery | Example uses log mailer, not real delivery |

Check the actual `.env.example` and matching `config/*.php` for exact defaults; do not assume an unrelated Laravel project's variables are used here.

## Database and mail

MySQL is the sample database configuration. Create a dedicated schema and account, then set the connection values. The example `MAIL_MAILER=log` writes mail to Laravel logs. It does not deliver verification or reset emails. Configure and test a real provider before relying on email delivery.

## Uploaded media

The current post creation controller stores images on the `public` disk at `uploads/posts`. Local development normally needs `php artisan storage:link`. Public disk storage is not suitable for private media. Define access control, retention, orphan cleanup and backup behavior before launch.

## Test isolation

The SQLite overrides in `phpunit.xml` are commented out. Configure a dedicated disposable test DB before running feature tests. Never let tests target production or valuable local data.

## Checklist

- [ ] Local `.env` is untracked and restricted.
- [ ] Each environment has a separately generated key.
- [ ] Production debug is off and HTTPS is enabled.
- [ ] DB user has least privileges.
- [ ] Mail transport is real where needed and tested.
- [ ] Session/cache/queue services and tables are ready.
- [ ] Upload visibility and retention are intentional.
- [ ] Test DB is isolated from production.
