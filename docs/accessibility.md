# ♿ Accessibility

Accessibility is a quality requirement, not decoration. Use WCAG 2.2 AA as an engineering target and test the real interface with assistive technology. This guide is not evidence of conformance or an accessibility audit.

## ⌨️ Keyboard

- Links, buttons, menus, dialogs, editor controls and uploads must work without a pointer.
- Preserve logical tab order and a clearly visible focus state.
- Trap focus only while a modal is open and return focus when it closes.
- Make TipTap toolbar commands keyboard-operable.
- Prefer native buttons and links over clickable generic elements.

## 🧭 Structure

- Use meaningful page titles, landmarks and a logical heading hierarchy.
- Associate labels, hints and errors with their fields.
- Identify required fields in text as well as visually.
- Use descriptive link names and meaningful alternative text.
- Provide a skip link when repeated navigation comes before main content.

## 📝 Forms and editor

- Explain validation failures in text, not colour alone.
- Associate each error with its input and announce it to assistive technology.
- Preserve submitted values after server validation fails.
- Give upload controls accepted types and file size instructions.
- Announce save/publish outcomes through an appropriate live status region.
- Give TipTap editor and toolbar controls accessible names, roles and keyboard support.
- Do not rely on placeholders as the only field label or instruction.

## 🎨 Visual and responsive design

- Check text, icons, controls, borders, focus, disabled and error-state contrast.
- Do not communicate status only through colour.
- Support browser zoom and reflow at narrow widths.
- Respect `prefers-reduced-motion`.
- Provide alt text for informative images; use empty alt for decorative imagery.

## Manual test matrix

| Test | Review |
|---|---|
| Keyboard only | Login and create-post workflow with no mouse |
| Screen reader | Headings, landmarks, forms, errors, toasts and TipTap editor |
| Zoom/reflow | 200% zoom and narrow viewport without avoidable horizontal scrolling |
| Contrast | Normal/large text, buttons, boundaries and focus indicators |
| Motion | Reduced-motion preference does not hide information |
| Upload | Format, limit, errors and selected file are announced |
| Validation | Error is linked to field and understandable without colour |

## Release checklist

- [ ] Every interactive control is keyboard-operable.
- [ ] Focus order and visible focus are predictable.
- [ ] Labels, help text and errors are programmatically associated.
- [ ] Editor controls work with keyboard and screen readers.
- [ ] Status messages are announced appropriately.
- [ ] Contrast, zoom and reflow are checked.
- [ ] Reduced motion is respected.
- [ ] Accessibility review is included in each UI pull request.

Do not describe the product as WCAG-conformant until a qualified audit and representative testing support that claim.
