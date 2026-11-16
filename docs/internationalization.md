# 🌍 Internationalization and Localization

The sample environment sets Laravel's default locale to English. The frontend currently contains user-facing text directly in Vue templates and scripts. No complete translation catalogue or language-switching workflow was identified.

## Current state
- Laravel locale defaults are configured through environment settings.
- Frontend copy is primarily literal English text.
- No evidence of a completed locale selector, translated route strategy or date/number localization layer is present.

## Recommended approach if multilingual support is required
1. Confirm target languages and who maintains translations.
2. Move frontend text into translation resources rather than scattering literals.
3. Use Laravel language files for server-side validation and mail content.
4. Use locale-aware date, number and plural formatting.
5. Ensure language selection persists intentionally and does not leak across accounts.
6. Add tests for missing translation keys and long translated labels.
7. Test keyboard support and screen-reader output in each language.
8. Use appropriate HTML lang attributes and localized metadata.

Do not claim multilingual support until routes, forms, errors, email and all user-facing pages have been translated and tested.
