# ✨ Feature Catalogue

This catalogue separates working foundations from database-only or unfinished features.

## Account and identity

| Feature | Evidence in source | Status |
|---|---|---|
| Registration | Auth route/controller and Vue register page | Implemented foundation |
| Login/logout | Auth route/controller and Vue login page | Implemented foundation |
| Email verification | Controllers/routes/page and feature tests | Implemented foundation, real mailer required |
| Password reset | Controllers/routes/pages and tests | Implemented foundation, real mailer required |
| Password confirmation/update | Auth routes/controllers/pages and tests | Implemented foundation |
| Own profile edit | Profile controller, request and page | Implemented foundation |
| Account deletion | Profile controller validates current password, logs out and deletes account | Implemented; review media/retention implications |
| Username profile | Controller/page and route | Present but route requires authentication |

## Content authoring

| Feature | Evidence | Status |
|---|---|---|
| Post title | Create.vue and StorePostRequest | Implemented in create flow |
| Rich-text editing | TipTap editor and toolbar | Editor exists; server-side HTML sanitization not established |
| Cover image | Client preview and server upload to public disk | Basic flow exists; media controls need hardening |
| Draft/publish | Form buttons and request validation | Store flow exists for draft/published |
| Post slug | Controller generates collision suffix | Generated on create; slug route binding not configured |
| Search/pagination | PostController query | Controller code exists; Vue target page missing |
| Post detail | Named route | Controller action unfinished |
| Edit/update/delete | Named routes | Controller actions unfinished; no ownership policy evidenced |

## Engagement and discovery

| Feature | Repository evidence | Status |
|---|---|---|
| Comments and replies | Comment model, migration and relationships | Data layer only |
| Likes | Like model, migration and relationships | Data layer only |
| Bookmarks | Bookmark model, migration and relationships | Data layer only |
| Tags | Tag model, migration and pivot relationship | Data layer only |
| Notifications | Notification model/migration | Data layer only; MainLayout uses local placeholder data |
| Follow graph | Notification enum references follow, but no follow relationship table/workflow was found | Not implemented |

## Interface component catalogue

Reusable interface components include buttons, cards, alerts, forms, labels, inputs, checkboxes, dialogs, dropdown menus, popovers, sheets, separators, avatars and toast notifications. Navigation includes primary navbar, mobile menu, search UI, user dropdown and notification popover.

The presence of a component does not establish a working backend feature. See [Components](components.md) and [Modules](modules.md).

## Feature acceptance principle

A feature should only be called complete when it has:
1. A user-accessible route or interaction.
2. Server-side validation and authorization.
3. Persistence behavior and failure handling.
4. Tests for success, rejection and edge cases.
5. Accessible interface states.
6. Updated documentation and operational implications.
