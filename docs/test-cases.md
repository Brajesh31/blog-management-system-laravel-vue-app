# 🧪 Test Case Catalogue

These are recommended acceptance tests for the current codebase. The table is not a report of test cases already implemented or passing.

## Authentication

| ID | Scenario | Expected outcome |
|---|---|---|
| AUTH-01 | Register valid unique account | Account created with hashed password |
| AUTH-02 | Register duplicate email | Validation error; no duplicate |
| AUTH-03 | Login valid credentials | Authenticated session established |
| AUTH-04 | Login invalid credentials | Safe validation error |
| AUTH-05 | Access verified route before verification | Verification prompt/redirect |
| AUTH-06 | Verify valid signed URL | Email verified |
| AUTH-07 | Password reset valid token | Password updated |
| AUTH-08 | Logout | Session invalidated |

## Profile

| ID | Scenario | Expected outcome |
|---|---|---|
| PROF-01 | Update own name | Persisted |
| PROF-02 | Change email | Verification timestamp cleared |
| PROF-03 | Use duplicate email | Validation rejected |
| PROF-04 | Delete with wrong password | Rejected |
| PROF-05 | Delete with current password | Session invalidated and user deleted |
| PROF-06 | Access another user's private profile data | Denied or limited by documented policy |

## Posts

| ID | Scenario | Expected outcome |
|---|---|---|
| POST-01 | Save draft with title and empty content | Draft created |
| POST-02 | Publish empty content | Rejected |
| POST-03 | Publish valid content | Published record created |
| POST-04 | Missing title | Rejected |
| POST-05 | Title over 255 chars | Rejected |
| POST-06 | Image over 2 MB | Rejected |
| POST-07 | Unsupported file | Rejected |
| POST-08 | Duplicate title | Unique slug generated |
| POST-09 | Guest feed | Only published records visible |
| POST-10 | User feed | Published plus own permitted records |
| POST-11 | Another user edits post | Forbidden after implementation |
| POST-12 | Draft detail requested by guest | Not found/forbidden according to defined policy |
| POST-13 | Stored HTML includes executable attributes | Sanitizer removes unsafe markup |
| POST-14 | DB create fails after upload | Orphaned file cleaned up |

## Social features
- COMMENT-01: user creates comment on accessible post.
- COMMENT-02: unauthorized user cannot delete another user's comment.
- LIKE-01: duplicate like does not create duplicate record.
- BOOKMARK-01: bookmark list is private to the owning user.
- TAG-01: invalid tag cannot be assigned.
- NOTIFY-01: notification is visible only to its recipient.
- NOTIFY-02: mark-read operation cannot mutate another user's notification.

These workflows are currently incomplete and should be implemented before these tests are expected to pass.

## Interface and accessibility
- UI-01: all forms operate with keyboard only.
- UI-02: field labels and errors are announced.
- UI-03: status feedback is announced after save/failure.
- UI-04: dialogs/sheets manage and restore focus.
- UI-05: editor toolbar is keyboard-operable.
- UI-06: narrow viewport and zoom preserve usable layout.

## Test isolation
Configure a disposable database before running tests. Read [Testing](testing.md) before executing database-refreshing feature tests.
