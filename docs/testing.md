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

## Observed CI baseline (2026-11-16)

The repository's current quality workflow was executed against the documentation-enhancement branch. The PHP syntax check and changed-file Pint check passed, but the full test suite did not.

The observed test summary was **13 failed, 11 warnings, 1 passed (49 assertions)**. Visible failures included:
- Some authentication screens returned redirects or 404 responses where the existing tests expected HTTP 200.
- Some password-confirmation, password-update and account-deletion tests submitted `password`, while the current UserFactory uses a different shared development password. Align the fixtures and tests deliberately; do not weaken password checks.
- Several page-rendering tests failed because `public/build/manifest.json` was absent. The normal frontend build currently fails earlier on case-sensitive label imports, so the test environment does not yet have a valid compiled manifest.

These are existing test/application configuration problems, not failures caused by documentation files. The exact output should be refreshed after the corresponding fixes. Do not mark the test suite as passing until a clean workflow run proves it.
