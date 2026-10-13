# Database

The schema is defined by Laravel migrations in `database/migrations/`. MySQL is the sample application database in `.env.example`; select a supported Laravel database driver and test the migrations against that engine before deployment.

## Tables

| Table | Main data and constraints |
| --- | --- |
| `users` | Name, unique email, password, verification timestamp, remember token, timestamps, plus unique username and optional profile picture path. |
| `password_reset_tokens` | Email-keyed password reset token and creation time. |
| `sessions` | Session identifier, optional indexed user ID, IP address, user agent, payload, and indexed last-activity time. |
| `cache`, `cache_locks` | Laravel database cache entries and lock ownership/expiry. |
| `jobs`, `job_batches`, `failed_jobs` | Laravel database queue payloads, batches, and failures. |
| `posts` | Owner user ID, title, text content, unique slug, optional image path, visibility, timestamps. Owner deletion cascades to posts. |
| `tags` | Unique name and slug, optional description, timestamps. |
| `post_tag` | Post/tag many-to-many pivot with a unique `(post_id, tag_id)` pair. Deleting either parent cascades to the pivot row. |
| `comments` | User, post, optional self-referencing parent comment, text content, timestamps. Deleting a user, post, or parent comment cascades to related comments. |
| `likes` | User/post pair with a unique pair constraint and cascading foreign keys. |
| `bookmarks` | User/post pair with a unique pair constraint and cascading foreign keys. |
| `notifications` | Recipient, type, message, read flag and time, optional sender, related post, and related comment. Deleting the recipient cascades; deleting an optional related record sets its reference to null. |

The notification `type` enum currently includes `like`, `comment`, `reply`, `follow`, `mention`, `bookmark`, `tag`, and `share`. A follow relationship table is not currently present, and the social workflows are not fully implemented.

## Relationships

- A user has many posts, comments, likes, bookmarks, and notifications.
- A post belongs to a user and has many comments, likes, and bookmarks.
- Posts and tags are many-to-many through `post_tag`.
- Comments belong to a user and post and can have a parent comment with replies.
- A notification belongs to a recipient and may reference a sender, post, and comment.

The matching Eloquent relationships are in `app/Models/`. The `Post` model's `comments()` relation returns top-level comments ordered newest first; `allComments()` returns comments without that parent filter.

## Visibility and indexing notes

The `posts.visibility` enum allows `draft`, `published`, `private`, `archived`, and `restricted`. The current post creation request accepts only `draft` and `published`. The post listing query filters guests to published posts and authenticated users to published posts plus their own records. Review and test visibility rules before exposing the unfinished listing/detail flows.

The schema gives posts a unique slug and relational foreign keys, but the application currently uses default primary-key route binding for `{post}`. Search uses substring matching over title, content, and author name; the migrations do not add full-text search indexes. Consider query plans and a suitable search/indexing strategy if data volume grows.

## Migrations and data safety

Check migration state with:

```powershell
php artisan migrate:status
```

Apply migrations locally with `php artisan migrate`. In production, review each migration, back up the database, and apply it as a controlled release step with `php artisan migrate --force`. Do not edit a migration that may already have run in a shared environment; create a new migration instead. Destructive migrations and rollbacks can lose data, so verify the backup restore path first.

The root seeder generates 30 users and 50 posts using factories. Factory-created users share the development password `password123`; run `php artisan db:seed` only against a disposable local database. Never seed production with these records or credentials.
