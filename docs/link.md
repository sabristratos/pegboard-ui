# Link Component

An accessible, interactive link component with semantic variants, auto-detection of external links, and proper keyboard navigation support.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Props Reference](#props-reference)
- [Variants](#variants)
- [Underline Behavior](#underline-behavior)
- [Sizes](#sizes)
- [External Links](#external-links)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard Link component provides consistent, accessible navigation with automatic external link detection, multiple style variants, and full keyboard support. Built with semantic HTML and proper ARIA attributes.

**Key Features:**
- 3 semantic variants (default, muted, primary)
- 3 underline options (always, hover, none)
- 3 size variants (sm, base, lg)
- Auto-detection of external links
- External link icon indicator
- Proper focus states
- Smooth color transitions
- Dark mode support
- Full keyboard accessibility

## Basic Usage

### Simple Link

```blade
{{-- Internal link --}}
<x-pegboard::link href="/about">
    About Us
</x-pegboard::link>
```

### External Link

```blade
{{-- Auto-detected as external --}}
<x-pegboard::link href="https://github.com">
    GitHub
</x-pegboard::link>
{{-- Automatically adds target="_blank" and external icon --}}
```

### Styled Link

```blade
{{-- Primary variant with custom underline --}}
<x-pegboard::link href="/docs" variant="primary" underline="none">
    Documentation
</x-pegboard::link>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `href` | string | required | Link destination URL |
| `variant` | string | `'default'` | Style variant: `default`, `muted`, `primary` |
| `underline` | string | `'always'` | Underline style: `always`, `hover`, `none` |
| `size` | string | `'base'` | Text size: `sm`, `base`, `lg` |
| `external` | bool\|null | auto | Force external link behavior (auto-detected by default) |
| `class` | string | - | Additional Tailwind classes |

## Variants

### Default

Standard link with foreground color transitioning to primary on hover:

```blade
<x-pegboard::link href="/profile" variant="default">
    View Profile
</x-pegboard::link>
```

**Visual characteristics:**
- Default: `text-foreground`
- Hover: `text-primary`
- Transition: Smooth color change
- Best for: General navigation links, content links

**Use cases:**
- Navigation menus
- In-content links
- Standard UI links
- Default link style

### Muted

Subtle link for secondary actions:

```blade
<x-pegboard::link href="/terms" variant="muted">
    Terms of Service
</x-pegboard::link>
```

**Visual characteristics:**
- Default: `text-muted-foreground`
- Hover: `text-foreground`
- Transition: Subtle emphasis on hover
- Best for: Footer links, secondary navigation, less prominent actions

**Use cases:**
- Footer links
- Metadata links
- Secondary navigation
- Subtle call-to-actions

### Primary

Emphasized link with brand color:

```blade
<x-pegboard::link href="/get-started" variant="primary">
    Get Started
</x-pegboard::link>
```

**Visual characteristics:**
- Default: `text-primary`
- Hover: `text-primary/80` (slightly transparent)
- Transition: Opacity change on hover
- Best for: Call-to-action links, important actions, emphasized navigation

**Use cases:**
- Call-to-action links
- Primary navigation items
- Important actions
- Emphasized content links

## Underline Behavior

### Always (Default)

Links are always underlined for clear identification:

```blade
<x-pegboard::link href="/docs" underline="always">
    Always underlined link
</x-pegboard::link>
```

**When to use:**
- Inline text links
- Content links
- Maximum accessibility
- Clear link identification (default for good reason)

### Hover

Underline appears only on hover:

```blade
<x-pegboard::link href="/about" underline="hover">
    Underline on hover
</x-pegboard::link>
```

**When to use:**
- Navigation menus
- Clean design aesthetics
- When links are clearly identifiable by context
- Buttons styled as links

### None

No underline at any time:

```blade
<x-pegboard::link href="/products" underline="none">
    No underline
</x-pegboard::link>
```

**When to use:**
- Icon-only links
- Card links
- Links with clear visual distinction
- Custom styled links

**Warning:** Use sparingly - underlines aid accessibility.

## Sizes

### Small (sm)

Compact text for small UI elements:

```blade
<x-pegboard::link href="/help" size="sm" variant="muted">
    Help Center
</x-pegboard::link>
```

**Font size:** `text-sm` (14px)

**Use cases:**
- Footer links
- Small navigation items
- Inline with small text
- Compact UI elements

### Base (Default)

Standard text size:

```blade
<x-pegboard::link href="/dashboard" size="base">
    Dashboard
</x-pegboard::link>
```

**Font size:** `text-base` (16px)

**Use cases:**
- General links
- Content links
- Navigation menus
- Default size

### Large (lg)

Prominent links for emphasis:

```blade
<x-pegboard::link href="/pricing" size="lg" variant="primary">
    View Pricing
</x-pegboard::link>
```

**Font size:** `text-lg` (18px)

**Use cases:**
- Call-to-action links
- Hero section links
- Emphasized navigation
- Large UI components

## External Links

### Auto-Detection

External links are automatically detected:

```blade
{{-- Detected as external (https://) --}}
<x-pegboard::link href="https://example.com">
    Example Site
</x-pegboard::link>

{{-- Detected as external (http://) --}}
<x-pegboard::link href="http://oldsite.com">
    Old Site
</x-pegboard::link>

{{-- NOT external (relative path) --}}
<x-pegboard::link href="/internal/page">
    Internal Page
</x-pegboard::link>
```

**Auto-detection triggers when URL starts with:**
- `http://`
- `https://`
- `//`

### External Link Behavior

External links automatically receive:

1. **`target="_blank"`** - Opens in new tab
2. **`rel="noopener noreferrer"`** - Security attributes
3. **External icon** - Small arrow indicator

```blade
{{-- Renders with all external link features --}}
<x-pegboard::link href="https://github.com">
    GitHub
</x-pegboard::link>

{{-- Output includes:
     - target="_blank"
     - rel="noopener noreferrer"
     - Small external link icon
--}}
```

### Force External Behavior

Override auto-detection manually:

```blade
{{-- Force external behavior on internal link --}}
<x-pegboard::link href="/docs" :external="true">
    Documentation (opens in new tab)
</x-pegboard::link>

{{-- Force internal behavior on external link --}}
<x-pegboard::link href="https://example.com" :external="false">
    Example (same tab, no icon)
</x-pegboard::link>
```

### External Icon

External links display a small icon automatically:

```blade
<x-pegboard::link href="https://github.com/pegboard">
    Visit our GitHub
    {{-- Icon automatically appears after text --}}
</x-pegboard::link>
```

**Icon details:**
- Icon: `arrow-top-right-on-square` (mini variant)
- Size: `h-3.5 w-3.5`
- Position: After link text
- Style: Inherits link color

## Examples

### Inline Text Links

```blade
<x-pegboard::text variant="default">
    Welcome to Pegboard UI! Check out our
    <x-pegboard::link href="https://github.com/pegboard" variant="primary">
        documentation on GitHub
    </x-pegboard::link>
    to get started, or visit the
    <x-pegboard::link href="/examples" variant="primary">
        examples page
    </x-pegboard::link>
    for more demos.
</x-pegboard::text>
```

### Navigation Menu

```blade
<nav class="flex gap-6">
    <x-pegboard::link href="/" variant="default" underline="hover">
        Home
    </x-pegboard::link>
    <x-pegboard::link href="/about" variant="default" underline="hover">
        About
    </x-pegboard::link>
    <x-pegboard::link href="/services" variant="default" underline="hover">
        Services
    </x-pegboard::link>
    <x-pegboard::link href="/contact" variant="primary" underline="hover">
        Contact Us
    </x-pegboard::link>
</nav>
```

### Footer Links

```blade
<footer class="border-t border-border py-8">
    <div class="flex flex-wrap gap-4 text-sm">
        <x-pegboard::link href="/about" variant="muted" size="sm">
            About
        </x-pegboard::link>
        <x-pegboard::link href="/privacy" variant="muted" size="sm">
            Privacy Policy
        </x-pegboard::link>
        <x-pegboard::link href="/terms" variant="muted" size="sm">
            Terms of Service
        </x-pegboard::link>
        <x-pegboard::link href="https://twitter.com/pegboard" variant="muted" size="sm">
            Twitter
        </x-pegboard::link>
        <x-pegboard::link href="https://github.com/pegboard" variant="muted" size="sm">
            GitHub
        </x-pegboard::link>
    </div>
</footer>
```

### Call-to-Action Links

```blade
<div class="text-center space-y-4">
    <x-pegboard::link
        href="/get-started"
        variant="primary"
        size="lg"
        underline="none"
        class="font-semibold"
    >
        Get Started with Pegboard
    </x-pegboard::link>

    <br />

    <x-pegboard::link href="https://docs.pegboard.dev" variant="primary">
        Read the Documentation
    </x-pegboard::link>
</div>
```

### Breadcrumbs

```blade
<nav class="flex items-center gap-2 text-sm">
    <x-pegboard::link href="/" variant="muted" size="sm" underline="hover">
        Home
    </x-pegboard::link>
    <span class="text-muted-foreground">/</span>
    <x-pegboard::link href="/products" variant="muted" size="sm" underline="hover">
        Products
    </x-pegboard::link>
    <span class="text-muted-foreground">/</span>
    <x-pegboard::text variant="default" class="text-sm">
        Product Details
    </x-pegboard::text>
</nav>
```

### Card Links

```blade
<x-pegboard::card class="hover:border-primary transition-colors">
    <x-pegboard::link
        href="/blog/post-1"
        variant="default"
        underline="none"
        class="block"
    >
        <x-pegboard::heading size="md" class="mb-2">
            Understanding Pegboard Components
        </x-pegboard::heading>
        <x-pegboard::text variant="subtle">
            Learn about the core principles behind Pegboard's component design.
        </x-pegboard::text>
    </x-pegboard::link>
</x-pegboard::card>
```

### External Resource Links

```blade
<div class="space-y-2">
    <div>
        <x-pegboard::text variant="strong" class="block">
            Documentation
        </x-pegboard::text>
        <x-pegboard::link href="https://docs.pegboard.dev" variant="primary">
            Read the full documentation
        </x-pegboard::link>
    </div>

    <div>
        <x-pegboard::text variant="strong" class="block">
            GitHub Repository
        </x-pegboard::text>
        <x-pegboard::link href="https://github.com/pegboard/pegboard-ui" variant="primary">
            View source code
        </x-pegboard::link>
    </div>

    <div>
        <x-pegboard::text variant="strong" class="block">
            Community
        </x-pegboard::text>
        <x-pegboard::link href="https://discord.gg/pegboard" variant="primary">
            Join our Discord
        </x-pegboard::link>
    </div>
</div>
```

### Sidebar Navigation

```blade
<aside class="space-y-1">
    <x-pegboard::link
        href="/dashboard"
        variant="default"
        underline="none"
        class="block px-4 py-2 rounded hover:bg-muted"
    >
        Dashboard
    </x-pegboard::link>

    <x-pegboard::link
        href="/projects"
        variant="default"
        underline="none"
        class="block px-4 py-2 rounded hover:bg-muted"
    >
        Projects
    </x-pegboard::link>

    <x-pegboard::link
        href="/settings"
        variant="muted"
        underline="none"
        class="block px-4 py-2 rounded hover:bg-muted"
    >
        Settings
    </x-pegboard::link>
</aside>
```

### Custom Styled Links

```blade
{{-- Bold uppercase link --}}
<x-pegboard::link
    href="/important"
    variant="primary"
    class="font-bold uppercase tracking-wide"
>
    Important Notice
</x-pegboard::link>

{{-- Link with border bottom --}}
<x-pegboard::link
    href="/featured"
    variant="primary"
    underline="none"
    class="border-b-2 border-b-primary pb-1"
>
    Featured Content
</x-pegboard::link>

{{-- Icon with link --}}
<x-pegboard::link href="/help" variant="default" class="flex items-center gap-2">
    <x-pegboard::icon name="question-mark-circle" variant="mini" class="h-4 w-4" />
    Help Center
</x-pegboard::link>
```

## Best Practices

### 1. Use Meaningful Link Text

```blade
{{-- ✅ Good - Descriptive text --}}
<x-pegboard::link href="/pricing">
    View our pricing plans
</x-pegboard::link>

{{-- ❌ Bad - Generic text --}}
<x-pegboard::link href="/pricing">
    Click here
</x-pegboard::link>
```

### 2. Match Variant to Purpose

```blade
{{-- ✅ Good - Variant matches purpose --}}
<x-pegboard::link href="/signup" variant="primary">
    Sign Up Now
</x-pegboard::link>

<x-pegboard::link href="/privacy" variant="muted">
    Privacy Policy
</x-pegboard::link>

{{-- ❌ Confusing - Primary for footer link --}}
<x-pegboard::link href="/privacy" variant="primary">
    Privacy Policy
</x-pegboard::link>
```

### 3. Underline Inline Text Links

```blade
{{-- ✅ Good - Underlined in text --}}
<x-pegboard::text>
    Read our
    <x-pegboard::link href="/guide" variant="primary">
        complete guide
    </x-pegboard::link>
    to learn more.
</x-pegboard::text>

{{-- ❌ Bad - No underline in text --}}
<x-pegboard::text>
    Read our
    <x-pegboard::link href="/guide" variant="primary" underline="none">
        complete guide
    </x-pegboard::link>
    to learn more.
</x-pegboard::text>
{{-- Hard to identify as link --}}
```

### 4. Don't Underline Navigation Links

```blade
{{-- ✅ Good - Clean navigation --}}
<nav class="flex gap-4">
    <x-pegboard::link href="/" underline="hover">Home</x-pegboard::link>
    <x-pegboard::link href="/about" underline="hover">About</x-pegboard::link>
</nav>

{{-- ❌ Cluttered - Too many underlines --}}
<nav class="flex gap-4">
    <x-pegboard::link href="/" underline="always">Home</x-pegboard::link>
    <x-pegboard::link href="/about" underline="always">About</x-pegboard::link>
</nav>
```

### 5. Use Consistent Sizes

```blade
{{-- ✅ Good - Consistent sizing --}}
<footer class="flex gap-4">
    <x-pegboard::link href="/about" size="sm">About</x-pegboard::link>
    <x-pegboard::link href="/contact" size="sm">Contact</x-pegboard::link>
    <x-pegboard::link href="/privacy" size="sm">Privacy</x-pegboard::link>
</footer>

{{-- ❌ Bad - Inconsistent sizes --}}
<footer class="flex gap-4">
    <x-pegboard::link href="/about" size="sm">About</x-pegboard::link>
    <x-pegboard::link href="/contact" size="lg">Contact</x-pegboard::link>
    <x-pegboard::link href="/privacy" size="base">Privacy</x-pegboard::link>
</footer>
```

### 6. External Links for Third-Party Sites

```blade
{{-- ✅ Good - External links open in new tab --}}
<x-pegboard::link href="https://github.com">
    GitHub
    {{-- Auto-adds target="_blank" and icon --}}
</x-pegboard::link>

{{-- ❌ Bad - External link opens in same tab --}}
<x-pegboard::link href="https://github.com" :external="false">
    GitHub
    {{-- User loses your site --}}
</x-pegboard::link>
```

## Accessibility

The Link component follows WCAG 2.1 guidelines and best practices:

### Keyboard Navigation

Links are fully keyboard accessible:

- **Tab:** Navigate to link
- **Shift + Tab:** Navigate backwards
- **Enter:** Activate link
- **Space:** Does not activate (standard link behavior)

### Focus States

Proper focus indication for keyboard users:

```blade
<x-pegboard::link href="/page">
    Focusable Link
</x-pegboard::link>
{{-- Shows outline on focus-visible --}}
```

**Focus styles:**
- `focus-visible:outline-2` - 2px outline
- `focus-visible:outline-offset-2` - 2px offset
- `focus-visible:outline-primary` - Primary color outline

### Color Contrast

All link variants meet WCAG AA standards:
- **Default:** `text-foreground` → `text-primary`
- **Muted:** `text-muted-foreground` → `text-foreground`
- **Primary:** `text-primary` → `text-primary/80`

All combinations maintain 4.5:1 minimum contrast ratio.

### External Link Security

External links include security attributes:

```blade
<x-pegboard::link href="https://example.com">
    External Site
</x-pegboard::link>
{{-- Renders with: target="_blank" rel="noopener noreferrer" --}}
```

**Security benefits:**
- `noopener`: Prevents `window.opener` access
- `noreferrer`: Prevents referrer information leakage

### External Link Icon

External link icon provides visual indication:

```blade
<x-pegboard::link href="https://docs.example.com">
    Documentation
    {{-- Icon indicates link opens in new tab --}}
</x-pegboard::link>
```

**Accessibility benefits:**
- Visual cue for new tab behavior
- Helps users understand link action
- Reduces confusion about navigation

### Meaningful Link Text

Screen readers read link text:

```blade
{{-- ✅ Good - Descriptive for screen readers --}}
<x-pegboard::link href="/products">
    View all products
</x-pegboard::link>
{{-- Screen reader: "Link: View all products" --}}

{{-- ❌ Bad - Not descriptive --}}
<x-pegboard::link href="/products">
    Click here
</x-pegboard::link>
{{-- Screen reader: "Link: Click here" (unclear) --}}
```

### Underline for Identification

Underlines help visually impaired users identify links:

```blade
{{-- ✅ Good - Always underlined in text --}}
<p>
    Visit our
    <x-pegboard::link href="/guide" underline="always">
        complete guide
    </x-pegboard::link>
    for details.
</p>

{{-- ⚠️ Use carefully - No underline requires strong context --}}
<nav class="bg-muted p-4">
    <x-pegboard::link href="/" underline="none">
        Home
    </x-pegboard::link>
    {{-- Clear navigation context --}}
</nav>
```

### Smooth Transitions

Color transitions use duration-fast for smooth changes:

```blade
<x-pegboard::link href="/page">
    Smooth hover transition
</x-pegboard::link>
{{-- transition-colors duration-fast --}}
```

---

## Additional Resources

- [WCAG Link Guidelines](https://www.w3.org/WAI/WCAG21/Understanding/link-purpose-in-context)
- [HTML Link Element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/a)
- [Link Security Best Practices](https://web.dev/external-anchors-use-rel-noopener/)
- [Accessible Link Text](https://www.w3.org/WAI/WCAG21/Understanding/link-purpose-link-only)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
