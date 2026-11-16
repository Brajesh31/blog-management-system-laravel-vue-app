# 🔎 Pull request

## Summary
Describe the user problem and implementation. Link relevant issues.

## Scope
- [ ] Backend routes/controllers/Form Requests
- [ ] Vue/Inertia interface
- [ ] Database migration/factory/seeder
- [ ] Documentation/diagram
- [ ] CI/workflow/template

## Verification
- [ ] `php artisan test` against a disposable test database
- [ ] `vendor/bin/pint --test`
- [ ] `npm run build`
- [ ] Manually checked changed routes and failure states
- [ ] Reviewed migration and rollback impact

## Security and privacy
- [ ] Server-side authorization and ownership are implemented and tested
- [ ] Input validation and rich HTML sanitization are addressed
- [ ] Upload content, visibility and cleanup are addressed
- [ ] No secrets, cookies, database dumps, private content or personal data included
- [ ] Logging and retention implications reviewed

## Accessibility and UX
- [ ] Keyboard operation and visible focus checked
- [ ] Labels, errors and status announcements checked
- [ ] Responsive layout and contrast checked
- [ ] Reduced motion and assistive technology impact considered

## Documentation and evidence
- [ ] README/docs/routes/database/roadmap updated as needed
- [ ] Mermaid source diagrams updated as needed
- [ ] Screenshots show the actual changed interface and contain no private data
- [ ] Limitations and checks not run are stated honestly
