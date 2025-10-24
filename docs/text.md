# Text Component

A simple, semantic text component with variant-based styling for consistent typography throughout your application.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Props Reference](#props-reference)
- [Variants](#variants)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard Text component provides semantic text variants with consistent styling using theme tokens. It renders as a `<span>` element and works seamlessly with Tailwind utilities for customization.

**Key Features:**
- 3 semantic variants (default, strong, subtle)
- Uses semantic theme tokens
- No JavaScript required
- Dark mode support
- Fully customizable with Tailwind classes
- Proper color contrast ratios

## Basic Usage

### Simple Text

```blade
{{-- Default text --}}
<x-pegboard::text>This is default text</x-pegboard::text>
```

### Text with Variant

```blade
{{-- Strong emphasis --}}
<x-pegboard::text variant="strong">Important message</x-pegboard::text>

{{-- Subtle secondary text --}}
<x-pegboard::text variant="subtle">Additional information</x-pegboard::text>
```

### Text with Custom Classes

```blade
{{-- Add Tailwind classes --}}
<x-pegboard::text variant="default" class="text-lg italic">
    Large italic text
</x-pegboard::text>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Style variant: `default`, `strong`, `subtle` |
| `class` | string | - | Additional Tailwind classes |

## Variants

### Default

Standard text color using the foreground theme token:

```blade
<x-pegboard::text variant="default">
    This is default text with standard foreground color
</x-pegboard::text>
```

**Visual characteristics:**
- Color: `text-foreground`
- Weight: Normal
- Best for: Body text, paragraphs, general content

**When to use:**
- Main content text
- Descriptions
- Standard UI labels
- General information

### Strong

Emphasized text with medium font weight:

```blade
<x-pegboard::text variant="strong">
    This is strong text with font-medium weight
</x-pegboard::text>
```

**Visual characteristics:**
- Color: `text-foreground`
- Weight: `font-medium`
- Best for: Emphasis, important labels, highlighted information

**When to use:**
- Important information
- Labels that need emphasis
- Names or titles
- Call-out content

### Subtle

Muted text for secondary information:

```blade
<x-pegboard::text variant="subtle">
    This is subtle text using muted foreground color
</x-pegboard::text>
```

**Visual characteristics:**
- Color: `text-muted-foreground`
- Weight: Normal
- Best for: Secondary info, metadata, timestamps, captions

**When to use:**
- Timestamps
- Metadata
- Helper text
- Secondary descriptions
- Captions

## Examples

### User Profile Card

```blade
<div class="bg-card border border-border rounded-lg p-6">
    <x-pegboard::text variant="strong" class="block text-lg">
        Sarah Johnson
    </x-pegboard::text>
    <x-pegboard::text variant="default" class="block">
        Product Designer at Acme Corp
    </x-pegboard::text>
    <x-pegboard::text variant="subtle" class="block text-sm">
        Joined March 2024
    </x-pegboard::text>
</div>
```

### Status Message

```blade
<div class="bg-muted/30 rounded-lg p-4 space-y-2">
    <x-pegboard::text variant="strong">
        Upload Complete
    </x-pegboard::text>
    <x-pegboard::text variant="default">
        5 files were successfully uploaded to your account
    </x-pegboard::text>
    <x-pegboard::text variant="subtle" class="text-xs">
        This action cannot be undone
    </x-pegboard::text>
</div>
```

### Feature List

```blade
<ul class="space-y-3">
    <li class="flex items-start gap-2">
        <x-pegboard::icon name="check-circle" variant="solid" class="h-5 w-5 text-success mt-0.5" />
        <div>
            <x-pegboard::text variant="strong" class="block">
                Modern HTML/CSS First
            </x-pegboard::text>
            <x-pegboard::text variant="subtle" class="block text-sm">
                Minimal JavaScript, maximum performance
            </x-pegboard::text>
        </div>
    </li>
    <li class="flex items-start gap-2">
        <x-pegboard::icon name="check-circle" variant="solid" class="h-5 w-5 text-success mt-0.5" />
        <div>
            <x-pegboard::text variant="strong" class="block">
                Simple but Powerful API
            </x-pegboard::text>
            <x-pegboard::text variant="subtle" class="block text-sm">
                Sensible defaults with advanced options
            </x-pegboard::text>
        </div>
    </li>
</ul>
```

### Comment Thread

```blade
<div class="space-y-4">
    <div class="flex gap-3">
        <x-pegboard::avatar name="Mike Chen" size="sm" />
        <div>
            <div class="flex items-center gap-2">
                <x-pegboard::text variant="strong" class="text-sm">
                    Mike Chen
                </x-pegboard::text>
                <x-pegboard::text variant="subtle" class="text-xs">
                    2 hours ago
                </x-pegboard::text>
            </div>
            <x-pegboard::text variant="default" class="text-sm">
                This looks great! When can we ship it?
            </x-pegboard::text>
        </div>
    </div>
</div>
```

### Data Table

```blade
<x-pegboard::table>
    <x-pegboard::table.body>
        <x-pegboard::table.row>
            <x-pegboard::table.cell>
                <x-pegboard::text variant="strong">
                    Product Name
                </x-pegboard::text>
                <x-pegboard::text variant="subtle" class="block text-xs">
                    SKU: PRD-001
                </x-pegboard::text>
            </x-pegboard::table.cell>
            <x-pegboard::table.cell>
                <x-pegboard::text variant="default">
                    In Stock
                </x-pegboard::text>
            </x-pegboard::table.cell>
        </x-pegboard::table.row>
    </x-pegboard::table.body>
</x-pegboard::table>
```

### Form Field

```blade
<div class="space-y-1">
    <label>
        <x-pegboard::text variant="strong" class="text-sm">
            Email Address
        </x-pegboard::text>
    </label>
    <input type="email" class="..." />
    <x-pegboard::text variant="subtle" class="text-xs">
        We'll never share your email with anyone else
    </x-pegboard::text>
</div>
```

### Notification

```blade
<div class="bg-success/10 border border-success rounded-lg p-4">
    <div class="flex items-start gap-3">
        <x-pegboard::icon name="check-circle" variant="solid" class="h-5 w-5 text-success" />
        <div>
            <x-pegboard::text variant="strong" class="text-success-foreground">
                Success!
            </x-pegboard::text>
            <x-pegboard::text variant="default" class="block">
                Your changes have been saved successfully
            </x-pegboard::text>
            <x-pegboard::text variant="subtle" class="block text-xs mt-1">
                Updated 2 minutes ago
            </x-pegboard::text>
        </div>
    </div>
</div>
```

### Inline Text with Variants

```blade
<p>
    <x-pegboard::text variant="default">
        Welcome to Pegboard UI!
    </x-pegboard::text>
    <x-pegboard::text variant="strong">
        Check out our documentation
    </x-pegboard::text>
    <x-pegboard::text variant="subtle">
        (updated daily)
    </x-pegboard::text>
</p>
```

## Best Practices

### 1. Use Appropriate Variants

```blade
{{-- ✅ Good - Variant matches purpose --}}
<div>
    <x-pegboard::text variant="strong">John Doe</x-pegboard::text>
    <x-pegboard::text variant="default">Product Manager</x-pegboard::text>
    <x-pegboard::text variant="subtle">Joined 2023</x-pegboard::text>
</div>

{{-- ❌ Bad - Confusing variant usage --}}
<div>
    <x-pegboard::text variant="subtle">IMPORTANT: Read this!</x-pegboard::text>
    {{-- Subtle is wrong for important information --}}
</div>
```

### 2. Create Visual Hierarchy

```blade
{{-- ✅ Good - Clear hierarchy --}}
<div class="space-y-2">
    <x-pegboard::text variant="strong" class="text-lg">
        Main Title
    </x-pegboard::text>
    <x-pegboard::text variant="default">
        Primary description text
    </x-pegboard::text>
    <x-pegboard::text variant="subtle" class="text-sm">
        Secondary metadata
    </x-pegboard::text>
</div>

{{-- ❌ Bad - No hierarchy --}}
<div>
    <x-pegboard::text>Title</x-pegboard::text>
    <x-pegboard::text>Description</x-pegboard::text>
    <x-pegboard::text>Metadata</x-pegboard::text>
    {{-- All the same, no visual distinction --}}
</div>
```

### 3. Combine with Display Utilities

```blade
{{-- ✅ Good - Proper display properties --}}
<x-pegboard::text variant="strong" class="block">
    Name
</x-pegboard::text>
<x-pegboard::text variant="default" class="block">
    Description
</x-pegboard::text>

{{-- ✅ Good - Inline text --}}
<p>
    <x-pegboard::text variant="default">Total:</x-pegboard::text>
    <x-pegboard::text variant="strong">$99.99</x-pegboard::text>
</p>
```

### 4. Maintain Consistency

```blade
{{-- ✅ Good - Consistent variant usage --}}
@foreach($items as $item)
    <div>
        <x-pegboard::text variant="strong">{{ $item->name }}</x-pegboard::text>
        <x-pegboard::text variant="subtle">{{ $item->date }}</x-pegboard::text>
    </div>
@endforeach

{{-- ❌ Bad - Inconsistent variants --}}
@foreach($items as $item)
    <div>
        <x-pegboard::text :variant="$loop->even ? 'strong' : 'default'">
            {{ $item->name }}
        </x-pegboard::text>
        {{-- Creates visual inconsistency --}}
    </div>
@endforeach
```

### 5. Use for Text Content, Not Containers

```blade
{{-- ✅ Good - Text content --}}
<p class="mb-4">
    <x-pegboard::text variant="default">
        This is a paragraph of text content.
    </x-pegboard::text>
</p>

{{-- ❌ Avoid - As container --}}
<x-pegboard::text variant="default" class="p-4 bg-card border">
    {{-- Use proper semantic elements for containers --}}
</x-pegboard::text>
```

### 6. Leverage Semantic Tokens

```blade
{{-- ✅ Good - Theme tokens provide dark mode automatically --}}
<x-pegboard::text variant="default">
    Automatically adapts to dark mode
</x-pegboard::text>

{{-- ❌ Bad - Hardcoded colors break dark mode --}}
<span class="text-black">
    Doesn't adapt to dark mode
</span>
```

## Accessibility

The Text component follows WCAG 2.1 guidelines:

### Color Contrast

All text variants meet WCAG AA standards (4.5:1 minimum):
- **Default** (`text-foreground`): High contrast against background
- **Strong** (`text-foreground` + `font-medium`): High contrast with added weight
- **Subtle** (`text-muted-foreground`): Reduced but still accessible contrast for secondary content

### Dark Mode Support

All variants use semantic theme tokens that automatically adapt:

```blade
<x-pegboard::text variant="default">
    Adapts automatically to light/dark mode
</x-pegboard::text>
```

### Semantic HTML

Text component renders as `<span>` which is semantically correct for inline text:

```blade
{{-- Renders as: <span class="text-foreground">Text</span> --}}
<x-pegboard::text variant="default">Text</x-pegboard::text>
```

### Font Weight for Emphasis

The `strong` variant uses `font-medium` for visual emphasis without semantic meaning. For semantic emphasis, use HTML elements:

```blade
{{-- ✅ Visual emphasis only --}}
<x-pegboard::text variant="strong">Important</x-pegboard::text>

{{-- ✅ Semantic emphasis (screen readers) --}}
<strong>
    <x-pegboard::text variant="strong">Important</x-pegboard::text>
</strong>

{{-- ✅ Semantic strong importance --}}
<em>
    <x-pegboard::text variant="default">Emphasized text</x-pegboard::text>
</em>
```

### Screen Reader Friendly

Text content is naturally accessible to screen readers:
- No ARIA attributes needed
- Uses native HTML text rendering
- Clear, readable content structure

---

## Additional Resources

- [Tailwind CSS Typography](https://tailwindcss.com/docs/font-family)
- [WCAG Text Contrast Guidelines](https://www.w3.org/WAI/WCAG21/Understanding/contrast-minimum)
- [HTML Text Fundamentals](https://developer.mozilla.org/en-US/docs/Learn/HTML/Introduction_to_HTML/HTML_text_fundamentals)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
