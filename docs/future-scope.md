# 🚀 Future Scope

The following items are proposals, not existing application features. Prioritize them based on user need, security review and maintainability.

## Phase 1: complete post lifecycle
- Build the missing feed page with pagination, search and visibility-aware empty states.
- Implement public post detail rendering.
- Add edit/update/delete with explicit ownership policies.
- Align generated slugs with route binding and define slug uniqueness behavior.
- Add regression tests for access boundaries and failed updates.

## Phase 2: safe publishing
- Add rich HTML sanitization with a reviewed allowlist.
- Harden image validation, re-encoding and storage visibility.
- Add media deletion when posts/accounts are removed.
- Add rate limiting, spam controls and basic reporting/moderation processes.
- Define post state transitions and publication timestamps.

## Phase 3: engagement features
- Implement comment/reply creation and moderation.
- Implement likes and bookmarks with duplicate protection.
- Add tag creation/assignment and tag filtering.
- Connect notification records to actual events and an authorized inbox.
- Add a follow graph only if product requirements justify it.

## Phase 4: reader experience
- Complete public profiles if intended.
- Add accessible post reading pages, author information and navigation.
- Add metadata, canonical URLs and social previews only for public content.
- Add search improvements when query performance evidence warrants them.

## Phase 5: operations and quality
- Add email integration tests using a safe test mailer.
- Add broader integration and browser end-to-end tests.
- Add privacy notice, retention and deletion workflows.
- Run accessibility testing with keyboard and assistive technology.
- Add monitoring, backup restoration and incident drills.
- Review dependency advisories and upgrade dependencies on a controlled schedule.

## Acceptance gate for every phase
A feature is not complete until server-side authorization, validation, data handling, negative tests, accessibility states, documentation and operational consequences are reviewed.
