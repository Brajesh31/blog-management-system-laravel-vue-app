# 🧩 Editable Architecture, DFD and Workflow Diagrams

This folder contains editable source diagrams. Mermaid `.mmd` files render in GitHub Markdown. Formal PlantUML `.puml` files live in [uml/](uml/README.md) and can be rendered locally with PlantUML.

## Mermaid catalogue

| Source | View |
|---|---|
| [context.mmd](context.mmd) | System context and external actors/services |\n| [overall-project-workflow.mmd](overall-project-workflow.mmd) | Plan, design, implementation, verification, release and feedback loop |\n| [user-journey.mmd](user-journey.mmd) | Guest registration through verified author post creation |\n| [input-output.mmd](input-output.mmd) | Main input categories and Laravel outputs/data stores |
| [system-architecture.mmd](system-architecture.mmd) | High-level Laravel/Inertia/Vue system architecture |
| [low-level-architecture.mmd](low-level-architecture.mmd) | Controller/request/model/response path |
| [component-architecture.mmd](component-architecture.mmd) | Backend and frontend component groupings |
| [module-dependencies.mmd](module-dependencies.mmd) | Route-to-model and Inertia-to-Vue dependencies |
| [request-lifecycle.mmd](request-lifecycle.mmd) | HTTP request sequence |\n| [frontend-rendering-lifecycle.mmd](frontend-rendering-lifecycle.mmd) | Inertia navigation, Vue page resolution and browser rendering |\n| [database-interaction.mmd](database-interaction.mmd) | Eloquent query/persistence path and relational constraints |\n| [api-interaction.mmd](api-interaction.mmd) | Actual Laravel web/Inertia interaction, not a separate REST API |
| [authentication.mmd](authentication.mmd) | Session authentication and verification |
| [post-creation.mmd](post-creation.mmd) | Create form, validation, optional image and persistence |\n| [post-business-logic.mmd](post-business-logic.mmd) | Draft/publish validation and post persistence decisions |
| [post-visibility.mmd](post-visibility.mmd) | Current feed visibility query |
| [data-flow-level-0.mmd](data-flow-level-0.mmd) | DFD Level 0 system context |
| [data-flow-level-1.mmd](data-flow-level-1.mmd) | DFD Level 1 processes and data stores |
| [data-flow-level-2-post.mmd](data-flow-level-2-post.mmd) | DFD Level 2 post creation |
| [database-relationships.mmd](database-relationships.mmd) | Relational model and Eloquent associations |
| [class-diagram.mmd](class-diagram.mmd) | Mermaid class view of domain models |
| [use-case.mmd](use-case.mmd) | Actor/use-case summary, with incomplete workflows noted |
| [post-state.mmd](post-state.mmd) | Post visibility values; proposed transition illustration only |
| [error-handling.mmd](error-handling.mmd) | Validation and persistence failure branches |
| [content-security.mmd](content-security.mmd) | Recommended safe HTML and upload control flow |
| [integration-architecture.mmd](integration-architecture.mmd) | DB, media, mail and Inertia connections |\n| [integration-workflow.mmd](integration-workflow.mmd) | Runtime integration between browser, Laravel and configured services |
| [infrastructure.mmd](infrastructure.mmd) | Generic build and runtime topology |
| [deployment.mmd](deployment.mmd) | Release build/deploy/verify lifecycle |
| [testing-workflow.mmd](testing-workflow.mmd) | Local verification and review |
| [ci-cd-workflow.mmd](ci-cd-workflow.mmd) | Current GitHub Actions workflow groups |
| [incident-response.mmd](incident-response.mmd) | Incident containment and recovery |

## Formal UML diagrams

See [PlantUML catalogue](uml/README.md) for use-case, class, sequence, activity, state, component and deployment UML source.

## Status notation

- **Observed behavior** describes the implementation found in source.
- **Proposed control** describes a recommended future flow, not an existing implementation.
- **Known gap** identifies a missing page, unfinished action, placeholder UI or unwired workflow.

Update source diagrams when route guards, data models, request/response contracts, deployment boundaries or workflows change. Do not treat the diagrams as proof that a feature is complete.
