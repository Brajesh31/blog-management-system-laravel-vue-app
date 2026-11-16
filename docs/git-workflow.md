# 🌿 Git Workflow and Contribution Branching

The repository's contribution process uses focused branches and reviewed pull requests. The current project does not enforce branch protection through documentation alone; maintainers should configure repository settings separately.

## Branch naming

Use short, descriptive names:
- `feature/post-feed`
- `fix/post-ownership-policy`
- `docs/accessibility-guide`
- `chore/dependency-audit`

## Suggested workflow

1. Sync the default branch.
2. Create a focused branch from the current main branch.
3. Make a small change and add or update tests.
4. Run the relevant local checks.
5. Update documentation and diagrams.
6. Push the branch and open a pull request.
7. Address review feedback and confirm CI status.
8. Merge using the repository's configured merge strategy.

## Commit messages

Use imperative summaries and optional prefixes:
- `feat: add post feed page`
- `fix: enforce post ownership`
- `docs: explain image upload lifecycle`
- `test: cover draft visibility`
- `chore: update PHP dependencies`

Avoid commits such as "changes", "update" or "final".

## Pull request expectations

- Explain the problem and behavior change.
- State tests run and checks not run.
- Identify migration/configuration impacts.
- Include genuine UI screenshots for visible changes, with private data removed.
- Include authorization, privacy, security and accessibility review notes.
- Keep unrelated generated assets and formatting out of the PR.

See the root [CONTRIBUTING.md](../CONTRIBUTING.md) and [Pull Request Template](../.github/PULL_REQUEST_TEMPLATE.md).
