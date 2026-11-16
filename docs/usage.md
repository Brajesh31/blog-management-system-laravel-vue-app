# 📘 Usage Guide

This guide describes the local user paths that have source support. It does not describe unfinished feed, edit or social workflows as available.

## 1. Start a local environment

Follow [Installation](installation.md). Start Laravel and Vite:

```powershell
php artisan serve
npm run dev
```

Open the local URL printed by Artisan.

## 2. Create an account

1. Open the home page.
2. Choose Register and complete the form.
3. Submit the registration.
4. Complete email verification if required by the route.
5. For local testing, the example mailer writes outgoing messages to Laravel logs rather than sending email. Check the configured log output to inspect the verification link.

Do not use factory seed accounts on public deployments. The UserFactory uses a shared development password.

## 3. Sign in and use the dashboard

1. Open Login.
2. Enter the test account credentials you created locally.
3. Submit the form.
4. The dashboard route requires authentication and a verified email.

## 4. Update your profile

1. Open the profile edit page.
2. Change name or email.
3. Save the form.
4. If the email changes, Laravel clears the email verification timestamp, so the new address must be verified again.
5. Account deletion requires the current password and deletes the account record; review the [Privacy](privacy.md) guide for related data and file implications.

## 5. Create a post

1. Open the post creation route while signed in with a verified account.
2. Enter a title.
3. Compose content in the TipTap editor.
4. Optionally select a JPEG, PNG, JPG, GIF or WebP cover image up to 2 MB.
5. Choose Save Draft or Publish.
6. The server validates the submission and redirects to the dashboard with a flash message.

The browser's image checks are for usability. Server validation remains authoritative. Stored rich text must not be rendered as raw HTML until a sanitizer is implemented and tested.

## 6. Known navigation limitations

The feed query renders a missing Inertia page named Posts/Index. Post detail/edit/update/delete actions are unfinished. The current documentation therefore does not provide a usable feed-reading or post-maintenance walkthrough. Comments, likes, bookmarks, tags and notification workflows are not fully wired.

For exact paths and access conditions see [HTTP routes](api.md). For known incomplete work see [Limitations](limitations.md).
