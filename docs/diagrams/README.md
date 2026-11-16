# 🧩 Editable Architecture and Workflow Diagrams

Every `.mmd` file in this folder is editable Mermaid source. GitHub renders Mermaid in Markdown; keep source in sync with behavior.

| Source | Purpose |
|---|---|
| [system-architecture.mmd](system-architecture.mmd) | Browser, Laravel, Inertia, Vue, database and filesystem |
| [request-lifecycle.mmd](request-lifecycle.mmd) | Middleware, validation, models and response |
| [authentication.mmd](authentication.mmd) | Session login and verified-account access |
| [post-creation.mmd](post-creation.mmd) | Create form, upload, validation and persistence |
| [post-visibility.mmd](post-visibility.mmd) | Current feed visibility rules |
| [database-relationships.mmd](database-relationships.mmd) | Main relational model |
| [deployment.mmd](deployment.mmd) | Build and release flow |
| [incident-response.mmd](incident-response.mmd) | Incident handling |
| [content-security.mmd](content-security.mmd) | Recommended safe content handling |

Solid behavior is code-observed. Proposed control paths are recommendations, not implemented feature claims. Update diagrams when routes, guards, data relationships or release operations change.
