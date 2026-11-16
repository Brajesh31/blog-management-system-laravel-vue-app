# Versioning Policy

The repository does not currently declare a stable tagged release series. Do not infer a version from package versions of Laravel, Vue or other dependencies.

When maintainers begin publishing application releases, use Semantic Versioning:
- **MAJOR** for incompatible public behavior or migration changes.
- **MINOR** for backward-compatible user-facing features.
- **PATCH** for backward-compatible fixes and documentation corrections.

Before a first stable release, use clearly labeled pre-release tags such as `0.1.0-alpha.1` only when an actual release artifact is published. The GitHub release notes should summarize changes, upgrade steps, migration impact, known issues and security notes.

Keep CHANGELOG.md aligned with published tags. No release should be announced as production-ready while critical authorization or content-sanitization gaps remain.
