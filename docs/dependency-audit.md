# 🧯 Dependency Audit Findings

This page records the repository's GitHub Actions dependency-audit result observed during the documentation update on **2026-11-16**. Advisory databases and dependency lockfiles change over time; re-run the workflows for current results.

## Observed CI result

- Gitleaks secret scanning completed successfully.
- Composer `composer audit --locked` failed because the locked dependency tree contains packages with published advisories.
- npm `npm audit --omit=dev` failed. The run reported **38 vulnerabilities: 27 moderate and 11 high**.
- The audit jobs were intentionally configured to fail when advisories are found. Do not suppress these findings simply to make CI green.

## npm packages surfaced in the audit output

The output included advisories affecting or passing through packages such as:
- TipTap core/extensions and ProseMirror view.
- Vue and @vue/server-renderer.
- defu.
- linkify-it and markdown-it.
- nanoid.
- postcss.
- source-map-js.
- zod.

The exact affected versions and dependency paths must be taken from a fresh `npm audit` report. Transitive dependency advisories should be addressed through a compatible parent package update where possible.

## Composer findings

The Composer audit output included Symfony YAML advisories, including CVE-2026-109413 and CVE-2026-45304. Consult fresh `composer audit --locked` output for affected locked versions and the complete advisory set.

## Remediation workflow

1. Run Composer and npm audits locally or in CI and save the sanitized output.
2. Identify direct versus transitive dependencies and the packages that introduce them.
3. Review fixed versions, peer constraints and Laravel/Vue/Tiptap compatibility.
4. Update dependencies in a dedicated change, regenerating lockfiles with the supported package managers.
5. Run PHP tests, Pint, frontend type-check/build and relevant editor/authentication tests.
6. Inspect bundle changes and verify the rich-text editor and page flows.
7. Re-run audits and document remaining findings with an explicit risk decision.

Do not use `npm audit fix --force` or broadly upgrade the Laravel framework without reviewing breaking changes. Do not claim vulnerabilities are fixed until the locked dependency tree and CI audit confirm it.


## Additional CI diagnostics observed on 2026-11-16

A later quality run exposed an installation conflict before the frontend build:

- `npm ci` reported `ERESOLVE`: the lockfile resolution attempted `@tiptap/extension-image@3.34.0`, which declares a peer dependency on `@tiptap/core@3.34.0`, while the application uses the TipTap 2.11.7 editor packages.
- The top-level package manifest declares TipTap 2.11.7-compatible ranges. Review the full lockfile resolution and regenerate it consistently before treating the dependency set as reproducible.
- Do not use `--force` as the permanent fix. A temporary legacy peer mode can hide an incompatible dependency tree and should not be treated as a correctness fix.

The Composer audit remains a separate failure from the npm installation conflict. Run both audits independently and review the exact current advisories before updating lockfiles.
