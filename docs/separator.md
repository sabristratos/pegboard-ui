# Separator Component

A versatile, accessible separator component for dividing content sections with support for horizontal and vertical orientations, text labels, custom slot content, and subtle styling variants.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Props Reference](#props-reference)
- [Orientation](#orientation)
  - [Horizontal Separators](#horizontal-separators)
  - [Vertical Separators](#vertical-separators)
- [Variants](#variants)
- [Content](#content)
  - [Text Labels](#text-labels)
  - [Custom Slot Content](#custom-slot-content)
- [Styling](#styling)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard separator component provides a clean, semantic way to visually divide content sections or inline elements. Built with Tailwind CSS v4, it supports both horizontal and vertical orientations with optional text labels or custom content.

**Key Features:**
- Horizontal and vertical orientations
- Two visual variants (default, subtle)
- Text prop for simple labels
- Slot support for custom content (icons, badges, etc.)
- Flexible height/width control via Tailwind classes
- Uses semantic theme tokens for consistent styling
- Fully accessible with proper ARIA roles

## Basic Usage

The simplest separator is a horizontal line with no additional content:

```blade
<div>First section</div>
<x-pegboard::separator />
<div>Second section</div>
```

This renders a horizontal line (`<hr>`) with the default border color from your theme.

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `vertical` | boolean | `false` | Display as vertical separator instead of horizontal |
| `variant` | string | `'default'` | Visual style: `default` (border-border), `subtle` (border-muted) |
| `text` | string\|null | `null` | Simple text label to display in the center |
| `orientation` | string | `'horizontal'` | Alternative to `vertical` prop: `horizontal` or `vertical` |

**Note:** Both `vertical` prop and `orientation="vertical"` work identically. Use whichever feels more natural in your context.

## Orientation

### Horizontal Separators

Horizontal separators divide content vertically, creating visual breaks between sections:

```blade
<div class="space-y-4">
    <div>First section content</div>
    <x-pegboard::separator />
    <div>Second section content</div>
</div>
```

**Renders:**
- `<hr>` element with `border-t` styling
- Full width (`w-full`) by default
- Can be customized with additional classes

### Vertical Separators

Vertical separators divide content horizontally, perfect for inline elements like navigation menus or toolbars:

```blade
<div class="flex items-center gap-4">
    <button>Home</button>
    <x-pegboard::separator vertical class="h-8" />
    <button>About</button>
    <x-pegboard::separator vertical class="h-8" />
    <button>Contact</button>
</div>
```

**Important:** Vertical separators require explicit height control via margin or height classes:

```blade
{{-- Using height class --}}
<x-pegboard::separator vertical class="h-6" />

{{-- Using vertical margin (creates limited height) --}}
<x-pegboard::separator vertical class="my-2" />
```

**Renders:**
- `<div>` element with `border-l` styling
- Inline-block display
- Self-stretch by default
- Requires parent flex/grid context

## Variants

### Default

Standard border color matching your theme's primary border color:

```blade
<x-pegboard::separator />
<x-pegboard::separator vertical class="h-8" />
```

**Visual characteristics:**
- Uses `border-border` color (standard theme border)
- More prominent visual division
- Best for clear content separation

### Subtle

Lighter border color for less prominent divisions:

```blade
<x-pegboard::separator variant="subtle" />
<x-pegboard::separator vertical variant="subtle" class="h-6" />
```

**Visual characteristics:**
- Uses `border-muted` color (lighter than default)
- Softer visual separation
- Best for grouping related content

## Content

### Text Labels

Add simple text labels to separators using the `text` prop:

```blade
{{-- Horizontal with text --}}
<x-pegboard::separator text="or" />

{{-- Common use case: login forms --}}
<div>Login with email</div>
<x-pegboard::separator text="or" />
<div>Login with social media</div>
```

**Behavior:**
- Text is centered between two separator lines
- Uses `text-muted-foreground` color
- Small font size (`text-sm`)
- Whitespace preserved (`whitespace-nowrap`)

### Custom Slot Content

For more complex content (icons, badges, buttons), use the default slot:

```blade
{{-- With badge --}}
<x-pegboard::separator>
    <x-pegboard::badge color="primary" variant="flat">OR</x-pegboard::badge>
</x-pegboard::separator>

{{-- With icon --}}
<x-pegboard::separator>
    <x-pegboard::icon name="chevron-down" class="h-4 w-4 text-muted-foreground" />
</x-pegboard::separator>

{{-- Vertical with icon --}}
<div class="flex items-center gap-3">
    <span>Previous</span>
    <x-pegboard::separator vertical>
        <x-pegboard::icon name="arrow-right" class="h-4 w-4" />
    </x-pegboard::separator>
    <span>Next</span>
</div>
```

**Behavior:**
- Slot content is centered between separator lines
- Works with both horizontal and vertical orientations
- Content receives flex layout and gap spacing
- Automatically shrinks to fit content

## Styling

### Height Control (Vertical)

Control vertical separator height using Tailwind utilities:

```blade
{{-- Fixed height --}}
<x-pegboard::separator vertical class="h-4" />
<x-pegboard::separator vertical class="h-6" />
<x-pegboard::separator vertical class="h-8" />

{{-- Height via vertical margin --}}
<x-pegboard::separator vertical class="my-1" />  {{-- ~h-4 equivalent --}}
<x-pegboard::separator vertical class="my-2" />  {{-- ~h-6 equivalent --}}
<x-pegboard::separator vertical class="my-3" />  {{-- ~h-8 equivalent --}}
```

### Additional Classes

Any additional classes are merged with the base styles:

```blade
{{-- Custom spacing --}}
<x-pegboard::separator class="my-8" />

{{-- Custom opacity --}}
<x-pegboard::separator class="opacity-50" />

{{-- Custom vertical height --}}
<x-pegboard::separator vertical class="h-12" />
```

## Examples

### Basic Horizontal Division

```blade
<div class="space-y-6">
    <section>
        <h2>Introduction</h2>
        <p>Welcome to our application...</p>
    </section>

    <x-pegboard::separator />

    <section>
        <h2>Getting Started</h2>
        <p>Follow these steps...</p>
    </section>
</div>
```

### Login Form with "Or" Separator

```blade
<form class="space-y-4">
    <input type="email" placeholder="Email" />
    <input type="password" placeholder="Password" />
    <button type="submit">Login</button>
</form>

<x-pegboard::separator text="or" />

<div class="flex gap-2">
    <button>Continue with Google</button>
    <button>Continue with GitHub</button>
</div>
```

### Navigation Menu with Vertical Separators

```blade
<nav class="flex items-center gap-2 p-4 bg-card rounded-lg border">
    <button>Dashboard</button>
    <x-pegboard::separator vertical class="h-4" />
    <button>Projects</button>
    <x-pegboard::separator vertical class="h-4" />
    <button>Team</button>
    <x-pegboard::separator vertical class="h-4" />
    <button>Settings</button>
</nav>
```

### Editor Toolbar with Grouped Actions

```blade
<div class="flex items-center gap-2 p-2 bg-card rounded-lg border">
    {{-- Text formatting --}}
    <button>Bold</button>
    <button>Italic</button>
    <button>Underline</button>

    <x-pegboard::separator vertical class="h-6" />

    {{-- Insert elements --}}
    <button>Link</button>
    <button>Image</button>
    <button>Video</button>

    <x-pegboard::separator vertical class="h-6" />

    {{-- Lists --}}
    <button>Bullet List</button>
    <button>Numbered List</button>
</div>
```

### Form Sections with Labeled Separators

```blade
<div class="p-6 bg-card rounded-lg border space-y-6">
    <section>
        <h3>Personal Information</h3>
        <p class="text-sm text-muted-foreground">Enter your basic details</p>
        <!-- Form fields -->
    </section>

    <x-pegboard::separator text="Account Details" />

    <section>
        <h3>Login Credentials</h3>
        <p class="text-sm text-muted-foreground">Set up your account access</p>
        <!-- Form fields -->
    </section>

    <x-pegboard::separator text="Preferences" />

    <section>
        <h3>Notification Settings</h3>
        <p class="text-sm text-muted-foreground">Manage how you receive updates</p>
        <!-- Form fields -->
    </section>
</div>
```

### Subtle Separators for Related Content

```blade
<div class="space-y-3">
    <div class="text-sm">
        <strong>Step 1:</strong> Create your account
    </div>
    <x-pegboard::separator variant="subtle" />

    <div class="text-sm">
        <strong>Step 2:</strong> Verify your email
    </div>
    <x-pegboard::separator variant="subtle" />

    <div class="text-sm">
        <strong>Step 3:</strong> Complete your profile
    </div>
</div>
```

### Separator with Badge Content

```blade
<div class="space-y-4">
    <div class="p-4 bg-muted/20 rounded">Premium features</div>

    <x-pegboard::separator>
        <x-pegboard::badge color="primary" variant="flat">UPGRADE</x-pegboard::badge>
    </x-pegboard::separator>

    <div class="p-4 bg-muted/20 rounded">Free features</div>
</div>
```

### Vertical Separator with Orientation Prop

```blade
<div class="flex items-center gap-4">
    <x-pegboard::badge color="primary">Active</x-pegboard::badge>
    <x-pegboard::separator orientation="vertical" class="h-6" />
    <x-pegboard::badge color="success">Verified</x-pegboard::badge>
    <x-pegboard::separator orientation="vertical" class="h-6" />
    <x-pegboard::badge color="warning">Pending</x-pegboard::badge>
</div>
```

### Breadcrumb-Style Navigation

```blade
<div class="flex items-center gap-2 text-sm">
    <a href="#">Home</a>
    <x-pegboard::separator vertical class="h-3" />
    <a href="#">Products</a>
    <x-pegboard::separator vertical class="h-3" />
    <a href="#">Category</a>
    <x-pegboard::separator vertical class="h-3" />
    <span class="text-muted-foreground">Product Name</span>
</div>
```

## Best Practices

### 1. Choose the Right Orientation

**Horizontal separators** divide content vertically:
```blade
{{-- ✅ Good - Separating sections --}}
<section>...</section>
<x-pegboard::separator />
<section>...</section>
```

**Vertical separators** divide content horizontally:
```blade
{{-- ✅ Good - Inline navigation --}}
<div class="flex items-center gap-4">
    <button>Item 1</button>
    <x-pegboard::separator vertical class="h-6" />
    <button>Item 2</button>
</div>
```

### 2. Always Set Height for Vertical Separators

```blade
{{-- ✅ Good - Explicit height --}}
<x-pegboard::separator vertical class="h-8" />
<x-pegboard::separator vertical class="my-2" />

{{-- ❌ Bad - No height control --}}
<x-pegboard::separator vertical />
```

### 3. Use Subtle Variant for Grouping

```blade
{{-- ✅ Good - Subtle for related items --}}
<div class="space-y-3">
    <div>Related item 1</div>
    <x-pegboard::separator variant="subtle" />
    <div>Related item 2</div>
</div>

{{-- ✅ Good - Default for distinct sections --}}
<section>Major section 1</section>
<x-pegboard::separator />
<section>Major section 2</section>
```

### 4. Use Text Sparingly

```blade
{{-- ✅ Good - Meaningful text labels --}}
<x-pegboard::separator text="or" />
<x-pegboard::separator text="Additional Options" />

{{-- ❌ Avoid - Decorative or redundant text --}}
<x-pegboard::separator text="---" />
<x-pegboard::separator text="Separator" />
```

### 5. Match Parent Layout

```blade
{{-- ✅ Good - Flex parent for vertical --}}
<div class="flex items-center gap-4">
    <span>Left</span>
    <x-pegboard::separator vertical class="h-6" />
    <span>Right</span>
</div>

{{-- ✅ Good - Block parent for horizontal --}}
<div class="space-y-4">
    <div>Top</div>
    <x-pegboard::separator />
    <div>Bottom</div>
</div>
```

### 6. Provide Visual Rhythm

Use consistent separator spacing:

```blade
{{-- ✅ Good - Consistent spacing --}}
<div class="space-y-6">
    <section>Section 1</section>
    <x-pegboard::separator />
    <section>Section 2</section>
    <x-pegboard::separator />
    <section>Section 3</section>
</div>
```

### 7. Combine with Spacing Utilities

```blade
{{-- ✅ Good - Separator with surrounding space --}}
<div class="my-8">
    <x-pegboard::separator />
</div>

{{-- ✅ Good - Using space-y for consistent gaps --}}
<div class="space-y-6">
    <div>Content</div>
    <x-pegboard::separator />
    <div>More content</div>
</div>
```

### 8. Don't Overuse Separators

```blade
{{-- ❌ Bad - Too many separators --}}
<div>
    <p>Line 1</p>
    <x-pegboard::separator />
    <p>Line 2</p>
    <x-pegboard::separator />
    <p>Line 3</p>
</div>

{{-- ✅ Good - Use spacing instead --}}
<div class="space-y-4">
    <p>Line 1</p>
    <p>Line 2</p>
    <p>Line 3</p>
</div>
```

## Accessibility

The separator component follows semantic HTML and accessibility best practices:

### Semantic HTML

**Horizontal separators** use the `<hr>` element:
```html
<!-- Rendered output -->
<hr class="w-full border-t border-border" />
```

The `<hr>` element has implicit ARIA role of `separator` and is recognized by screen readers as a thematic break.

**Vertical separators** use a `<div>` element with visual styling:
```html
<!-- Rendered output -->
<div class="inline-block self-stretch w-px border-l border-border"></div>
```

### ARIA Roles

The `<hr>` element has an implicit `role="separator"` and does not need additional ARIA attributes for basic usage.

### Screen Reader Behavior

- **Horizontal `<hr>`**: Announced as "separator" or "horizontal rule"
- **Vertical `<div>`**: Not announced (purely decorative)
- **Text labels**: Read aloud by screen readers
- **Slot content**: Content is read based on its semantic markup

### Best Practices for Accessibility

**1. Use semantic separators appropriately:**

```blade
{{-- ✅ Good - Semantic thematic break --}}
<section>
    <h2>Introduction</h2>
    <p>Content...</p>
</section>
<x-pegboard::separator />
<section>
    <h2>Details</h2>
    <p>More content...</p>
</section>

{{-- ❌ Avoid - Using separators for decorative purposes only --}}
<x-pegboard::separator />
<x-pegboard::separator />
<x-pegboard::separator />
```

**2. Provide context with headings:**

```blade
{{-- ✅ Good - Headings provide structure --}}
<h2>User Information</h2>
<p>Personal details...</p>
<x-pegboard::separator text="Account Settings" />
<h2>Account Settings</h2>
<p>Preferences...</p>
```

**3. Text labels should be meaningful:**

```blade
{{-- ✅ Good - Meaningful label --}}
<x-pegboard::separator text="Payment Options" />

{{-- ❌ Avoid - Decorative or unclear text --}}
<x-pegboard::separator text="***" />
```

**4. Don't rely on separators alone for structure:**

Use proper headings, sections, and landmarks:

```blade
{{-- ✅ Good - Proper semantic structure --}}
<section aria-labelledby="profile-heading">
    <h2 id="profile-heading">Profile</h2>
    <p>Profile content...</p>
</section>

<x-pegboard::separator />

<section aria-labelledby="settings-heading">
    <h2 id="settings-heading">Settings</h2>
    <p>Settings content...</p>
</section>
```

**5. Custom slot content should be accessible:**

```blade
{{-- ✅ Good - Accessible icon with context --}}
<x-pegboard::separator>
    <x-pegboard::icon name="chevron-down" aria-hidden="true" class="h-4 w-4" />
</x-pegboard::separator>

{{-- ✅ Good - Accessible badge --}}
<x-pegboard::separator>
    <x-pegboard::badge color="primary">OR</x-pegboard::badge>
</x-pegboard::separator>
```

### Visual Presentation

Separators meet WCAG AA standards for non-text contrast:
- Border color contrast: 3:1 minimum against background
- Text labels: 4.5:1 contrast ratio minimum
- Theme tokens ensure consistent, accessible colors

---

## Additional Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [MDN: `<hr>` element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/hr)
- [ARIA: separator role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/separator_role)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
