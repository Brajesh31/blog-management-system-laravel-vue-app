# Roadmap

This roadmap captures likely next steps from the current repository state. It is a planning guide, not a release commitment; priorities and scope may change as the project develops.

## Stabilize the existing post flow

- Add the missing `Posts/Index` page or change the controller to render an existing page, then verify search, pagination, and visibility filtering end to end.
- Implement post detail rendering and the edit, update, and delete actions.
- Add server-side ownership authorization for post changes and ensure draft/private content is visible only to its owner or an explicitly authorized role.
- Add feature tests for creating drafts and published posts, uploading images, visibility, ownership, and validation failures.

## Complete the content workflows

- Choose and implement a safe rich-text HTML sanitization and rendering strategy for TipTap content.
- Decide whether username profiles should be publicly accessible and align route middleware with that decision.
- Connect tags, comments, likes, bookmarks, and notifications to validated, authorized routes and useful interface states.
- Add tests for each enabled interaction, including duplicate actions, deletion behavior, and notification access.

## Improve production readiness

- Review upload storage, file access, size limits, and cleanup behavior for post images and profile media.
- Document and validate production configuration for sessions, queues, mail, cache, logging, backups, and secret rotation.
- Add operational checks for failed queue jobs, database backup restoration, and application health.
- Review keyboard navigation, screen-reader labels, responsive layouts, and empty/error states across the completed workflows.

## Maintenance

- Keep Laravel, PHP, Node, and frontend dependencies on supported versions and review security advisories.
- Extend feature tests as routes and behaviors are completed; keep installation and API documentation aligned with the actual application.
