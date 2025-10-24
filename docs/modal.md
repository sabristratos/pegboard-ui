# Modal Component

A flexible, accessible modal dialog system using the native `<dialog>` element enhanced with Alpine.js. Supports both centered modals and flyout panels with smooth animations and multiple configuration options.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Variants](#variants)
  - [Centered Modal (Default)](#centered-modal-default)
  - [Flyout Modal](#flyout-modal)
- [Props Reference](#props-reference)
- [Positioning](#positioning)
- [Features](#features)
  - [Header and Footer Slots](#header-and-footer-slots)
  - [Backdrop Blur](#backdrop-blur)
  - [Dismissible and Closable](#dismissible-and-closable)
  - [Body Scroll Lock](#body-scroll-lock)
  - [Keyboard Navigation](#keyboard-navigation)
- [Opening and Closing Modals](#opening-and-closing-modals)
  - [JavaScript API](#javascript-api)
  - [Alpine.js Events](#alpinejs-events)
  - [Livewire Integration](#livewire-integration)
  - [Trigger Component](#trigger-component)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard modal component provides an accessible dialog solution for displaying content in overlay windows.

**Key Features:**
- Two variants: centered modal and flyout panel
- Three flyout positions: left, right, bottom
- Header and footer slots for structured layouts
- Optional backdrop blur
- Dismissible (click outside) and closable (X button) options
- Automatic body scroll lock when open
- Full keyboard accessibility (Escape to close)
- Livewire event integration

## Basic Usage

### Setup

Create a modal anywhere in your Blade templates:

```blade
{{-- Simple centered modal --}}
<x-pegboard::modal name="simple-modal">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Modal Title</h2>
        <p class="text-muted-foreground">Modal content goes here.</p>
    </div>
</x-pegboard::modal>
```

### Opening the Modal

**From JavaScript:**
```javascript
// Dispatch event to open modal
window.dispatchEvent(new CustomEvent('modal-open', {
    detail: { name: 'simple-modal' }
}));
```

**From Alpine.js:**
```blade
<button @click="$dispatch('modal-open', { name: 'simple-modal' })">
    Open Modal
</button>
```

**Using Trigger Component:**
```blade
<x-pegboard::modal.trigger name="simple-modal">
    <button class="btn-primary">Open Modal</button>
</x-pegboard::modal.trigger>
```

## Variants

### Centered Modal (Default)

The default centered modal appears in the middle of the viewport with a backdrop overlay:

```blade
<x-pegboard::modal name="centered-modal">
    <div class="bg-card rounded-lg shadow-xl p-6">
        <h2 class="text-lg font-semibold">Centered Modal</h2>
        <p class="text-sm text-muted-foreground mt-2">
            This modal is centered on the screen with a backdrop.
        </p>
    </div>
</x-pegboard::modal>
```

**Visual characteristics:**
- Centered in viewport with `fixed inset-0 m-auto`
- Max width: `lg` (32rem/512px) on desktop
- Responsive sizing: smaller on tablets and mobile
- Scale + fade animation on open/close
- Semi-transparent backdrop overlay

**Use cases:**
- Confirmation dialogs
- Short forms
- Quick actions
- Content that requires focused attention

### Flyout Modal

Flyout modals slide in from the edge of the screen (left, right, or bottom):

```blade
<x-pegboard::modal
    name="flyout-modal"
    variant="flyout"
    position="right"
>
    <div class="p-6">
        <h2 class="text-lg font-semibold">Flyout Panel</h2>
        <p class="text-sm text-muted-foreground mt-2">
            This panel slides in from the right edge.
        </p>
    </div>
</x-pegboard::modal>
```

**Visual characteristics:**
- Slides in from left, right, or bottom edge
- Full height (left/right) or partial height (bottom)
- Max width: `md` (28rem/448px) for left/right
- Flexbox layout for header/content/footer structure
- Slide animation on open/close

**Use cases:**
- Navigation drawers
- Detailed forms
- Settings panels
- Content that needs more vertical space
- Mobile-friendly layouts

## Props Reference

### Modal Component

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | **required** | Unique identifier for the modal (used to open/close) |
| `variant` | string | `'default'` | Modal variant: `default` (centered) or `flyout` |
| `position` | string | `'right'` | Flyout position: `left`, `right`, `bottom` (only for flyout variant) |
| `dismissible` | bool | `true` | Allow closing by clicking outside or pressing Escape |
| `closable` | bool | `true` | Show close button (X) in top-right corner |
| `blur` | bool | `false` | Apply backdrop blur effect |

### Slots

| Slot | Required | Description |
|------|----------|-------------|
| Default | Yes | Main modal content |
| `header` | No | Sticky header section (flyout only) |
| `footer` | No | Sticky footer section (flyout only) |

## Positioning

### Centered Modal Positioning

Centered modals always appear in the center of the viewport:

```blade
<x-pegboard::modal name="centered">
    {{-- Always centered --}}
</x-pegboard::modal>
```

**Responsive sizing:**
- Desktop: `max-w-lg` (512px)
- Tablet: `max-w-md` (448px)
- Mobile: `max-w-[calc(100vw-2rem)]` (full width minus margins)

### Flyout Positioning

Flyout modals can slide in from three positions:

#### Right (Default)

Slides in from the right edge:

```blade
<x-pegboard::modal
    name="right-flyout"
    variant="flyout"
    position="right"
>
    <div class="p-6">Content</div>
</x-pegboard::modal>
```

**Visual characteristics:**
- Full viewport height
- Max width: 448px (desktop), 384px (tablet), full width (mobile)
- Slides from right with `translateX(100%)`

**Use cases:**
- Settings panels
- User profiles
- Notifications drawer

#### Left

Slides in from the left edge:

```blade
<x-pegboard::modal
    name="left-flyout"
    variant="flyout"
    position="left"
>
    <div class="p-6">Content</div>
</x-pegboard::modal>
```

**Visual characteristics:**
- Full viewport height
- Max width: 448px (desktop), 384px (tablet), full width (mobile)
- Slides from left with `translateX(-100%)`

**Use cases:**
- Navigation menus
- Sidebar content
- Filter panels

#### Bottom

Slides up from the bottom edge:

```blade
<x-pegboard::modal
    name="bottom-flyout"
    variant="flyout"
    position="bottom"
>
    <div class="p-6">Content</div>
</x-pegboard::modal>
```

**Visual characteristics:**
- Full viewport width
- Max height: 80vh (desktop), 90vh (mobile)
- Rounded top corners
- Slides from bottom with `translateY(100%)`

**Use cases:**
- Mobile action sheets
- Quick filters
- Mobile-friendly forms
- Share/export options

## Features

### Header and Footer Slots

Flyout modals support optional header and footer slots for structured layouts:

```blade
<x-pegboard::modal
    name="structured-flyout"
    variant="flyout"
    position="right"
>
    <x-slot:header>
        <h2 class="text-lg font-semibold">Notifications</h2>
        <p class="text-sm text-muted-foreground mt-1">Recent activity</p>
    </x-slot:header>

    <div>
        {{-- Scrollable content --}}
        <p>Notification 1</p>
        <p>Notification 2</p>
        <p>Notification 3</p>
    </div>

    <x-slot:footer>
        <div class="flex gap-3 justify-end">
            <button class="btn-secondary">Mark All Read</button>
            <button class="btn-primary">View All</button>
        </div>
    </x-slot:footer>
</x-pegboard::modal>
```

**Behavior:**
- **Header**: Fixed at top, always visible
- **Content**: Scrollable middle section with padding
- **Footer**: Fixed at bottom, always visible
- Header and footer have full width (edge to edge)
- Content has internal padding

**Layout structure:**
```
┌─────────────────────┐
│ Header (fixed)      │ ← Full width, touches top
├─────────────────────┤
│                     │
│ Content (scrolls)   │ ← Has padding, scrollable
│                     │
├─────────────────────┤
│ Footer (fixed)      │ ← Full width, touches bottom
└─────────────────────┘
```

**Note:** Header and footer slots are only available for flyout modals. Centered modals should structure content manually.

### Backdrop Blur

Apply a blur effect to the backdrop for enhanced visual hierarchy:

```blade
<x-pegboard::modal name="blurred-modal" :blur="true">
    <div class="p-6">
        Content with blurred backdrop
    </div>
</x-pegboard::modal>
```

**Visual effect:**
- Applies `backdrop-blur-sm` to the backdrop
- Softens background content
- Draws more focus to modal
- Smooth transition on open/close

**Best practices:**
- Use for important dialogs that require full attention
- Avoid on mobile devices (performance)
- Works well with light backdrop color

### Dismissible and Closable

Control how users can close the modal:

**Dismissible (click outside / Escape):**

```blade
{{-- Can dismiss by clicking backdrop or pressing Escape --}}
<x-pegboard::modal name="dismissible" :dismissible="true">
    Content
</x-pegboard::modal>

{{-- Cannot dismiss except via explicit close action --}}
<x-pegboard::modal name="non-dismissible" :dismissible="false">
    Content (must use close button or API)
</x-pegboard::modal>
```

**Closable (X button):**

```blade
{{-- Shows close button --}}
<x-pegboard::modal name="closable" :closable="true">
    Content
</x-pegboard::modal>

{{-- No close button --}}
<x-pegboard::modal name="no-close-button" :closable="false">
    Content (no X button)
</x-pegboard::modal>
```

**Combinations:**

```blade
{{-- Most permissive: click outside, Escape, or X button --}}
<x-pegboard::modal name="flexible" :dismissible="true" :closable="true">

{{-- Only X button works --}}
<x-pegboard::modal name="button-only" :dismissible="false" :closable="true">

{{-- Only click outside or Escape works --}}
<x-pegboard::modal name="backdrop-only" :dismissible="true" :closable="false">

{{-- Must close via API --}}
<x-pegboard::modal name="api-only" :dismissible="false" :closable="false">
```

### Body Scroll Lock

When a modal is open, body scrolling is automatically prevented to improve the user experience and prevent background scroll on all devices.

### Keyboard Navigation

Full keyboard support for accessibility:

**Escape key:**
- Closes modal when `dismissible="true"`
- Prevented when `dismissible="false"`

**Tab key:**
- Focus traps within modal content
- Cycles through focusable elements
- Closes button receives focus on open

**Enter/Space:**
- Activates buttons and links
- Submits forms within modal

## Opening and Closing Modals

### JavaScript API

**Open a modal:**

```javascript
// Dispatch custom event
window.dispatchEvent(new CustomEvent('modal-open', {
    detail: { name: 'my-modal' }
}));

// Alternative event name
window.dispatchEvent(new CustomEvent('modal-show', {
    detail: { name: 'my-modal' }
}));
```

**Close a modal:**

```javascript
// Close specific modal
window.dispatchEvent(new CustomEvent('modal-close', {
    detail: { name: 'my-modal' }
}));

// Close all modals
window.dispatchEvent(new CustomEvent('modal-close'));
```

### Alpine.js Events

**From Alpine components:**

```blade
<div x-data>
    {{-- Open modal --}}
    <button @click="$dispatch('modal-open', { name: 'settings' })">
        Open Settings
    </button>

    {{-- Close modal --}}
    <button @click="$dispatch('modal-close', { name: 'settings' })">
        Close
    </button>
</div>
```

**Listen for modal events:**

```blade
<div
    x-data
    @modal-closed.window="console.log('Modal closed')"
    @modal-cancelled.window="console.log('Modal cancelled via Escape')"
>
</div>
```

### Livewire Integration

**From Livewire components:**

```php
// In your Livewire component
public function openModal()
{
    $this->dispatch('modal-open', name: 'edit-profile');
}

public function closeModal()
{
    $this->dispatch('modal-close', name: 'edit-profile');
}
```

**In Blade:**

```blade
<button wire:click="openModal">Edit Profile</button>
```

### Trigger Component

Use the dedicated trigger component for cleaner markup:

```blade
<x-pegboard::modal.trigger name="confirmation">
    <button class="btn-danger">Delete Account</button>
</x-pegboard::modal.trigger>

<x-pegboard::modal name="confirmation">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
        <p class="mb-6">Are you sure you want to delete your account?</p>
        <div class="flex gap-3 justify-end">
            <button @click="$dispatch('modal-close')">Cancel</button>
            <button class="btn-danger">Delete</button>
        </div>
    </div>
</x-pegboard::modal>
```

**Trigger behavior:**
- Wraps content in a div with `@click` listener
- Dispatches `modal-open` event with modal name
- Works with any content (buttons, links, divs, etc.)

## Examples

### Confirmation Dialog

```blade
<x-pegboard::modal name="delete-confirmation" :blur="true">
    <div class="bg-card rounded-lg shadow-xl p-6 max-w-md">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <x-pegboard::icon name="exclamation-triangle" class="w-6 h-6 text-warning" />
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-semibold mb-2">Delete Item?</h2>
                <p class="text-sm text-muted-foreground mb-6">
                    This action cannot be undone. The item will be permanently deleted.
                </p>
                <div class="flex gap-3 justify-end">
                    <button
                        @click="$dispatch('modal-close')"
                        class="px-4 py-2 text-sm border border-border rounded hover:bg-muted"
                    >
                        Cancel
                    </button>
                    <button class="px-4 py-2 text-sm bg-destructive text-destructive-foreground rounded hover:bg-destructive/90">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-pegboard::modal>

<x-pegboard::modal.trigger name="delete-confirmation">
    <button class="btn-danger">Delete Item</button>
</x-pegboard::modal.trigger>
```

### Settings Panel (Flyout)

```blade
<x-pegboard::modal
    name="settings-panel"
    variant="flyout"
    position="right"
>
    <x-slot:header>
        <h2 class="text-lg font-semibold">Settings</h2>
        <p class="text-sm text-muted-foreground mt-1">Manage your preferences</p>
    </x-slot:header>

    <div class="space-y-6">
        <div>
            <h3 class="font-medium mb-2">Notifications</h3>
            <label class="flex items-center gap-2">
                <input type="checkbox" class="pegboard-checkbox">
                <span class="text-sm">Email notifications</span>
            </label>
        </div>

        <div>
            <h3 class="font-medium mb-2">Theme</h3>
            <select class="w-full border border-border rounded px-3 py-2">
                <option>Light</option>
                <option>Dark</option>
                <option>System</option>
            </select>
        </div>

        <div>
            <h3 class="font-medium mb-2">Language</h3>
            <select class="w-full border border-border rounded px-3 py-2">
                <option>English</option>
                <option>Spanish</option>
                <option>French</option>
            </select>
        </div>
    </div>

    <x-slot:footer>
        <div class="flex gap-3 justify-end">
            <button
                @click="$dispatch('modal-close')"
                class="px-4 py-2 text-sm border border-border rounded hover:bg-muted"
            >
                Cancel
            </button>
            <button class="px-4 py-2 text-sm bg-primary text-primary-foreground rounded hover:bg-primary/90">
                Save Changes
            </button>
        </div>
    </x-slot:footer>
</x-pegboard::modal>
```

### Mobile Action Sheet (Bottom Flyout)

```blade
<x-pegboard::modal
    name="share-sheet"
    variant="flyout"
    position="bottom"
>
    <x-slot:header>
        <h2 class="text-lg font-semibold">Share</h2>
    </x-slot:header>

    <div class="grid grid-cols-4 gap-4">
        <button class="flex flex-col items-center gap-2 p-3 hover:bg-muted rounded">
            <x-pegboard::icon name="envelope" class="w-6 h-6" />
            <span class="text-xs">Email</span>
        </button>
        <button class="flex flex-col items-center gap-2 p-3 hover:bg-muted rounded">
            <x-pegboard::icon name="link" class="w-6 h-6" />
            <span class="text-xs">Copy Link</span>
        </button>
        <button class="flex flex-col items-center gap-2 p-3 hover:bg-muted rounded">
            <x-pegboard::icon name="document-duplicate" class="w-6 h-6" />
            <span class="text-xs">Duplicate</span>
        </button>
        <button class="flex flex-col items-center gap-2 p-3 hover:bg-muted rounded">
            <x-pegboard::icon name="arrow-down-tray" class="w-6 h-6" />
            <span class="text-xs">Download</span>
        </button>
    </div>
</x-pegboard::modal>
```

### Form Modal with Livewire

```blade
<x-pegboard::modal name="edit-profile">
    <div class="bg-card rounded-lg shadow-xl p-6 max-w-lg w-full">
        <h2 class="text-lg font-semibold mb-4">Edit Profile</h2>

        <form wire:submit="saveProfile">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input
                        type="text"
                        wire:model="name"
                        class="w-full border border-border rounded px-3 py-2"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input
                        type="email"
                        wire:model="email"
                        class="w-full border border-border rounded px-3 py-2"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Bio</label>
                    <textarea
                        wire:model="bio"
                        rows="4"
                        class="w-full border border-border rounded px-3 py-2"
                    ></textarea>
                </div>
            </div>

            <div class="flex gap-3 justify-end mt-6">
                <button
                    type="button"
                    @click="$dispatch('modal-close')"
                    class="px-4 py-2 text-sm border border-border rounded hover:bg-muted"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-sm bg-primary text-primary-foreground rounded hover:bg-primary/90"
                >
                    Save Profile
                </button>
            </div>
        </form>
    </div>
</x-pegboard::modal>
```

### Non-Dismissible Modal

```blade
<x-pegboard::modal
    name="processing"
    :dismissible="false"
    :closable="false"
>
    <div class="bg-card rounded-lg shadow-xl p-8 text-center">
        <x-pegboard::spinner class="mx-auto mb-4" />
        <h2 class="text-lg font-semibold mb-2">Processing...</h2>
        <p class="text-sm text-muted-foreground">
            Please wait while we process your request.
        </p>
    </div>
</x-pegboard::modal>
```

## Best Practices

### 1. Choose the Right Variant

**Use centered modals for:**
- Quick confirmations
- Short forms (1-3 fields)
- Alerts and warnings
- Simple choices

**Use flyout modals for:**
- Settings panels
- Long forms
- Detailed content
- Navigation drawers
- Mobile-first designs

### 2. Provide Clear Exit Options

```blade
{{-- Good: Multiple ways to close --}}
<x-pegboard::modal name="good-modal" :dismissible="true" :closable="true">
    <div class="p-6">
        Content
        <button @click="$dispatch('modal-close')">Cancel</button>
    </div>
</x-pegboard::modal>

{{-- Bad: Only programmatic close --}}
<x-pegboard::modal name="bad-modal" :dismissible="false" :closable="false">
    <div class="p-6">
        Content (no way to close!)
    </div>
</x-pegboard::modal>
```

### 3. Use Header/Footer Slots Appropriately

```blade
{{-- Good: Structured flyout --}}
<x-pegboard::modal variant="flyout" position="right">
    <x-slot:header>Title and context</x-slot:header>
    Scrollable content
    <x-slot:footer>Action buttons</x-slot:footer>
</x-pegboard::modal>

{{-- Bad: Mixing patterns --}}
<x-pegboard::modal variant="flyout">
    <div class="sticky top-0">Custom header (use slot instead)</div>
</x-pegboard::modal>
```

### 4. Match Modal Size to Content

```blade
{{-- Good: Appropriate sizing --}}
<x-pegboard::modal name="small-form">
    <div class="p-6 max-w-md">
        Short form
    </div>
</x-pegboard::modal>

{{-- Bad: Too small for content --}}
<x-pegboard::modal name="large-content">
    <div class="p-6 w-48">
        Very long content that needs more space...
    </div>
</x-pegboard::modal>
```

### 5. Handle Loading States

```blade
<x-pegboard::modal name="form-modal">
    <div class="p-6" x-data="{ loading: false }">
        <form @submit.prevent="loading = true; submitForm()">
            <input type="text" name="name">

            <button
                type="submit"
                :disabled="loading"
                class="btn-primary"
            >
                <span x-show="!loading">Submit</span>
                <span x-show="loading" class="flex items-center gap-2">
                    <x-pegboard::spinner size="sm" />
                    Submitting...
                </span>
            </button>
        </form>
    </div>
</x-pegboard::modal>
```

### 6. Test Mobile Experience

```blade
{{-- Good: Mobile-friendly bottom sheet --}}
<x-pegboard::modal
    variant="flyout"
    position="bottom"
    class="@max-md:rounded-t-2xl"
>
    Mobile optimized content
</x-pegboard::modal>
```

## Accessibility

The modal component follows WCAG 2.1 guidelines and ARIA best practices:

### ARIA Attributes

The modal component includes proper ARIA attributes for screen reader compatibility and accessibility.

### Focus Management

**On open:**
- Focus moves to first focusable element inside modal
- Falls back to dialog element if no focusable elements exist
- Tab cycles through modal content only

**On close:**
- Focus returns to triggering element
- Background content becomes accessible again

### Keyboard Support

| Key | Action |
|-----|--------|
| `Escape` | Closes modal (if dismissible) |
| `Tab` | Cycles through focusable elements |
| `Shift + Tab` | Cycles backward |
| `Enter/Space` | Activates buttons/links |

### Screen Reader Announcements

**Modal opening:**
- Screen readers announce dialog role
- Content is read immediately
- Background content marked as inert

**Recommended practices:**

```blade
{{-- Good: Descriptive heading --}}
<x-pegboard::modal name="accessible-modal">
    <div class="p-6">
        <h2 id="modal-title">Delete Confirmation</h2>
        <p id="modal-description">This action cannot be undone.</p>
    </div>
</x-pegboard::modal>

{{-- Even better: Add ARIA labels --}}
<dialog
    aria-labelledby="modal-title"
    aria-describedby="modal-description"
>
```

### Color Contrast

All modal elements meet WCAG AA standards:
- Text on backgrounds: 4.5:1 minimum
- Backdrop overlay: Sufficient contrast
- Focus indicators: 3:1 minimum
- Border colors: Visible against backgrounds

### Reduced Motion

Modals respect `prefers-reduced-motion`:

```css
@media (prefers-reduced-motion: reduce) {
    dialog {
        transition: none;
    }
}
```

Users with motion sensitivity see:
- No slide animations
- No scale animations
- Instant appear/disappear
- Full functionality maintained

---

## Additional Resources

- [MDN: `<dialog>` element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog)
- [ARIA: dialog role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/dialog_role)
- [Alpine.js Documentation](https://alpinejs.dev)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
