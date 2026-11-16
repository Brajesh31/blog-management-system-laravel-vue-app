# 🗂️ Project Structure and File Responsibilities

This map reflects the repository tree at the time of review. It is grouped for readability; the UI subcomponent inventory is fully enumerated in [Components](components.md). A directory's presence does not guarantee a complete product workflow.

## Root-level layout

```text
.
├── .github/
│   ├── ISSUE_TEMPLATE/       # Bug, feature, documentation forms and contact links
│   ├── workflows/            # Quality, dependency/secret checks, README timestamp automation
│   └── PULL_REQUEST_TEMPLATE.md
├── app/                      # Laravel application code
├── assets/                   # Project documentation visuals and capture guidance
├── bootstrap/                # Laravel bootstrap and providers
├── config/                   # Application/framework configuration
├── database/                 # Migrations, factories and seeders
├── docs/                     # Product, design, security, operations and engineering docs
├── public/                   # Laravel web root and public assets
├── resources/                # CSS, Vue/TypeScript and Blade views
├── routes/                   # web, auth and console route definitions
├── storage/                  # Runtime files and storage placeholders
├── tests/                    # Pest feature and unit tests
├── artisan
├── composer.json / composer.lock
├── package.json / package-lock.json
├── phpunit.xml
├── tsconfig.json
└── vite.config.js
```

## Backend source tree

### Controllers
- `app/Http/Controllers/Controller.php`: base controller.
- `app/Http/Controllers/PostController.php`: post listing query and create/store actions; detail/edit/update/destroy remain unfinished.
- `app/Http/Controllers/ProfileController.php`: authenticated profile edit/update/delete.
- `app/Http/Controllers/UserProfileController.php`: username lookup and profile Inertia response.
- `app/Http/Controllers/Auth/`: Laravel Breeze-style session login, registration, email verification, password confirmation/reset and password update controllers.

### Requests and middleware
- `app/Http/Requests/StorePostRequest.php`: post create validation (title, content, image and visibility).
- `app/Http/Requests/ProfileUpdateRequest.php`: profile update validation.
- `app/Http/Requests/Auth/LoginRequest.php`: login validation/authentication.
- `app/Http/Middleware/HandleInertiaRequests.php`: shared Inertia props.

### Models
- `User.php`: account identity, hashed password and profile relationships.
- `Post.php`: content, visibility, slug and relationships.
- `Comment.php`: post/user association and parent/reply relation.
- `Like.php` and `Bookmark.php`: user/post interaction records.
- `Tag.php`: post-tag many-to-many relation.
- `Notification.php`: recipient/sender and optional post/comment references.

### Bootstrap and providers
- `bootstrap/app.php`: Laravel routing/middleware/health endpoint setup.
- `bootstrap/providers.php`: application provider registration.
- `app/Providers/AppServiceProvider.php`: application service provider.
- `artisan`: CLI entry point.

## Database files

### Migrations
- `0001_01_01_000000_create_users_table.php`: users and password reset records.
- `0001_01_01_000001_create_cache_table.php`: database cache/lock storage.
- `0001_01_01_000002_create_jobs_table.php`: queue jobs, batches and failures.
- `2025_04_08_151547_add_username_and_profile_pic_to_users_table.php`: user profile fields.
- `2025_04_10_094952_create_posts_table.php`: post data and visibility.
- `2025_04_10_095950_create_tags_table.php`: tags.
- `2025_04_10_100001_create_post_tag_table.php`: tag pivot.
- `2025_04_10_100006_create_comments_table.php`: comments and parent references.
- `2025_04_10_100027_create_likes_table.php`: likes.
- `2025_04_10_100033_create_bookmarks_table.php`: bookmarks.
- `2025_04_10_100042_create_notifications_table.php`: notification records.

### Factories and seeders
- `database/factories/UserFactory.php`: synthetic account details; uses a shared test-only password.
- `database/factories/PostFactory.php`: generated post content, visibility and Faker image URL.
- `database/seeders/DatabaseSeeder.php`: invokes user and post seeders.
- `UserSeeder.php`: creates 30 users.
- `PostSeeder.php`: creates 50 posts.

The factory password is not a production credential. Run seeders only on disposable development databases. The PostFactory expects at least one user to exist when selecting a random user.

## Frontend source tree

