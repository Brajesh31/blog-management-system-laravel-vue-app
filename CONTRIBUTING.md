# Contributing

Thanks for taking the time to improve Blog Management System. Contributions should be focused, explain the problem they solve, and reflect the current project status in the [README](README.md).

## Before you start

1. Search the open and closed repository issues for a related report. For a substantial feature or a change to an existing workflow, open an issue first to agree on scope.
2. For a suspected security vulnerability, do not open a public issue. Follow [SECURITY.md](SECURITY.md).
3. Check the [Roadmap](ROADMAP.md) and current implementation notes so a pull request does not rely on a route or feature that is still a stub.

## Local setup

Follow [Installation](docs/installation.md) to install PHP and JavaScript dependencies, configure `.env`, and create the development database. Use synthetic data for local work. Never copy production credentials, personal data, uploads, or database dumps into the repository.

Create a branch for the change, for example:

```text
feature/post-ownership
fix/profile-route-access
docs/local-installation
```

## Implementation guidance

- Keep Laravel route/controller behavior on the server and use Inertia props to pass only the data required by a Vue page.
- Validate incoming data with a Form Request or the appropriate Laravel validator. Client-side checks improve usability but do not replace server-side validation.
- Enforce ownership and access rules on the server. Hiding a button in Vue is not authorization.
- Treat TipTap content as untrusted input. Do not render saved HTML as raw markup until an explicit sanitization strategy is in place.
- Add reversible migrations for schema changes. Account for existing records, foreign keys, indexes, and delete behavior. Do not edit a migration that may already have run in another environment; add a new migration instead.
- Keep Vue/TypeScript props aligned with the Inertia response shape. Include loading, empty, validation-error, and narrow-screen states where they apply.
- Follow the existing PHP and Vue conventions. Use Laravel Pint for PHP formatting and keep dependencies focused; explain new runtime dependencies in the pull request.
- Update the relevant documentation when routes, environment variables, database structure, setup, or observable behavior changes.

## Verification

Run the checks that apply to the change before submitting a pull request:

```powershell
php artisan test
vendor/bin/pint --test
npm run build
```

The frontend build includes Vue/TypeScript checking. If a check cannot be run, state why and include any manual verification you completed. Do not run destructive migration commands against a database that contains data you need.

## Pull requests

Use a clear title and include:

- The problem and intended behavior.
- A concise summary of the implementation and any known limitations.
- Migration, configuration, route, or environment-variable impact.
- The checks run and their results.
- Screenshots or a short recording for visible interface changes.
- Security and privacy considerations for authentication, uploads, rich content, or personal data.

Keep each pull request focused. Link the issue it addresses when one exists, and be prepared to revise the change in response to review. The repository owner listed in [CODEOWNERS](CODEOWNERS) is the maintainer for review routing.

## Commit messages

Use a short imperative summary, optionally with a conventional prefix, for example `fix: enforce post ownership` or `docs: clarify local database setup`. Keep unrelated formatting or generated files out of a change.

## License

By contributing, you agree that your contribution is submitted under the project's [MIT License](LICENSE).
