# Heading Component

A semantic heading component that separates visual styling from HTML heading levels for accessible, SEO-friendly typography.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Props Reference](#props-reference)
- [Sizes](#sizes)
- [Semantic Levels](#semantic-levels)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard Heading component allows you to control visual appearance independently from semantic HTML heading levels (`<h1>` through `<h6>`). This separation ensures proper document structure while maintaining design flexibility.

**Key Features:**
- 4 size variants (sm, md, lg, xl)
- Semantic HTML levels (h1-h6) or generic div
- Independent size and level control
- Uses semantic theme tokens
- No JavaScript required
- Dark mode support
- SEO-friendly structure

## Basic Usage

### Simple Heading

```blade
{{-- Renders as <div> with default (md) styling --}}
<x-pegboard::heading>My Heading</x-pegboard::heading>
```

### Heading with Size

```blade
{{-- Extra large heading --}}
<x-pegboard::heading size="xl">
    Page Title
</x-pegboard::heading>

{{-- Small heading --}}
<x-pegboard::heading size="sm">
    Small Section
</x-pegboard::heading>
```

### Semantic HTML Heading

```blade
{{-- Renders as <h1> element --}}
<x-pegboard::heading :level="1" size="xl">
    Main Page Title
</x-pegboard::heading>

{{-- Renders as <h2> element --}}
<x-pegboard::heading :level="2" size="lg">
    Section Title
</x-pegboard::heading>
```

### Size Independent of Level

```blade
{{-- H3 element but visually extra large --}}
<x-pegboard::heading :level="3" size="xl">
    Visually Prominent Subsection
</x-pegboard::heading>

{{-- H2 element but visually small --}}
<x-pegboard::heading :level="2" size="sm">
    Semantic H2 with Subtle Styling
</x-pegboard::heading>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | `'md'` | Visual size: `sm`, `md`, `lg`, `xl` |
| `level` | int\|null | `null` | HTML heading level 1-6, renders `<div>` if null |
| `class` | string | - | Additional Tailwind classes |

## Sizes

### Small (sm)

Compact heading for minor sections:

```blade
<x-pegboard::heading size="sm">
    Small Heading
</x-pegboard::heading>
```

**Visual characteristics:**
- Font size: `text-base` (16px)
- Font weight: `font-semibold`
- Best for: Small sections, card titles, minor headings

**Use cases:**
- Card headers
- Sidebar sections
- Minor page divisions
- Compact UI headings

### Medium (md) - Default

Standard heading size:

```blade
<x-pegboard::heading size="md">
    Medium Heading
</x-pegboard::heading>
```

**Visual characteristics:**
- Font size: `text-lg` (18px)
- Font weight: `font-semibold`
- Best for: Subsections, content blocks, general headings

**Use cases:**
- Subsection titles
- Content block headers
- Default heading size
- Component titles

### Large (lg)

Prominent heading for sections:

```blade
<x-pegboard::heading size="lg">
    Large Heading
</x-pegboard::heading>
```

**Visual characteristics:**
- Font size: `text-xl` (20px)
- Font weight: `font-semibold`
- Letter spacing: `tracking-tight`
- Best for: Section titles, major divisions

**Use cases:**
- Main sections
- Page sections
- Important divisions
- Feature headings

### Extra Large (xl)

Maximum emphasis for page titles:

```blade
<x-pegboard::heading size="xl">
    Extra Large Heading
</x-pegboard::heading>
```

**Visual characteristics:**
- Font size: `text-2xl` (24px)
- Font weight: `font-semibold`
- Letter spacing: `tracking-tight`
- Best for: Page titles, hero headings

**Use cases:**
- Page titles
- Hero sections
- Major announcements
- Landing page headings

## Semantic Levels

### Level 1 (H1)

Main page title - use once per page:

```blade
<x-pegboard::heading :level="1" size="xl">
    Page Title
</x-pegboard::heading>
```

**SEO importance:** Critical for page structure
**Accessibility:** Announces page topic to screen readers
**Best practice:** One H1 per page

### Level 2 (H2)

Major sections:

```blade
<x-pegboard::heading :level="2" size="lg">
    Section Title
</x-pegboard::heading>
```

**SEO importance:** High - defines major content sections
**Accessibility:** Creates document outline
**Best practice:** Use for top-level sections

### Level 3 (H3)

Subsections:

```blade
<x-pegboard::heading :level="3" size="md">
    Subsection Title
</x-pegboard::heading>
```

**SEO importance:** Medium - organizes sub-content
**Accessibility:** Helps navigation structure
**Best practice:** Nest within H2 sections

### Level 4-6 (H4-H6)

Minor headings:

```blade
<x-pegboard::heading :level="4" size="sm">
    Minor Section
</x-pegboard::heading>
```

**SEO importance:** Lower but still valuable
**Accessibility:** Completes document hierarchy
**Best practice:** Use for detailed organization

### No Level (Div)

Visual heading without semantic meaning:

```blade
{{-- Renders as <div> --}}
<x-pegboard::heading size="lg">
    Visual Heading Only
</x-pegboard::heading>
```

**When to use:**
- Decorative headings
- Non-content headings
- Design elements
- When semantic structure doesn't fit

## Examples

### Article Layout

```blade
<article>
    {{-- Main article title --}}
    <x-pegboard::heading :level="1" size="xl">
        Understanding Pegboard UI Components
    </x-pegboard::heading>

    <x-pegboard::text variant="subtle">
        Published on March 15, 2024 by Stratos Digital
    </x-pegboard::text>

    {{-- Major section --}}
    <x-pegboard::heading :level="2" size="lg" class="mt-8">
        Introduction to Modern Component Design
    </x-pegboard::heading>

    <x-pegboard::text variant="default">
        Building modern web applications requires components that are both accessible and performant.
    </x-pegboard::text>

    {{-- Subsection --}}
    <x-pegboard::heading :level="3" size="md" class="mt-6">
        Key Design Principles
    </x-pegboard::heading>

    <x-pegboard::text variant="default">
        The three core principles that guide Pegboard's development...
    </x-pegboard::text>

    {{-- Minor section --}}
    <x-pegboard::heading :level="4" size="sm" class="mt-4">
        HTML/CSS First
    </x-pegboard::heading>

    <x-pegboard::text variant="subtle">
        Using native elements reduces JavaScript dependencies.
    </x-pegboard::text>
</article>
```

### Card with Heading

```blade
<x-pegboard::card variant="outline" padding="lg">
    <x-pegboard::heading size="md" class="mb-4">
        Card Title
    </x-pegboard::heading>
    <x-pegboard::text variant="default">
        Card content goes here.
    </x-pegboard::text>
</x-pegboard::card>
```

### Dashboard Section

```blade
<section>
    <x-pegboard::heading :level="2" size="lg" class="mb-6">
        Recent Activity
    </x-pegboard::heading>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-pegboard::card>
            <x-pegboard::heading size="sm" class="mb-2">
                Today
            </x-pegboard::heading>
            <x-pegboard::text variant="default">
                12 new orders
            </x-pegboard::text>
        </x-pegboard::card>

        <x-pegboard::card>
            <x-pegboard::heading size="sm" class="mb-2">
                This Week
            </x-pegboard::heading>
            <x-pegboard::text variant="default">
                87 new orders
            </x-pegboard::text>
        </x-pegboard::card>

        <x-pegboard::card>
            <x-pegboard::heading size="sm" class="mb-2">
                This Month
            </x-pegboard::heading>
            <x-pegboard::text variant="default">
                342 new orders
            </x-pegboard::text>
        </x-pegboard::card>
    </div>
</section>
```

### Feature Section

```blade
<section class="py-12">
    <x-pegboard::heading :level="2" size="xl" class="text-center mb-4">
        Powerful Features
    </x-pegboard::heading>
    <x-pegboard::text variant="subtle" class="text-center mb-12">
        Everything you need to build modern applications
    </x-pegboard::text>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($features as $feature)
            <div>
                <x-pegboard::heading :level="3" size="md" class="mb-3">
                    {{ $feature->title }}
                </x-pegboard::heading>
                <x-pegboard::text variant="default">
                    {{ $feature->description }}
                </x-pegboard::text>
            </div>
        @endforeach
    </div>
</section>
```

### Settings Page

```blade
<div class="max-w-4xl mx-auto">
    <x-pegboard::heading :level="1" size="xl" class="mb-2">
        Settings
    </x-pegboard::heading>
    <x-pegboard::text variant="subtle" class="mb-8">
        Manage your account preferences
    </x-pegboard::text>

    {{-- Profile section --}}
    <x-pegboard::heading :level="2" size="lg" class="mb-4">
        Profile Information
    </x-pegboard::heading>
    {{-- Profile form --}}

    {{-- Security section --}}
    <x-pegboard::heading :level="2" size="lg" class="mb-4 mt-12">
        Security Settings
    </x-pegboard::heading>
    {{-- Security form --}}
</div>
```

### Modal Header

```blade
<x-pegboard::modal>
    <div class="border-b border-border pb-4 mb-4">
        <x-pegboard::heading :level="2" size="lg">
            Confirm Action
        </x-pegboard::heading>
        <x-pegboard::text variant="subtle" class="mt-1">
            This action cannot be undone
        </x-pegboard::text>
    </div>

    {{-- Modal content --}}
</x-pegboard::modal>
```

### Styled Headings

```blade
{{-- Primary colored heading --}}
<x-pegboard::heading :level="2" size="xl" class="text-primary">
    Brand Colored Heading
</x-pegboard::heading>

{{-- Uppercase heading --}}
<x-pegboard::heading :level="3" size="lg" class="uppercase tracking-wider">
    Uppercase Section
</x-pegboard::heading>

{{-- Heading with border accent --}}
<x-pegboard::heading :level="2" size="lg" class="border-l-4 border-l-primary pl-4">
    Accented Heading
</x-pegboard::heading>

{{-- Gradient heading --}}
<x-pegboard::heading :level="1" size="xl" class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
    Gradient Heading
</x-pegboard::heading>
```

## Best Practices

### 1. Maintain Proper Heading Hierarchy

```blade
{{-- ✅ Good - Proper hierarchy --}}
<x-pegboard::heading :level="1" size="xl">Page Title</x-pegboard::heading>
<x-pegboard::heading :level="2" size="lg">Section</x-pegboard::heading>
<x-pegboard::heading :level="3" size="md">Subsection</x-pegboard::heading>

{{-- ❌ Bad - Skipped levels --}}
<x-pegboard::heading :level="1" size="xl">Page Title</x-pegboard::heading>
<x-pegboard::heading :level="4" size="sm">Subsection</x-pegboard::heading>
{{-- Skipped H2 and H3 --}}
```

### 2. One H1 Per Page

```blade
{{-- ✅ Good - Single H1 --}}
<x-pegboard::heading :level="1" size="xl">
    Main Page Title
</x-pegboard::heading>
{{-- Use H2-H6 for other headings --}}

{{-- ❌ Bad - Multiple H1s --}}
<x-pegboard::heading :level="1">First Title</x-pegboard::heading>
<x-pegboard::heading :level="1">Second Title</x-pegboard::heading>
```

### 3. Separate Visual Style from Semantics

```blade
{{-- ✅ Good - H3 with large visual size --}}
<x-pegboard::heading :level="3" size="xl">
    Visually Large but Semantically H3
</x-pegboard::heading>

{{-- ✅ Good - H2 with small visual size --}}
<x-pegboard::heading :level="2" size="sm">
    Semantically Important but Visually Subtle
</x-pegboard::heading>
```

### 4. Match Size to Context

```blade
{{-- ✅ Good - Size matches importance --}}
<x-pegboard::heading :level="1" size="xl">Page Title</x-pegboard::heading>
<x-pegboard::heading :level="2" size="lg">Section</x-pegboard::heading>
<x-pegboard::heading :level="3" size="md">Subsection</x-pegboard::heading>

{{-- ❌ Confusing - H1 smaller than H3 --}}
<x-pegboard::heading :level="1" size="sm">Page Title</x-pegboard::heading>
<x-pegboard::heading :level="3" size="xl">Subsection</x-pegboard::heading>
```

### 5. Use Consistent Spacing

```blade
{{-- ✅ Good - Consistent spacing --}}
<x-pegboard::heading :level="2" size="lg" class="mb-6">
    Section Title
</x-pegboard::heading>

<x-pegboard::heading :level="3" size="md" class="mb-4">
    Subsection Title
</x-pegboard::heading>

{{-- ❌ Inconsistent - Random spacing --}}
<x-pegboard::heading :level="2" class="mb-2">Title</x-pegboard::heading>
<x-pegboard::heading :level="2" class="mb-12">Title</x-pegboard::heading>
```

### 6. Descriptive Heading Text

```blade
{{-- ✅ Good - Descriptive --}}
<x-pegboard::heading :level="2" size="lg">
    User Profile Settings
</x-pegboard::heading>

{{-- ❌ Bad - Vague --}}
<x-pegboard::heading :level="2" size="lg">
    Settings
</x-pegboard::heading>
```

## Accessibility

The Heading component follows WCAG 2.1 guidelines and HTML5 best practices:

### Semantic HTML Structure

Proper heading levels create document outline for screen readers:

```blade
{{-- ✅ Creates accessible document structure --}}
<x-pegboard::heading :level="1">Main Title</x-pegboard::heading>
  <x-pegboard::heading :level="2">Section 1</x-pegboard::heading>
    <x-pegboard::heading :level="3">Subsection 1.1</x-pegboard::heading>
    <x-pegboard::heading :level="3">Subsection 1.2</x-pegboard::heading>
  <x-pegboard::heading :level="2">Section 2</x-pegboard::heading>
```

**Screen reader benefits:**
- Users can navigate by headings
- Document structure is clear
- Content hierarchy is announced
- Skip to relevant sections

### SEO Benefits

Proper heading structure improves search engine optimization:

```blade
{{-- ✅ Good for SEO --}}
<x-pegboard::heading :level="1" size="xl">
    Complete Guide to Pegboard UI Components
</x-pegboard::heading>

<x-pegboard::heading :level="2" size="lg">
    Getting Started with Pegboard
</x-pegboard::heading>

<x-pegboard::heading :level="3" size="md">
    Installation Instructions
</x-pegboard::heading>
```

**SEO advantages:**
- Search engines understand content structure
- Keywords in headings boost relevance
- Better content indexing
- Improved page rankings

### Color Contrast

All headings use `text-foreground` theme token which ensures:
- WCAG AA compliance (4.5:1 minimum)
- Dark mode support
- Automatic color adjustment
- Consistent contrast ratios

### Keyboard Navigation

Screen reader users navigate headings via keyboard:
- **H key:** Jump to next heading
- **SHIFT + H:** Jump to previous heading
- **1-6 keys:** Jump to specific heading level

Proper semantic levels enable this navigation.

### ARIA Not Required

Semantic HTML headings don't need ARIA:

```blade
{{-- ✅ Good - Semantic HTML is sufficient --}}
<x-pegboard::heading :level="2">Section Title</x-pegboard::heading>

{{-- ❌ Avoid - Redundant ARIA --}}
<x-pegboard::heading :level="2" role="heading" aria-level="2">
    Section Title
</x-pegboard::heading>
{{-- Not needed - semantic HTML provides this --}}
```

---

## Additional Resources

- [HTML Heading Elements](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/Heading_Elements)
- [WCAG Headings Guidelines](https://www.w3.org/WAI/tutorials/page-structure/headings/)
- [SEO Best Practices for Headings](https://moz.com/learn/seo/on-page-factors)
- [Accessible Heading Structure](https://webaim.org/techniques/semanticstructure/)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
