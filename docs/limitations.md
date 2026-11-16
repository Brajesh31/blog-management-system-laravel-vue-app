# ⚠️ Current Limitations

This document is intentionally direct. The repository contains useful application foundations, but several parts are incomplete.

## User-visible workflow limitations

1. **Post feed page missing:** the controller returns an Inertia page named Posts/Index, but resources/js/Pages/Posts/Index.vue is absent.
2. **Post detail unfinished:** the route exists, but the controller action is not implemented.
3. **Post editing/deletion unfinished:** routes exist, but edit/update/destroy actions remain incomplete.
4. **Social features not connected:** comments, likes, bookmarks, tags and notifications have tables/models/relationships but not complete end-to-end routes and pages.
5. **Notification UI is placeholder:** MainLayout contains local notification sample state and placeholder handlers.
6. **Search UI is not wired end-to-end:** navigation component exists, but MainLayout's search handler is a placeholder; the backend feed query accepts a search parameter.
7. **Username profiles require login:** the route is inside an auth middleware group.
8. **Slug URLs are not configured:** post creation generates a slug, but default model route binding uses the primary key.

## Security and privacy limitations

- No explicit post ownership policy was identified for the unfinished mutation routes.
- TipTap HTML is stored without an evidenced server-side sanitizer.
- Post uploads use the public filesystem disk.
- Factory-created users share a development password.
- DB cascade deletion does not remove files stored on the filesystem.
- Retention/export/privacy request policies are not fully implemented.
- Rate-limiting and moderation controls for user-generated content require review.

## Engineering limitations

- No separate public REST API/OpenAPI schema is present.
- Tests focus on authentication and profile foundations; important post authorization and sanitization tests are not yet present.
- No load-test baseline or published SLO exists.
- MainLayout uses placeholder notification data.
- Local environment uses the log mailer, so email does not reach a mailbox until configured.

## What this means

Do not deploy the current branch as a complete public blogging platform without completing the high-priority security and product gaps. This list should be updated only when code and tests demonstrate that a limitation has been resolved.
