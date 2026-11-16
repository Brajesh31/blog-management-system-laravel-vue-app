# 🧑‍💻 Coding Standards

These standards reflect the Laravel/PHP and Vue/TypeScript stack already used in the repository. Prefer existing framework conventions over introducing new abstractions without a reason.

## PHP and Laravel
- Follow PSR-12-compatible formatting and use Laravel Pint.
- Keep route definitions declarative; move non-trivial request handling into controllers or focused application services.
- Validate external input with Form Requests or Laravel validators.
- Enforce resource authorization with policies/gates and test both allowed and denied access.
- Use Eloquent relationships for domain associations; avoid duplicating relationship queries.
- Use mass assignment allowlists and never pass unvalidated request arrays directly to create/update.
- Add forward-only migrations for shared schemas. Review foreign keys, indexes, cascade behavior and rollback impact.
- Log operational context, not secrets, tokens, passwords or private user content.

## Vue and TypeScript
- Use Vue 3 Composition API and TypeScript for new components.
- Define prop and event types explicitly.
- Keep page components responsible for page composition and reusable UI in Components/.
- Keep backend business rules and authorization on the server.
- Provide loading, empty, success and validation-error states.
- Clean up listeners, timers and object URLs created by components.
- Prefer semantic HTML and accessible labels/focus behavior.

## Rich content and uploads
- Treat TipTap output as untrusted HTML.
- Do not render stored HTML raw without a reviewed sanitizer.
- Validate files on the server, inspect actual content and define public/private storage.
- Generate storage names server-side and implement orphan cleanup.

## Naming and structure
- PHP classes use StudlyCase; methods and variables use camelCase.
- Vue component files use PascalCase.
- Migration and test names should communicate the behavior under test.
- Keep documentation paths descriptive and update the documentation index.
- Do not add generated artifacts, local logs, node_modules or environment files.

## Review expectations
Every change should be small enough to review, have relevant tests, describe any configuration/schema impact, and consider security, privacy and accessibility. See [Contributing](../CONTRIBUTING.md).
