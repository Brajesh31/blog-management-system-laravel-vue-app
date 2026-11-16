# 📝 Project Overview

## Product summary
**Blog Management System** is a Laravel 12 application with a Vue 3 + TypeScript interface delivered through Inertia.js. It provides an application foundation for user accounts, profile management and post authoring. The repository also contains relational models and migrations for comments, likes, bookmarks, tags and notifications, although those workflows are not fully connected.

The application is a Laravel monolith. Laravel owns HTTP routing, session authentication, validation, model access and page responses. Vue renders Inertia pages in the browser. Vite compiles the frontend assets.

## Problem context
A blog application needs identity, author ownership, content composition, publication states, persistent records, safe media handling and a usable interface. This repository establishes parts of that foundation with Laravel authentication scaffolding, Eloquent models, TipTap rich text and Inertia page components.

## Proposed solution in the current codebase
- Laravel routes, controllers and Form Requests.
- Eloquent models and MySQL-oriented migrations.
- Session-based account flows and email verification.
- Vue pages and reusable controls.
- TipTap rich-text content in the post creation form.
- Optional image upload and draft/publish submission.
- Tests for core authentication and profile paths.

## Objectives
1. Provide secure account registration and login foundations.
2. Allow verified users to maintain their profile.
3. Provide a validated post creation form with draft and published states.
4. Keep page rendering connected to Laravel through Inertia.
5. Maintain relational models for future content and engagement workflows.
6. Establish testing, documentation and operational conventions.

## Intended users
- **Readers:** discover and read posts once the feed/detail experience is completed.
- **Authors:** create and maintain posts once the lifecycle and ownership controls are complete.
- **Maintainers:** configure the Laravel app, review changes and operate deployments.
- **Contributors:** extend features and tests through focused pull requests.

These are product roles, not proof that every user journey is implemented.

## Current feature status

| Capability | Repository status |
|---|---|
| Registration, login, logout, verification and password reset | Routes/controllers and tests exist |
| Own profile update and account deletion | Route/controller/page flow exists |
| Username profile page | Controller/page exists; route currently requires authentication |
| Post creation | Create page, Form Request and store action exist |
| Post search/pagination | Query exists but target Vue page is missing |
| Post detail/edit/update/delete | Routes exist; controller actions unfinished |
| Comments, likes, bookmarks, tags and notifications | Schema/models/relationships exist; workflows not fully wired |
| Rich content sanitizer | Not evidenced in current post creation path |

See [Features](features.md), [Limitations](limitations.md) and [Risk Register](risk-register.md).

## Non-goals in the current repository
The source does not establish a public REST API, multi-tenant SaaS administration, payments/subscriptions, editorial approval workflows, analytics dashboards, external search service or completed moderation system. These must not be described as existing capabilities.

## Project success criteria
A production-ready release should have complete user journeys, server-enforced ownership and visibility rules, safe HTML rendering, deliberate upload privacy/retention, negative authorization tests, accessible forms/editor controls, tested migrations, protected secrets, monitoring and verified backup restoration.

## Related documentation
Start with [Architecture](architecture.md), [System Design](system-design.md), [Workflow](workflow.md), [Data Flow](data-flow.md) and [Installation](installation.md).
