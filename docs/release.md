# 🚀 Release Process

The repository currently does not publish a verified tagged release process. This document defines a proposed safe release checklist, not a claim that release automation already exists.

## Before release
- [ ] Confirm the exact commit and review the full diff.
- [ ] Ensure post workflows marked for release are implemented and authorization-tested.
- [ ] Review Composer and npm dependency audit output.
- [ ] Run backend tests, Pint and frontend build.
- [ ] Review migrations and backup/restore plan.
- [ ] Update README, CHANGELOG, ROADMAP and docs for user-visible changes.
- [ ] Confirm secrets and production environment are ready.

## Build and deploy
Follow [Deployment](deployment.md). Build production frontend assets, install production dependencies, back up required data, deploy with the web root pointing to public/, apply reviewed migrations and restart workers.

## Post-deploy verification
- [ ] Health endpoint responds.
- [ ] Login, registration and verification paths behave as expected.
- [ ] Mail is delivered using the production transport.
- [ ] Database reads and writes work.
- [ ] Upload permissions and visibility are correct.
- [ ] Enabled user journeys pass manual smoke tests.
- [ ] Logs and worker health are monitored.

## Rollback
A code rollback does not automatically reverse a database migration or restore deleted files. Decide rollback eligibility per migration. Restore data only from an approved backup and validate consistency in an isolated environment first.
