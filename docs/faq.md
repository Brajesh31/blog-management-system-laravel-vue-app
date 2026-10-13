# FAQ

## Is this a standalone Vue single-page application?

No. Laravel serves web routes and Inertia responses; Vue components render the pages in the browser. Vite builds the frontend assets.

## Does the project provide a REST or JSON API?

No separate API route file or public JSON API contract is currently defined. The route guide documents the Laravel web routes and their Inertia/session behavior: [HTTP routes](api.md).

## What do I need to run it locally?

PHP 8.2+, Composer, Node.js/npm compatible with the Vite 6 toolchain, and a configured database. MySQL is the sample default. See [Installation](installation.md).

## How do I create a post?

An authenticated user with a verified email can open `/posts/create` and submit a title, content, optional image, and either draft or published visibility. The form and create controller exist. The listing page is currently missing, and the detail/edit/delete actions are unfinished, so the full post lifecycle is not yet available; see the [README](../README.md#current-implementation).

## Are comments, likes, bookmarks, tags, and notifications working features?

The database tables and Eloquent relationships are present, but complete routes and interface workflows for those interactions are not currently wired up. Their presence in the schema should not be read as a claim that the feature is ready to use.

## Why is a username profile asking me to log in?

The current `/{username}` route is inside an authenticated route group. Whether profiles should be public is a product decision tracked in the [Roadmap](../ROADMAP.md).

## Are post URLs based on their slugs?

Post creation generates a unique slug, but the current `{post}` route uses Laravel's default primary-key model binding. Slug-based route binding has not been configured.

## Is there sample data?

`php artisan db:seed` creates 30 synthetic users and 50 synthetic posts. Factory-created users share the development password `password123`. Run the seeder only in a disposable local database, never in production or on real accounts.

## Why are password reset or verification emails not arriving?

The example environment uses `MAIL_MAILER=log`, which writes mail to Laravel logs instead of sending it. Configure a real mail provider to test delivery. Do not place mail credentials in version control.

## Where do uploaded images go?

The post creation controller stores validated images on Laravel's `public` disk under `uploads/posts`. Local public URLs usually require `php artisan storage:link`. The current feature validates accepted image formats and size but the deployment must still set correct storage permissions and access controls.

## What license applies?

The project uses the MIT License; see [LICENSE](../LICENSE).

## Where should I report a bug or security concern?

Use [SUPPORT.md](../SUPPORT.md) for reproducible bugs and help. Report suspected security vulnerabilities privately using the process in [SECURITY.md](../SECURITY.md), not in a public issue.
