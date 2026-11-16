# 📋 Product and Engineering Requirements

This document records requirements implied by the current product foundation and identifies acceptance gates for unfinished capabilities. It is not a formal signed product requirements document.

## User stories and acceptance criteria

### Account registration and login
**Story:** As a visitor, I can create an account and authenticate so that I can use verified-user features.

Acceptance:
- Registration validates required fields and persists a hashed password.
- Login errors do not disclose whether an account exists beyond the framework's intended response.
- Session state is established securely and invalidated on logout.
- Verification and password reset messages are delivered through configured mail.
- Feature tests cover invalid credentials, duplicate email and unverified restrictions.

### Profile management
**Story:** As an authenticated user, I can update my account information and delete my account.

Acceptance:
- Only the current account can be changed.
- Profile validation enforces unique/valid fields.
- Email change invalidates the previous verification state.
- Account deletion requires current password.
- Database and filesystem deletion/retention behavior is documented and tested.

### Post creation
**Story:** As a verified user, I can create a draft or publish a post.

Acceptance:
- Title is required and limited to 255 characters.
- Draft can be saved without published content requirements.
- Published content cannot be empty.
- Image constraints are enforced by the server.
- Post is assigned to the authenticated author.
- Stored rich content is sanitized before public rendering.
- Request failures do not leave orphaned uploads.

### Post feed and detail (not complete)
Acceptance before delivery:
- Missing feed page is implemented.
- Search and pagination states are accessible.
- Guests only see published posts.
- Authors can see their own drafts in an appropriate private area.
- Private content never leaks through Inertia props, search or caches.
- Public detail pages use safe HTML and stable canonical identifiers.

### Social actions (not complete)
Acceptance before delivery:
- Each action is authenticated and authorized.
- Duplicate operations are prevented by constraints and server checks.
- Comment abuse/reporting and delete behavior are specified.
- Notifications are generated from real events and visible only to recipients.

## Non-functional requirements

- **Security:** server-side validation/authorization, safe HTML, protected secrets and upload controls.
- **Accessibility:** keyboard navigation, visible focus, semantic forms and editor controls.
- **Privacy:** defined purpose, visibility, retention, deletion and backup behavior.
- **Reliability:** migrations, queue supervision, monitoring and recoverable backups.
- **Performance:** measured query and frontend behavior before optimization.
- **Maintainability:** tests and documentation for user-visible behavior and schema changes.

## Traceability
Link each delivered feature to an issue, tests, documentation and any relevant ADR. See [Test Cases](test-cases.md) and [Risk Register](risk-register.md).
