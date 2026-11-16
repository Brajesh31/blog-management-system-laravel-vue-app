# Roadmap

This roadmap reflects the current repository snapshot. It is planning guidance, not a release commitment.

## 🚨 Stabilize existing post flow

- [ ] Add the missing `Posts/Index` page or change the controller to render an existing page; test search, pagination and visibility.
- [ ] Implement post detail rendering and edit, update and delete actions.
- [ ] Add server-side ownership authorization for every mutation and private/draft read.
- [ ] Add tests for owner, other user, guest, verified/unverified accounts and invalid inputs.
- [ ] Verify image uploads, failure cleanup and deletion behavior.

## ✍️ Complete content workflows

- [ ] Select and implement safe TipTap HTML sanitization and rendering.
- [ ] Decide whether username profiles are public and align route middleware.
- [ ] Connect tags, comments, likes, bookmarks and notifications to validated, authorized endpoints and interface states.
- [ ] Test duplicate interactions, authorization, deletion and notification visibility.

## 🔐 Production readiness

- [ ] Review media storage, access, size limits and cleanup.
- [ ] Validate production settings for sessions, queues, mail, cache, logs and secrets.
- [ ] Establish backup/restore procedures and run restore drills.
- [ ] Review keyboard operation, screen-reader labeling, contrast, responsive layouts and error states.
- [ ] Review dependency advisories and upgrade cadence.

## 🧹 Maintenance

- [ ] Keep architecture, route, database and configuration docs aligned with source changes.
- [ ] Expand feature and integration coverage with each implemented workflow.
- [ ] Revisit this roadmap as product priorities change.
