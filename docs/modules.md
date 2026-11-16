# 🧱 Module Reference

The repository is organized around Laravel backend modules and Vue/Inertia interface modules.

## Backend modules

| Module | Principal files | Responsibility / boundary |
|---|---|---|
| Authentication | app/Http/Controllers/Auth/*, routes/auth.php, resources/js/Pages/Auth/* | Registration, login, verification, password reset and confirmation |
| Profiles | ProfileController.php, UserProfileController.php, ProfileUpdateRequest.php, Pages/Profile/* | Own profile update/deletion and username profile display |
| Posts | PostController.php, StorePostRequest.php, Models/Post.php, Pages/Posts/Create.vue | Post query and creation; other lifecycle actions unfinished |
| Social data | Models/Comment.php, Like.php, Bookmark.php, Tag.php, Notification.php | Eloquent relations and data structures; complete workflows absent |
| Shared Inertia context | HandleInertiaRequests.php | Adds authenticated user/shared props to Inertia |
| Persistence | database/migrations/*, factories/*, seeders/* | Schema, test data and synthetic development records |

## Frontend modules

| Module | Principal location | Responsibility |
|---|---|---|
| Application bootstrap | resources/js/app.ts and bootstrap.ts | Inertia/Vue and browser setup |
| Layout/navigation | resources/js/Layouts and Components/layouts/main | Main shell, responsive nav, search and user menu |
| Authentication UI | Components/auth and Pages/Auth | Login/register modal and auth pages |
| Home UI | Components/home and Pages/Home.vue | Home-page community/challenge content |
| Post editor | Components/tiptap and Pages/Posts/Create.vue | Rich text, toolbar, image preview and submission |
| Shared UI primitives | Components/ui | Buttons, cards, dialogs, dropdowns, forms, avatar, toast and related controls |
| Auth composable | hooks/useAuth.ts | Current-user/auth state access |
| Modal state | stores/modal.ts | Shared modal state |
| Utilities and types | lib/utils.ts and types/* | Shared helper and TS declarations |

## Module design rules

- Keep business rules on the Laravel server.
- Keep input validation in Form Requests where practical.
- Use Eloquent relationships rather than duplicating SQL logic.
- Keep Inertia prop contracts explicit and typed.
- UI components should expose accessible props and keyboard behaviors.
- Avoid treating visual placeholder state as persisted application behavior.
