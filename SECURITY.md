# Security Policy

## Supported versions

This repository does not currently publish a version support matrix or security release schedule. The `main` branch is the active development line. If you deploy a copy, track upstream changes and review your own dependencies and configuration.

## Reporting a vulnerability

Please do not report security vulnerabilities in a public issue, pull request, discussion, or social post. Use GitHub's private vulnerability reporting page for this repository:

<https://github.com/Brajesh31/blog-management-system-laravel-vue-app/security/advisories/new>

If private vulnerability reporting is unavailable, contact maintainer Brajesh Kumar through the [GitHub profile](https://github.com/brajesh31) and ask for a private reporting channel. Do not include exploit details or sensitive data in a public message.

Please include, where possible:

- The affected commit, route, component, or dependency.
- A concise description of the security impact and affected configuration.
- Sanitized reproduction steps or a proof of concept that does not expose real user data.
- Any suggested mitigation or relevant logs with secrets removed.

The maintainer will acknowledge and investigate reports as time permits. There is no guaranteed response or remediation timeline. Please allow a reasonable opportunity to investigate and prepare a fix before disclosing details publicly. We will coordinate disclosure with the reporter when practical.

## Deployment security

The application is still in progress; the presence of a route, model, or migration does not mean the corresponding workflow has been reviewed for production use. In particular, the post update/delete controller actions are unfinished, and ownership authorization and a rich-HTML sanitization strategy must be addressed before those workflows are enabled.

For any deployment:

- Set `APP_ENV=production`, `APP_DEBUG=false`, and serve the application only over HTTPS.
- Keep `.env`, `APP_KEY`, database credentials, mail credentials, and any external service keys out of version control and logs. Restrict who can read production secrets.
- Use a database account with only the permissions the application needs. Restrict network access to the database and protect backups.
- Configure secure session cookies and trusted proxy/host behavior for the actual hosting environment.
- Keep PHP, Composer packages, Node packages, and the operating system updated. Review dependency changes before deploying them.
- Enforce authorization and validation on the server. Client-side checks and hidden interface controls are not security boundaries.
- Validate uploaded files, limit their size, configure storage access deliberately, and do not treat user-supplied file names or content as trusted.
- Sanitize or safely render user-authored rich text before displaying it. Do not output saved HTML as raw markup without an appropriate sanitizer.
- Restrict log and upload access, avoid logging credentials or personal content, and establish database and file backup procedures.

See [Deployment](docs/deployment.md) for the production checklist and [Troubleshooting](docs/troubleshooting.md) for safe diagnostics.
