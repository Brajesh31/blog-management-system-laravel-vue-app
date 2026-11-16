# 🌐 HTTP and Inertia Reference

The repository currently exposes Laravel **web routes**, not a separate REST/JSON API. This reference is an entry point to the exact route catalogue.

- [HTTP route catalogue](api.md): methods, paths, route names, middleware, request fields and known gaps.
- [Architecture](architecture.md): request lifecycle and Inertia response behavior.
- [System Design](system-design.md): browser/server boundaries.

## Request model

The application uses Laravel's web middleware and session authentication. Vue pages submit through Inertia. State-changing browser requests receive Laravel's CSRF protection through the web middleware stack.

There is no current OpenAPI document, public JSON response contract or standalone API client contract in the repository. Do not invent cURL examples that bypass the session and CSRF behavior.

## Implemented post creation payload

The post create page submits to the named route post.store with the following fields:

| Field | Type | Requirement |
|---|---|---|
| title | string | Required, max 255 |
| content | HTML string | Optional for draft; non-empty for published post |
| image | uploaded file | Optional, JPEG/PNG/JPG/GIF/WebP, max 2 MB |
| visibility | enum-like string | Required; draft or published |

The authoritative rules are in StorePostRequest and the additional published-content check is in PostController. A frontend validation message is not a substitute for the server response.

## Authentication and authorization

- Authentication uses Laravel's session-based web guard.
- Dashboard and post creation require auth and verified middleware.
- Profile edit/update/delete require auth.
- The username profile path is currently within an auth group.
- Post update/delete ownership checks are not complete because the controller actions are unfinished.

For API implementation proposals, add an ADR and define authentication scheme, request/response schema, error format, rate limit, versioning and authorization before publishing an API.