### Entry points and layout
- `resources/js/app.ts`: Vue/Inertia bootstrap.
- `resources/js/bootstrap.ts`: browser bootstrap helpers.
- `resources/js/Layouts/MainLayout.vue`: app shell, navbar, mobile menu, toaster and footer.
- `resources/views/app.blade.php`: Blade document hosting Inertia.
- `resources/css/app.css`: Tailwind and app styles.

### Pages
- `Pages/Home.vue` and `Pages/Dashboard.vue`: home and authenticated dashboard.
- `Pages/Auth/`: login, register, forgot/reset password, verification and confirmation screens.
- `Pages/Profile/Edit.vue`, `Show.vue` and `Partials/`: profile display/edit/delete/password forms.
- `Pages/Posts/Create.vue`: post authoring form.
- **Missing target:** `Pages/Posts/Index.vue` is referenced by the post controller but absent.

### Components and state
- `Components/auth/`: login and registration modal components.
- `Components/home/`: community join and challenges cards.
- `Components/layouts/main/`: navbar, mobile sheet, search bar, user menu and notification popover.
- `Components/tiptap/`: editor and toolbar.
- `Components/ui/`: shared alert, avatar, button, card, checkbox, dialog, dropdown, form, input, label, popover, separator, sheet and toast primitives.
- `hooks/useAuth.ts`: authentication composable.
- `stores/modal.ts`: modal state.
- `lib/utils.ts`: frontend helpers.
- `types/`: global, app and Vite TypeScript declarations.

MainLayout contains placeholder notification state and no-op search/notification handlers. See [Components](components.md).

## Public files

- `public/index.php`: Laravel HTTP entry point.
- `public/.htaccess`: Apache rewrite rules.
- `public/robots.txt`: crawler directives.
- `public/favicon.ico`: browser favicon.
- `public/images/blogx-logo.png`: existing project logo image.
- `public/build/`: generated Vite assets when a production build is created; generated artifacts should not be confused with source.

## Configuration files

| File | Responsibility |
|---|---|
| `.env.example` | Local environment template |
| `.editorconfig` | Editor whitespace conventions |
| `.gitattributes` | Git text/binary handling |
| `.gitignore` | Excludes local environment, dependencies and generated files |
| `composer.json` / `composer.lock` | PHP dependency declarations and exact resolution |
| `package.json` / `package-lock.json` | npm dependency declarations and exact resolution |
| `vite.config.js` | Laravel and Vue Vite plugins |
| `tsconfig.json` | TypeScript compiler configuration |
| `phpunit.xml` | PHPUnit/Pest test environment |
| `postcss.config.js` | PostCSS/Tailwind integration |
| `components.json` | UI component generator metadata |

Important framework files under config include app, auth, cache, database, filesystems, logging, mail, queue, services and session settings.

## Tests

- `tests/Pest.php`: shared Pest test configuration.
- `tests/TestCase.php`: Laravel test base.
- `tests/Feature/Auth/`: authentication, verification, password confirmation/reset/update and registration tests.
- `tests/Feature/ProfileTest.php`: profile behavior tests.
- `tests/Feature/ExampleTest.php` and `tests/Unit/ExampleTest.php`: example tests.

Post authorization, visibility edge cases, upload lifecycle and rich-HTML sanitization require dedicated tests.

## Documentation and assets
- `docs/`: documentation index, product overview, architecture/system design, project structure, modules/components/features, workflows/data flow, installation/configuration/usage, routes/database, testing, security/privacy/accessibility, performance, deployment/operations, troubleshooting, risk/debt registers, references and ADRs.
- `docs/diagrams/*.mmd`: editable Mermaid source diagrams.
- `assets/banners/`, `logos/`, `illustrations/`: original SVG artwork.
- `assets/screenshots/` and `assets/demos/`: capture guidance only until authentic app captures are supplied.
- `assets/charts/`: reserved for measured data; no fabricated analytics are stored.

## Naming and extension conventions

- PHP classes use StudlyCase and PSR-4 namespaces.
- Vue single-file components use PascalCase filenames.
- TypeScript modules use camelCase or descriptive lowercase names consistent with existing files.
- Migrations use timestamp-prefixed descriptive names.
- Docs use lowercase kebab-case Markdown paths.
- Reusable visual assets should use descriptive filenames and meaningful alt text.

For the full component inventory see [Components](components.md); for the backend/frontend module map see [Modules](modules.md).
