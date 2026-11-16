# 🚦 Technical and Product Risk Register

Qualitative prioritization from repository review, not a measured exploitability score or external audit.

| ID | Priority | Risk | Evidence/context | Mitigation |
|---|---|---|---|---|
| R-01 | Critical pre-launch | Post ownership not enforced on unfinished mutation routes | Auth middleware exists; post lifecycle actions unfinished and no explicit policy evident | Implement policies and cross-user tests |
| R-02 | High | Stored rich-text XSS | TipTap HTML persisted in `posts.content` | Strict sanitizer allowlist and regression tests |
| R-03 | High | Public media exposure | Post image uses public disk | Define access, inspect/re-encode, randomize names, cleanup |
| R-04 | High | Unsafe sample seeding | Factory accounts share `password123` | Restrict seeding to disposable environments |
| R-05 | High | Missing feed page | Controller returns `Posts/Index`, page absent | Build page and tests |
| R-06 | High | Incomplete post lifecycle | show/edit/update/destroy are unfinished | Complete safely or disable routes |
| R-07 | Medium | Profile visibility ambiguity | Username route is auth-protected | Decide public/private behavior and test |
| R-08 | Medium | Slug binding mismatch | Slug generated, default primary-key binding used | Choose and test route key |
| R-09 | Medium | Visibility state inconsistency | DB enum broader than create request | Define states and transitions |
| R-10 | Medium | Search scalability | Substring LIKE over title/content/author | Limit input and add indexes/search strategy |
| R-11 | Medium | Media deletion lifecycle | DB cascades cannot remove files | Add media cleanup service and tests |
| R-12 | Medium | Social workflows incomplete | Models/tables without complete routes/pages | Implement incrementally with policies/tests |
| R-13 | Medium | Retention policy missing | Sessions, content, media and logs persist | Define retention, export and deletion |
| R-14 | Medium | Accessibility not audited | Forms/editor need assistive tech review | Manual and automated audits |
| R-15 | Medium | Documentation drift | Source/routes and docs can diverge | Review docs in PR and validate local links |

## Priority order

Close R-01 through R-06 before calling post publishing production-ready. Decide privacy/media lifecycle before storing real user content. Deliver social features individually with authorization and abuse tests. Update status only when implementation and tests support closure, not because a document was added.
