# Deployment

This guide covers a deliberate deployment to a PHP web host. It is not a provider-specific recipe. Test the release in a staging environment and review [SECURITY.md](../SECURITY.md) before handling real accounts or content.

## Readiness

The application is still in progress. The post listing points to a Vue page that is not present, post detail/edit/update/delete actions are unfinished, and ownership authorization and rich-HTML sanitization need work. Review the [README implementation status](../README.md#current-implementation) and complete the controls required by your use case before exposing unfinished workflows to users.

Prepare:

- A supported PHP 8.2+ runtime with required extensions, Composer, a database, and a web server or PHP-FPM host.
- A build environment with Node.js/npm for compiling Vite assets, or a CI artifact containing the built `public/build` directory.
- A persistent database, restricted application database user, HTTPS certificate, and a reliable backup/restore process.
- A secret store or protected environment configuration for `APP_KEY`, database credentials, and mail credentials.

## Build the release artifact

From the release checkout, install locked dependencies and build the frontend:

```powershell
composer install --no-dev --prefer-dist --optimize-autoloader
npm ci
npm run build
```

If the deployment image does not include Node.js, build the frontend in CI and include the generated `public/build` assets in the release artifact. Do not commit `node_modules/` or a developer's local build state.

## Configure the production environment

Set production-specific variables outside version control. At minimum:

```text
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.example
```

Configure the production database connection, mail transport, log destination, filesystem, queue, cache, and session settings for your host. The sample uses MySQL and database-backed sessions/cache/queues. Confirm the `sessions`, `cache`, and `jobs` tables exist before selecting those drivers. Use HTTPS, secure session cookies, trusted proxy/host settings appropriate to the host, and a least-privilege database account.

Set `APP_KEY` once for the environment and keep it stable across routine deployments. Do not publish it. Rotating it deliberately can invalidate encrypted data and sessions; plan and test rotation separately. Configure a real mail provider before relying on email verification or password reset delivery; the sample `log` mailer does not send email.

## Release steps

1. Back up the database and any required user files, and verify that a restore procedure is available.
2. Deploy the release with the web server document root set to the Laravel `public/` directory. Do not expose the repository root, `.env`, `storage/`, or `vendor/` through the web server.
3. Ensure `storage/` and `bootstrap/cache/` are writable by the application runtime and are not broadly writable by other users.
4. Run database migrations as a controlled deployment step:

   ```powershell
   php artisan migrate --force
   ```

5. If using the public filesystem disk for post images, run `php artisan storage:link` and confirm the host serves only the intended public files. Do not place private uploads on a publicly reachable disk.
6. Rebuild framework caches as appropriate for the release, then restart PHP workers and any supervised queue workers so they load the new code.
7. Verify the `/up` health endpoint, authentication, mail delivery, database access, logs, and the exact user flows that the deployment enables.

The sample queue driver is `database`. If the deployed application dispatches queued work, run a supervised worker such as `php artisan queue:work` and monitor failed jobs. The current repository does not declare application-specific scheduled tasks; configure a scheduler only if scheduled work is added.

## Operations

- Monitor application and web-server errors without recording passwords, tokens, private post content, or other unnecessary personal data.
- Apply security updates to the runtime and locked dependencies through review and staging.
- Back up the database and required files, and periodically test restoration.
- Review database migration impact before deployment; do not assume every migration can be rolled back without data loss.
- Keep secrets, backups, logs, and uploaded user files outside public source control.

Use [Troubleshooting](troubleshooting.md) for safe diagnostics. Never run destructive database commands against production as a debugging shortcut.
