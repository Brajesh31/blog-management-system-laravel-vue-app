# ✍️ Post Creation Contract

This page documents the form contract used by the Inertia Create Post page. It is not a REST API specification.

## Form fields

| Field | Client state | Server rule |
|---|---|---|
| title | String | Required, string, max 255 |
| content | TipTap HTML string | Nullable string; controller rejects an empty published post |
| image | File or null | Optional image, JPEG/PNG/JPG/GIF/WebP, 2 MB max |
| visibility | draft or published | Required and restricted to those two values |

## Interaction sequence

1. The page initializes an Inertia form object.
2. The user edits content in the TipTap component; the editor emits HTML.
3. Optional image selection is checked in the browser and previewed using an object URL.
4. Save Draft or Publish sets the visibility field and performs client-side validation.
5. The form posts to the named Laravel route post.store.
6. StorePostRequest validates the input on the server.
7. The controller rejects empty content for publication, stores an optional image and creates a Post row.
8. The server redirects to the dashboard with a flash status.

## Important implementation notes

- Client validation is not a trust boundary.
- Image storage currently uses the public disk at uploads/posts.
- Slug collision handling appends an integer suffix.
- Tags are not currently accepted by the create form.
- Rich text is stored as HTML and needs sanitization before public rendering.
- The current upload/database flow should be improved to handle cleanup if persistence fails.
