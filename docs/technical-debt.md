# 🧾 Technical Debt Register

This list records current engineering debt observed during repository review. It should change when the relevant code and tests change.

| ID | Area | Debt | Consequence | Suggested remediation |
|---|---|---|---|---|
| TD-01 | Posts | Missing Posts/Index Vue page | Feed route cannot render its target page | Implement page and controller/page contract tests |
| TD-02 | Posts | show/edit/update/destroy actions unfinished | Post lifecycle incomplete | Complete controller/service methods or disable unsupported routes |
| TD-03 | Authorization | No explicit post ownership policy identified | Cross-user access risk if mutations are implemented incorrectly | Add policies and denial tests |
| TD-04 | Content | Stored TipTap HTML has no evidenced sanitizer | Stored XSS risk | Sanitizer allowlist and output tests |
| TD-05 | Media | Public disk upload path and no verified cleanup | Unintended disclosure/orphaned files | Media service and deletion lifecycle |
| TD-06 | Routing | Slug generated but route binding uses primary key | Confusing URLs and identifier mismatch | Decide and test slug routing |
| TD-07 | Social features | Models/migrations not connected to complete flows | UI/product gap | Implement each interaction end-to-end |
| TD-08 | Navigation | MainLayout uses placeholder search and notification handlers | Visible UI can imply unavailable service | Wire to server or clearly hide/defer controls |
| TD-09 | Testing | Post authorization, visibility and sanitizer coverage incomplete | Regression risk | Add scenario matrix from testing guide |
| TD-10 | Operations | Retention, restore and media lifecycle unproven | Data loss/privacy risk | Run documented drills and write policies |
| TD-11 | Dependencies | Composer/npm audit currently reports advisories | Vulnerable transitive/runtime packages may remain | Upgrade with lockfile changes and regression tests |
| TD-12 | Accessibility | No completed assistive technology audit | Users may encounter inaccessible flows | Test editor, forms, nav, dialogs and status messages |
| TD-13 | Dependencies | npm lockfile resolves TipTap Image 3.34 while editor core is 2.11.7 | `npm ci` fails with ERESOLVE and dependency consistency is not established | Regenerate and test a coherent TipTap 2 lockfile or plan a coordinated major upgrade |
| TD-14 | Frontend imports | Case-mismatched `@/components/ui/label` paths on Linux | CI type-check cannot resolve label components | Align import path casing with actual `Components/ui/label` directory |
| TD-15 | Frontend build | `resources/js/app.ts` imports Ziggy from Composer vendor path | Build requires Composer vendor files before Vite type-check | Ensure CI installs Composer dependencies before `npm run build` |
| TD-16 | PHP style | Pint reported 19 formatting issues across 68 existing PHP files | Full-repository style check fails even when no PHP code changes | Apply Pint in a separately reviewed code-formatting change; CI checks changed PHP files |
| TD-17 | Test environment | Feature tests render Blade/Inertia pages without a generated Vite manifest | Page tests fail with ViteManifestNotFoundException | Produce a valid frontend manifest or use Laravel's documented no-Vite testing setup after build strategy is fixed |
| TD-18 | Test fixtures | Profile/password tests submit a password that does not match the current factory's development password | Authentication and account-management tests fail despite successful DB setup | Align tests/factories and use explicit, test-only credentials |
| TD-19 | Authentication route tests | Existing test expectations for login, verification and password confirmation screens do not consistently match route responses | 302/404 responses fail tests expecting 200 | Review route middleware/page availability and update tests only to intended product behavior |

Do not mark debt resolved after documentation-only work. Close an item only when implementation, tests and operational evidence demonstrate resolution.
