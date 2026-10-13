# HTTP routes

This application currently exposes Laravel web routes that return Inertia pages, redirects, or session-based authentication responses. There is no `routes/api.php`, documented JSON API, or token-based client contract. Paths and behavior below are based on `routes/web.php` and `routes/auth.php`.

## Main routes

| Method | Path | Route name | Access | Current behavior |
| --- | --- | --- | --- | --- |
| `GET` | `/` | `home` | Public | Renders the `Home` Inertia page. |
| `GET` | `/up` | — | Public health endpoint | Laravel health response configured in `bootstrap/app.php`. |
| `GET` | `/dashboard` | `dashboard` | Authenticated, verified email | Renders the dashboard page. |
| `GET` | `/posts` | `post.index` | Public | Searches and paginates posts; controller currently refers to a missing `Posts/Index` Vue page. |
| `GET` | `/posts/create` | `post.create` | Authenticated, verified email | Renders the post creation form. |
| `POST` | `/posts` | `post.store` | Authenticated, verified email | Validates and creates a draft or published post, then redirects to the dashboard. |
| `GET` | `/posts/{post}` | `post.show` | Public | Route exists, but the controller action is unfinished. Implicit model binding currently uses the post's primary key; generated slugs are not configured as the route key. |
| `GET` | `/posts/{post}/edit` | `post.edit` | Authenticated, verified email | Route exists, but the controller action is unfinished and does not currently enforce ownership. |
| `PUT` | `/posts/{post}` | `post.update` | Authenticated, verified email | Route exists, but the controller action is unfinished and does not currently enforce ownership. |
| `DELETE` | `/posts/{post}` | `post.destroy` | Authenticated, verified email | Route exists, but the controller action is unfinished and does not currently enforce ownership. |
| `GET` | `/{username}` | `userprofile.show` | Authenticated | Looks up a username and renders its profile page. The route is inside an `auth` group. |

Profile routes require authentication:

| Method | Path | Route name | Behavior |
| --- | --- | --- | --- |
| `GET` | `/profile` | `profile.edit` | Render the current user's profile form. |
| `PATCH` | `/profile` | `profile.update` | Validate and update the current user's name and email. Changing email clears its verification timestamp. |
| `DELETE` | `/profile` | — | Requires the current password, logs out, and deletes the current account. |

## Authentication routes

| Method | Path | Access | Behavior |
| --- | --- | --- | --- |
| `GET`, `POST` | `/register` | Guest | Show and submit account registration. |
| `GET`, `POST` | `/login` | Guest | Show and submit login. |
| `POST` | `/logout` | Authenticated | End the session. |
| `GET`, `POST` | `/forgot-password` | Guest | Show the reset request form and request a reset link. |
| `GET` | `/reset-password/{token}` | Guest | Show the password reset form. |
| `POST` | `/reset-password` | Guest | Submit a new password with its reset token. |
| `GET` | `/verify-email` | Authenticated | Show the email verification prompt. |
| `GET` | `/verify-email/{id}/{hash}` | Authenticated, signed URL, throttled | Verify the account email address. |
| `POST` | `/email/verification-notification` | Authenticated, throttled | Resend the verification email. |
| `GET`, `POST` | `/confirm-password` | Authenticated | Show and submit password confirmation. |
| `PUT` | `/password` | Authenticated | Validate the current password and update it. |

Email verification endpoints use a throttle of six requests per minute in the route definitions.

## Post listing and creation data

The post listing controller accepts an optional `search` query parameter. It searches title, content, and the author's name, orders newest first, and paginates 10 records while preserving the query string. Guests are filtered to `published` posts. Authenticated users see published posts and their own posts with other visibility values. Since the `Posts/Index` Vue page is absent, the route currently cannot complete the expected Inertia rendering flow.

The post creation request accepts:

| Field | Validation |
| --- | --- |
| `title` | Required string, maximum 255 characters. |
| `content` | Optional string; the controller rejects empty content when publishing. |
| `image` | Optional JPEG, PNG, JPG, GIF, or WebP image, maximum 2 MB. |
| `visibility` | Required; `draft` or `published`. |

The post schema also allows `private`, `archived`, and `restricted` visibility values, but the current create form/request does not accept them. Tags are not currently accepted by post creation. Rich content is stored as HTML; see [Security](../SECURITY.md) before displaying user content.

## Request protections and limitations

These are web routes, so Laravel's web middleware provides session and CSRF protections for state-changing requests. Requests must still be validated and authorized on the server. Route middleware currently provides authentication and email-verification checks for some paths, but it is not a substitute for per-post ownership checks.

There are no current HTTP routes for comments, likes, bookmarks, tags, or notifications, despite corresponding database structures. See [Architecture](architecture.md) and the [Roadmap](../ROADMAP.md) for implementation status.
