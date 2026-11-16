# UML Source Diagrams

This folder contains editable PlantUML source for the UML views in the repository. GitHub does not render PlantUML source natively in the same way as Mermaid. To export an SVG locally, install Java and PlantUML, then run:

```bash
plantuml -tsvg *.puml
```

Keep the source committed. Treat these diagrams as design and implementation maps, not substitutes for source code. Post lifecycle and social workflows marked incomplete must remain clearly labeled.

## Catalogue

- use-case.puml: actors and application use cases.
- class-diagram.puml: principal Eloquent domain classes and associations.
- sequence-post-creation.puml: current post creation request sequence.
- activity-post-creation.puml: post creation activity.
- state-post-visibility.puml: database visibility values, with a note that transition rules are not implemented.
- component-diagram.puml: browser, Inertia, Laravel, model and storage components.
- deployment-diagram.puml: generic runtime deployment topology.
