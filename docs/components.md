# 🧩 Frontend Component Reference

This is an inventory of major reusable components from the current tree. It is not a claim that every component is used on every page.

## Layout and navigation

| Component | Role |
|---|---|
| Layouts/MainLayout.vue | Primary page shell, top navigation, mobile sheet, toast host and footer |
| Components/layouts/main/PrimaryNavbar.vue | Main desktop navigation |
| Components/layouts/main/MobileMenuSheet.vue | Responsive navigation sheet |
| Components/layouts/main/GuestAuthButtons.vue | Guest login/register actions |
| Components/layouts/main/UserDropdownMenu.vue | Authenticated user menu |
| Components/layouts/main/SearchBar.vue | Search input presentation |
| Components/layouts/main/NotificationPopover.vue | Notification presentation component |

**Important limitation:** MainLayout currently initializes a local placeholder notifications array and contains no-op search and notification handlers. These UI elements are not yet evidence of a persisted search/notification backend.

## Authentication

- Components/auth/LoginModal.vue
- Components/auth/RegistrationModal.vue
- Pages/Auth/Login.vue
- Pages/Auth/Register.vue
- Pages/Auth/ForgotPassword.vue
- Pages/Auth/ResetPassword.vue
- Pages/Auth/VerifyEmail.vue
- Pages/Auth/ConfirmPassword.vue

The corresponding authentication routes and controllers are in routes/auth.php and app/Http/Controllers/Auth/.

## Home page

- Pages/Home.vue
- Components/home/CommunityJoinCard.vue
- Components/home/ChallengesCard.vue

The home page also uses the shared MainLayout and auth composable.

## Rich text editor

| Component | Responsibility |
|---|---|
| Components/tiptap/TiptapEditor.vue | TipTap editor state and HTML model binding |
| Components/tiptap/TiptapToolbar.vue | Formatting actions for the editor |

The editor config uses StarterKit, Placeholder, Link and Image extensions. Its output is HTML. Editor configuration is not an HTML sanitizer. Stored content must be sanitized or rendered through a safe allowlist before it is shown to other users.

## Shared UI primitives

| Folder | Present component family |
|---|---|
| ui/alert | Alert, AlertTitle, AlertDescription |
| ui/avatar | Avatar, AvatarFallback, AvatarImage |
| ui/button | Button |
| ui/card | Card, CardAction, CardContent, CardDescription, CardFooter, CardHeader, CardTitle |
| ui/checkbox | Checkbox |
| ui/dialog | Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogOverlay, DialogScrollContent, DialogTitle, DialogTrigger |
| ui/dropdown-menu | DropdownMenu, checkbox/radio items, Content, Group, Item, Label, Separator, Shortcut, Sub, SubContent, SubTrigger and Trigger |
| ui/form | FormControl, FormDescription, FormItem, FormLabel, FormMessage, injection keys and field helper |
| ui/input | Input |
| ui/label | Label |
| ui/popover | Popover, PopoverAnchor, PopoverContent, PopoverTrigger |
| ui/separator | Separator |
| ui/sheet | Sheet, SheetClose, SheetContent, SheetDescription, SheetFooter, SheetHeader, SheetOverlay, SheetTitle, SheetTrigger |
| ui/sonner | Sonner toast provider |

## Other reusable components

The root Components folder also contains ApplicationLogo, Checkbox, DangerButton, Dropdown, DropdownLink, InputError, InputLabel, Modal, NavLink, PrimaryButton, ResponsiveNavLink, SecondaryButton and TextInput.

## State and utility modules

- hooks/useAuth.ts: composable for current authentication context.
- stores/modal.ts: Pinia modal state.
- lib/utils.ts: shared utility functions.
- types/: shared global and Vite type declarations.

## Component quality requirements

- Use semantic HTML and native controls where possible.
- Provide accessible names for icon-only buttons.
- Preserve keyboard focus and Escape behavior for overlays.
- Ensure dialogs and sheets manage focus correctly.
- Use responsive sizing and visible error states.
- Avoid side effects that assume placeholder data is a real service.
