# 🗂️ Project Structure

This is an orientation map of the repository as observed. A directory's presence does not guarantee a complete product feature.

```text
.
├── app/
│   ├── Http/Controllers/       # Auth, profile, user profile and post controllers
│   ├── Http/Middleware/        # Shared Inertia props
│   ├── Http/Requests/          # Server-side validation
│   ├── Models/                 # User, Post, Comment, Like, Bookmark, Tag, Notification
│   └── Providers/
├── bootstrap/                  # Laravel application bootstrap
├── config/                     # Laravel configuration
├── database/
│   ├── factories/              # Synthetic records for tests/development
│   ├── migrations/             # Database schema
│   └── seeders/                # Development seed data
├── docs/                       # Project guides, diagrams and ADRs
├── public/                     # Web entry point and built/static assets
├── resources/
│   ├── css/                    # Tailwind styles
│   ├── js/
│   │   ├── Components/         # Reusable Vue controls and editor
│   │   ├── Layouts/            # Shared page layouts
│   │   ├── Pages/              # Inertia page components
│   │   ├── hooks/              # Composables
│   │   ├── lib/                # Frontend utilities
│   │   ├── stores/             # Pinia state
│   │   └── types/              # TypeScript declarations
│   └── views/                  # Blade Inertia root document
├── routes/                     # web.php, auth.php, console.php
├── storage/                    # Runtime files and placeholders
├── tests/
│   ├── Feature/                 # Auth/profile/application feature tests
│   └── Unit/
├── .github/
│   ├── ISSUE_TEMPLATE/          # Structured issue forms
│   ├── workflows/               # CI and automation
│   └── PULL_REQUEST_TEMPLATE.md
├── artisan
├── composer.json / composer.lock
├── package.json / package-lock.json
├── phpunit.xml
├── tsconfig.json
└── vite.config.js
```

## Backend map

| Path | Purpose | Current implementation note |
|---|---|---|
| `routes/web.php` | Home, dashboard, profiles and posts | Session-based web routes, not a REST API |
| `routes/auth.php` | Registration, login, reset, verification, password update | Breeze-style flows |
| `app/Http/Controllers/PostController.php` | Feed query and post creation | Feed page missing; lifecycle actions unfinished |
| `app/Http/Requests/StorePostRequest.php` | Post creation validation | Request allows draft/published |
| `app/Models/Post.php` | Post attributes and relationships | TipTap HTML stored as content |
| `app/Models/User.php` | Account attributes and relations | Password hidden and hashed cast configured |
| `database/migrations/` | Relational schema | Review FK cascade rules before data changes |

## Frontend map

| Path | Purpose |
|---|---|
| `resources/js/app.ts` | Inertia/Vue bootstrap |
| `resources/js/Pages/` | Route-level Vue pages |
| `resources/js/Pages/Posts/Create.vue` | Create form, editor, image preview and draft/publish actions |
| `resources/js/Components/` | Reusable Vue controls and TipTap editor |
| `resources/js/Layouts/` | Shared layouts |
| `resources/js/stores/` | Pinia stores |
| `resources/js/types/` | Shared TypeScript types |

## Important runtime files

- `.env.example`: safe starting point; copy to local `.env`, never commit secrets.
- `composer.json`: PHP dependencies and scripts.
- `package.json`: npm dependencies and scripts.
- `vite.config.js`: Laravel/Vue Vite integration.
- `phpunit.xml`: test configuration. Its SQLite overrides are commented out.
- `public/`: only intended web-server document root.

## Known inventory gaps

- `PostController@index` renders missing `Posts/Index`.
- There is no `routes/api.php`.
- Social tables/models are present without complete comment/like/bookmark/tag/notification workflows.
- Post mutation routes must not be assumed safe because they have auth middleware; ownership policies are still required.
- Do not invent screenshots or claim a generated illustration is a capture of the live product.
