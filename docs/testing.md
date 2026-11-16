# 🧪 Testing and Quality

The repository uses Pest with Laravel's PHPUnit integration. Frontend production build runs `vue-tsc` before Vite.

## Commands

```powershell
php artisan test
vendor/bin/pint --test
npm run build
```

- `php artisan test`: runs Pest/PHPUnit.
- `vendor/bin/pint --test`: checks PHP formatting without modifying files.
- `npm run build`: performs Vue/TypeScript checking and builds assets.

## Test database safety

The SQLite overrides in `phpunit.xml` are commented out. Tests may inherit DB environment values. Feature tests refresh database state, so configure a disposable test database and verify the active connection before running. Never point tests at production or valuable local data.

## Existing coverage

The checked-in suite covers authentication, email verification, password confirmation/reset/update, registration and profile flows, plus example tests. Do not infer coverage for post ownership, rich HTML sanitization, uploads, visibility, social actions or notification behavior unless an explicit test exists.

## Recommended post lifecycle matrix

| Scenario | Expected result |
|---|---|
| Guest opens create route | Redirect to login |
| Unverified user opens create route | Verification middleware blocks access |
| Verified user saves draft | Record belongs to current user and is draft |
| Published post has empty content | Server rejects publication |
| Image exceeds 2 MB | Request rejected |
| Unsupported image MIME/content | Request rejected |
| Guest queries feed | Only published posts appear |
| User queries feed | Published plus own non-published posts appear |
| Guest opens unpublished post | Denied/not found according to policy |
| Owner updates own post | Allowed after implementation |
| Another user updates post | Forbidden |
| Rich HTML contains script/event payload | Sanitizer blocks executable markup |
| Account deletion | DB and file cleanup follow documented policy |

These are target tests, not claims that the scenarios currently pass.

## CI quality sequence

1. Install PHP dependencies from Composer lockfile.
2. Run Pint and PHP syntax checks.
3. Provision a disposable DB and run tests.
4. Install Node dependencies with `npm ci`.
5. Run `npm run build`.
6. Validate docs links and Mermaid sources.
7. Run dependency and secret scans with least-privilege permissions.

Never make CI green by skipping a failing check that reveals a genuine defect.
