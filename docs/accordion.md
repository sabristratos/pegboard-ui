# Accordion Component

A lightweight, accessible accordion component built entirely with native HTML `<details>` and `<summary>` elements. Zero JavaScript required, pure CSS animations, with support for single mode (mutual exclusivity) and multiple mode.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Structure](#component-structure)
- [Props Reference](#props-reference)
- [Modes](#modes)
  - [Multiple Mode (Default)](#multiple-mode-default)
  - [Single Mode (Exclusive)](#single-mode-exclusive)
- [Syntax Options](#syntax-options)
  - [Shorthand Syntax](#shorthand-syntax)
  - [Verbose Syntax](#verbose-syntax)
- [Sub-Components](#sub-components)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard accordion component provides a fully accessible, keyboard-navigable way to organize collapsible content sections. Built with native HTML and Tailwind CSS v4, it features smooth CSS animations and works without any JavaScript.

**Key Features:**
- Zero JavaScript required (uses native `<details>` element)
- Smooth CSS animations with grid-template-rows transitions
- Single mode: Mutual exclusivity via native `name` attribute
- Multiple mode: Allow multiple sections to be open simultaneously
- Two syntax options: Shorthand (pre-styled) and verbose (custom styling)
- Pure Tailwind CSS styling (no custom CSS)
- Full keyboard navigation built-in
- ARIA-compliant for screen readers
- Works with or without Alpine.js/Livewire

## Basic Usage

The simplest accordion implementation with pre-styled items:

```blade
<x-pegboard::accordion>
    <x-pegboard::accordion.item heading="What is Pegboard?">
        Pegboard is a comprehensive UI component library built with Alpine.js,
        Tailwind CSS v4, and Laravel Blade components.
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="Is JavaScript required?" open>
        No! The accordion component uses native HTML details elements and CSS
        animations. No JavaScript needed.
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="How do I customize styling?">
        Use the verbose syntax to have full control over styling while
        maintaining functionality.
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

**How it works:**
- `<x-pegboard::accordion>` provides a simple spacing wrapper
- Each `<x-pegboard::accordion.item>` uses a native `<details>` element
- The `heading` prop creates a pre-styled `<summary>` element
- Clicking the heading toggles the content open/closed
- CSS animations handle smooth height transitions

## Component Structure

The accordion uses a hierarchical structure with native HTML elements:

```
<x-pegboard::accordion>                           <!-- Spacing wrapper -->
    <x-pegboard::accordion.item heading="...">    <!-- Pre-styled details element -->
        Content...
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

**Verbose syntax structure:**

```
<x-pegboard::accordion>                           <!-- Spacing wrapper -->
    <x-pegboard::accordion.item>                  <!-- Unstyled details element -->
        <x-pegboard::accordion.heading>           <!-- Custom summary -->
        <x-pegboard::accordion.content>           <!-- Custom content wrapper -->
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

## Props Reference

### Accordion (Root Component)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | string | `'space-y-2'` | Custom wrapper classes |

The accordion wrapper provides consistent spacing between items. It's purely a visual wrapper with no functionality.

### Accordion.Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `heading` | string | `null` | Pre-styled heading text (shorthand syntax) |
| `open` | boolean | `false` | Whether the item starts open |
| `name` | string | `null` | Group name for single mode (mutual exclusivity) |

**Shorthand vs Verbose:**
- When `heading` prop is provided: Renders pre-styled accordion with heading/content
- When `heading` is omitted: Renders unstyled `<details>` for custom markup (verbose syntax)

### Accordion.Heading

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | string | Base styles | Custom summary styles |

Used only in verbose syntax. Renders a `<summary>` element with a chevron icon.

### Accordion.Content

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `class` | string | `''` | Custom content wrapper styles |

Used only in verbose syntax. Provides a wrapper for the collapsible content.

## Modes

### Multiple Mode (Default)

Allows multiple accordion items to be open at the same time. This is the default behavior when no `name` attribute is specified.

```blade
<x-pegboard::accordion>
    <x-pegboard::accordion.item heading="First Section">
        Content 1
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="Second Section">
        Content 2
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="Third Section">
        Content 3
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

**Behavior:**
- Users can open multiple sections simultaneously
- Clicking one section doesn't affect others
- Good for FAQs where users want to compare multiple answers

### Single Mode (Exclusive)

Only allows one accordion item to be open at a time. Achieved by adding the same `name` attribute to all items in the group.

```blade
<x-pegboard::accordion>
    <x-pegboard::accordion.item name="faq-group" heading="What is Pegboard?">
        Pegboard is a comprehensive UI component library...
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item name="faq-group" heading="Is JavaScript required?">
        No! The accordion uses native HTML elements...
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item name="faq-group" heading="How do I customize?">
        Use the verbose syntax for full control...
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

**Behavior:**
- Only one section can be open at a time
- Opening a section automatically closes the previously open section
- Uses the native HTML `name` attribute on `<details>` elements
- Good for wizard-like flows or mutually exclusive content

**How it works:**
When multiple `<details>` elements share the same `name` attribute, the browser automatically implements mutual exclusivity. This is a native HTML feature - no JavaScript required!

## Syntax Options

### Shorthand Syntax

Pre-styled accordion with heading and content automatically configured. Perfect for quick implementation with consistent styling.

```blade
<x-pegboard::accordion>
    <x-pegboard::accordion.item heading="Question 1" open>
        Answer to the first question...
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="Question 2">
        Answer to the second question...
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

**Features:**
- Rounded border card styling
- Background color and border from theme tokens
- Hover effects on heading
- Chevron icon that rotates when open
- Smooth height and opacity animations
- Content padding included

### Verbose Syntax

Full control over styling while maintaining functionality. Compose your own design using sub-components.

```blade
<x-pegboard::accordion>
    <x-pegboard::accordion.item class="border-l-4 border-primary bg-primary/5">
        <x-pegboard::accordion.heading class="text-primary font-bold p-6">
            Custom Styled Question
        </x-pegboard::accordion.heading>
        <x-pegboard::accordion.content class="text-sm italic px-6 pb-6">
            Answer with custom typography and spacing...
        </x-pegboard::accordion.content>
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item class="border-l-4 border-success bg-success/5">
        <x-pegboard::accordion.heading class="text-success font-bold p-6">
            Another Custom Question
        </x-pegboard::accordion.heading>
        <x-pegboard::accordion.content class="text-sm italic px-6 pb-6">
            Different styling for each item...
        </x-pegboard::accordion.content>
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

**When to use:**
- Need complete control over styling
- Building a design that differs from the default
- Want to add custom icons or elements to headings
- Creating themed accordion items with different colors

**Note:** Animations are built into the `<details>` element via `[&::details-content]` pseudo-element selectors, so they work with both syntaxes.

## Sub-Components

### Accordion

The root wrapper component that provides consistent spacing between items.

```blade
<x-pegboard::accordion class="space-y-4">
    <!-- Accordion items -->
</x-pegboard::accordion>
```

**Responsibilities:**
- Provides vertical spacing between items (default: `space-y-2`)
- Groups related accordion items visually
- No functionality - purely visual wrapper

### Accordion.Item

Individual accordion item using native `<details>` element.

```blade
{{-- Shorthand syntax --}}
<x-pegboard::accordion.item heading="Title" name="group-1" open>
    Content
</x-pegboard::accordion.item>

{{-- Verbose syntax --}}
<x-pegboard::accordion.item name="group-1">
    <x-pegboard::accordion.heading>Custom Title</x-pegboard::accordion.heading>
    <x-pegboard::accordion.content>Custom Content</x-pegboard::accordion.content>
</x-pegboard::accordion.item>
```

**Renders:**
- Native `<details>` element with CSS animations
- Pre-styled with card background (shorthand) or basic styling (verbose)
- Grid-template-rows transition (0fr → 1fr) for smooth height animation
- Opacity transition for visual polish

### Accordion.Heading

Summary element that triggers the accordion open/close.

```blade
<x-pegboard::accordion.heading class="font-bold text-primary">
    Custom Heading Content
</x-pegboard::accordion.heading>
```

**Renders:**
- `<summary>` element with cursor pointer
- Flexbox layout with content on left, chevron icon on right
- Chevron rotates 180deg when open via `group-open:rotate-180`
- Removes default list marker styling

### Accordion.Content

Content wrapper that appears when the accordion is open.

```blade
<x-pegboard::accordion.content class="text-sm text-muted-foreground">
    <p>Custom content with padding and styling...</p>
</x-pegboard::accordion.content>
```

**Renders:**
- `<div>` with `data-slot="accordion-content"` attribute
- Inner wrapper with padding (default: `px-4 pb-4`)
- Animates via parent `<details>` element's `[&::details-content]` selectors

## Examples

### Basic FAQ Accordion

```blade
<x-pegboard::accordion>
    <x-pegboard::accordion.item heading="What payment methods do you accept?">
        We accept all major credit cards, PayPal, and bank transfers.
        Enterprise customers can also arrange invoice billing.
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="Do you offer refunds?">
        Yes, we offer a 30-day money-back guarantee for all plans.
        No questions asked.
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="Can I upgrade my plan later?">
        Absolutely! You can upgrade or downgrade your plan at any time
        from your account settings.
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="Is there a free trial?">
        Yes, all plans come with a 14-day free trial. No credit card required.
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

### Single Mode Accordion (Mutual Exclusivity)

```blade
<x-pegboard::accordion>
    <x-pegboard::accordion.item name="pricing-faq" heading="Monthly Pricing" open>
        Our monthly plans start at $29/month for individuals and
        $99/month for teams.
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item name="pricing-faq" heading="Annual Pricing">
        Annual plans offer 20% savings: $279/year for individuals and
        $949/year for teams.
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item name="pricing-faq" heading="Enterprise Pricing">
        Contact our sales team for custom enterprise pricing based on
        your needs.
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

### Custom Styled Accordion (Verbose Syntax)

```blade
<x-pegboard::accordion class="space-y-3">
    <x-pegboard::accordion.item class="bg-gradient-to-r from-primary/10 to-transparent border-l-4 border-primary">
        <x-pegboard::accordion.heading class="p-5 font-semibold text-lg text-primary">
            <x-pegboard::icon name="rocket-launch" class="inline h-5 w-5 mr-2" />
            Getting Started
        </x-pegboard::accordion.heading>
        <x-pegboard::accordion.content class="px-5 pb-5">
            <ol class="list-decimal list-inside space-y-2 text-muted-foreground">
                <li>Create an account</li>
                <li>Set up your profile</li>
                <li>Invite team members</li>
                <li>Start your first project</li>
            </ol>
        </x-pegboard::accordion.content>
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item class="bg-gradient-to-r from-success/10 to-transparent border-l-4 border-success">
        <x-pegboard::accordion.heading class="p-5 font-semibold text-lg text-success">
            <x-pegboard::icon name="check-circle" class="inline h-5 w-5 mr-2" />
            Best Practices
        </x-pegboard::accordion.heading>
        <x-pegboard::accordion.content class="px-5 pb-5">
            <ul class="list-disc list-inside space-y-2 text-muted-foreground">
                <li>Use descriptive project names</li>
                <li>Organize with tags and labels</li>
                <li>Set realistic deadlines</li>
                <li>Communicate with your team</li>
            </ul>
        </x-pegboard::accordion.content>
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item class="bg-gradient-to-r from-warning/10 to-transparent border-l-4 border-warning">
        <x-pegboard::accordion.heading class="p-5 font-semibold text-lg text-warning">
            <x-pegboard::icon name="light-bulb" class="inline h-5 w-5 mr-2" />
            Pro Tips
        </x-pegboard::accordion.heading>
        <x-pegboard::accordion.content class="px-5 pb-5">
            <ul class="list-disc list-inside space-y-2 text-muted-foreground">
                <li>Use keyboard shortcuts for faster navigation</li>
                <li>Enable notifications for important updates</li>
                <li>Customize your dashboard layout</li>
                <li>Integrate with your favorite tools</li>
            </ul>
        </x-pegboard::accordion.content>
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

### Accordion with Rich Content

```blade
<x-pegboard::accordion>
    <x-pegboard::accordion.item heading="Product Features">
        <div class="space-y-4">
            <h4 class="font-semibold">Core Features:</h4>
            <ul class="list-disc list-inside space-y-1 text-muted-foreground">
                <li>Real-time collaboration</li>
                <li>Advanced analytics</li>
                <li>Custom workflows</li>
            </ul>

            <x-pegboard::badge variant="primary">New</x-pegboard::badge>
            <p class="text-sm text-muted-foreground">
                AI-powered insights coming soon!
            </p>
        </div>
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="Technical Specifications">
        <x-pegboard::card class="bg-muted/50">
            <dl class="divide-y divide-border">
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">API Version:</dt>
                    <dd class="text-muted-foreground">v2.0</dd>
                </div>
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">Rate Limit:</dt>
                    <dd class="text-muted-foreground">1000 req/min</dd>
                </div>
                <div class="py-2 flex justify-between">
                    <dt class="font-medium">Uptime:</dt>
                    <dd class="text-success">99.9%</dd>
                </div>
            </dl>
        </x-pegboard::card>
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

### Nested Accordions

```blade
<x-pegboard::accordion>
    <x-pegboard::accordion.item heading="Product Categories">
        <x-pegboard::accordion class="space-y-2">
            <x-pegboard::accordion.item name="product-subcategories" heading="Electronics">
                Laptops, phones, tablets, and accessories.
            </x-pegboard::accordion.item>
            <x-pegboard::accordion.item name="product-subcategories" heading="Clothing">
                Men's, women's, and children's apparel.
            </x-pegboard::accordion.item>
            <x-pegboard::accordion.item name="product-subcategories" heading="Home & Garden">
                Furniture, décor, and outdoor equipment.
            </x-pegboard::accordion.item>
        </x-pegboard::accordion>
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="Shipping Options">
        Standard, express, and overnight shipping available.
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

### Conditional Accordion with Livewire

```blade
<x-pegboard::accordion>
    @foreach($faqs as $faq)
        <x-pegboard::accordion.item
            :heading="$faq->question"
            :open="$loop->first"
        >
            {{ $faq->answer }}
        </x-pegboard::accordion.item>
    @endforeach

    @auth
        <x-pegboard::accordion.item heading="Account Settings">
            <p>Logged in as: {{ auth()->user()->name }}</p>
            <x-pegboard::button wire:click="logout" variant="outline" size="sm">
                Logout
            </x-pegboard::button>
        </x-pegboard::accordion.item>
    @endauth
</x-pegboard::accordion>
```

## Best Practices

### 1. Choose the Right Mode

- **Multiple Mode**: Use for FAQs, documentation, or when users need to compare content across sections
- **Single Mode**: Use for wizards, settings panels, or mutually exclusive content

### 2. Provide Clear Headings

Headings should be concise and descriptive:

```blade
{{-- ✅ Good - Clear and specific --}}
<x-pegboard::accordion.item heading="How do I reset my password?">

{{-- ❌ Bad - Too vague --}}
<x-pegboard::accordion.item heading="Password">
```

### 3. Keep Content Focused

Each accordion item should contain related content. Don't overload a single item:

```blade
{{-- ✅ Good - Focused content --}}
<x-pegboard::accordion.item heading="Refund Policy">
    We offer 30-day refunds on all purchases...
</x-pegboard::accordion.item>

{{-- ❌ Bad - Too much unrelated content --}}
<x-pegboard::accordion.item heading="Policies">
    Refunds, shipping, privacy, terms...
</x-pegboard::accordion.item>
```

### 4. Use the `open` Prop Strategically

Open the most important or frequently accessed item by default:

```blade
<x-pegboard::accordion>
    {{-- Most common question starts open --}}
    <x-pegboard::accordion.item heading="What's included?" open>
        All plans include...
    </x-pegboard::accordion.item>

    <x-pegboard::accordion.item heading="How do I upgrade?">
        ...
    </x-pegboard::accordion.item>
</x-pegboard::accordion>
```

### 5. Maintain Consistent Spacing

Use the wrapper's spacing consistently across accordions:

```blade
{{-- ✅ Good - Consistent spacing --}}
<x-pegboard::accordion class="space-y-2">

{{-- Custom spacing if needed --}}
<x-pegboard::accordion class="space-y-4">
```

### 6. Add Icons for Visual Interest (Verbose Syntax)

```blade
<x-pegboard::accordion.heading class="font-medium">
    <x-pegboard::icon name="shield-check" class="inline h-5 w-5 mr-2 text-primary" />
    Security Features
</x-pegboard::accordion.heading>
```

### 7. Avoid Deeply Nested Accordions

Limit nesting to 1-2 levels for better UX:

```blade
{{-- ✅ Good - Single level nesting --}}
<x-pegboard::accordion>
    <x-pegboard::accordion.item heading="Parent">
        <x-pegboard::accordion>
            <x-pegboard::accordion.item heading="Child">
        </x-pegboard::accordion>
    </x-pegboard::accordion.item>
</x-pegboard::accordion>

{{-- ❌ Avoid - Multiple levels of nesting --}}
{{-- Too complex for users to navigate --}}
```

### 8. Use Verbose Syntax for Unique Designs

When your design differs significantly from the default, use verbose syntax:

```blade
<x-pegboard::accordion.item class="border-2 border-primary rounded-xl">
    <x-pegboard::accordion.heading class="bg-primary text-primary-foreground p-4">
        Premium Feature
    </x-pegboard::accordion.heading>
    <x-pegboard::accordion.content class="bg-primary/5 p-4">
        Exclusive content for premium users...
    </x-pegboard::accordion.content>
</x-pegboard::accordion.item>
```

## Accessibility

The accordion component follows WCAG 2.1 guidelines and uses semantic HTML:

### Semantic HTML

Built with native `<details>` and `<summary>` elements:

```html
<details class="...">
    <summary class="...">
        Question
    </summary>
    <div data-slot="accordion-content">
        Answer
    </div>
</details>
```

**Benefits:**
- Screen readers automatically announce expandable/collapsible regions
- Browsers provide built-in keyboard navigation
- No ARIA attributes needed (native HTML semantics)
- Works without JavaScript

### Keyboard Navigation

Full keyboard support is built-in via native `<details>` element:

| Key | Action |
|-----|--------|
| `Space` | Toggle accordion open/closed |
| `Enter` | Toggle accordion open/closed |
| `Tab` | Navigate to next accordion heading |
| `Shift + Tab` | Navigate to previous accordion heading |

**Note:** All keyboard interactions are handled by the browser - no custom JavaScript needed.

### Screen Readers

Native `<details>` elements provide excellent screen reader support:

- Headings announce as "button, collapsed" or "button, expanded"
- Opening/closing state changes are automatically announced
- Content is properly associated with its heading
- Nested accordions maintain proper hierarchy

### Focus Management

- Accordion headings receive browser-default focus styling
- Custom focus-visible styles applied via Tailwind: `focus-visible:outline-2`
- Focus indicator has sufficient contrast (3:1 ratio)
- Tabbing order follows DOM order (top to bottom)

### Best Practices for Accessibility

**1. Use descriptive headings:**

```blade
{{-- ✅ Good - Self-explanatory heading --}}
<x-pegboard::accordion.item heading="How do I cancel my subscription?">

{{-- ❌ Bad - Requires context to understand --}}
<x-pegboard::accordion.item heading="Cancellation">
```

**2. Provide heading hierarchy:**

When accordions are part of a larger page structure, ensure proper heading levels:

```blade
<section>
    <h2>Frequently Asked Questions</h2>

    <x-pegboard::accordion>
        {{-- These headings are inside summary, not h3/h4 tags --}}
        <x-pegboard::accordion.item heading="Question 1">
            ...
        </x-pegboard::accordion.item>
    </x-pegboard::accordion>
</section>
```

**3. Avoid complex content in headings:**

Keep headings simple and avoid interactive elements:

```blade
{{-- ✅ Good - Simple text heading --}}
<x-pegboard::accordion.item heading="Contact Support">

{{-- ❌ Bad - Interactive elements in heading --}}
<x-pegboard::accordion.heading>
    Contact Support <button>Click here</button>
</x-pegboard::accordion.heading>
```

**4. Ensure sufficient color contrast:**

All text meets WCAG AA standards (4.5:1 contrast ratio):
- Heading text: Uses `text-foreground` (7:1 ratio)
- Content text: Uses `text-muted-foreground` (4.5:1 ratio)
- Hover states: Uses `hover:bg-muted/50` (sufficient contrast maintained)

**5. Respect reduced motion preferences:**

Animations automatically respect `prefers-reduced-motion`:

```css
@media (prefers-reduced-motion: reduce) {
    /* Grid and opacity transitions are disabled */
    [&::details-content] {
        transition: none;
    }
}
```

### Motion and Animations

The accordion uses CSS animations that are both smooth and accessible:

**Animation properties:**
- Grid-template-rows: `0fr` → `1fr` (height transition)
- Opacity: `0` → `100` (fade in/out)
- Duration: `duration-normal` (200ms)
- Easing: `ease-in-out`
- Behavior: `transition-behavior-[allow-discrete]` (enables animation of discrete properties)

**How it works:**
- Uses `[&::details-content]` pseudo-element selectors for consistent animations
- Transitions trigger on every open/close (not just first render)
- `transition-behavior-[allow-discrete]` allows animating the `display` property
- No JavaScript needed - purely CSS-driven

**Reduced motion support:**

Users who prefer reduced motion will experience instant open/close without animations, thanks to Tailwind's automatic `@media (prefers-reduced-motion)` handling.

---

## Implementation Details

### Zero JavaScript Architecture

The accordion component requires **zero JavaScript** to function. All interactivity is handled by native browser behavior:

**Native `<details>` element:**
- Browser provides open/close functionality
- Maintains open state
- Handles click events on `<summary>`
- Manages keyboard interactions
- Announces state to screen readers

**Single mode (mutual exclusivity):**
- Native HTML `name` attribute on `<details>` elements
- Browser automatically closes other details with same `name` when one opens
- No JavaScript event listeners needed

**CSS animations:**
- `[&::details-content]` pseudo-element selectors target the content wrapper
- Grid-template-rows transitions create smooth height animation
- `transition-behavior-[allow-discrete]` enables discrete property animation
- All animation triggers happen via CSS, not JavaScript

### Pure Tailwind CSS Styling

All styling is achieved using **pure Tailwind CSS** classes. No custom CSS file required.

**Shorthand syntax styling:**
```blade
{{-- Pre-styled card appearance --}}
'overflow-hidden rounded-lg border border-border bg-card'

{{-- Content animation (via pseudo-element selectors) --}}
'[&::details-content]:overflow-hidden
 [&::details-content]:grid
 [&::details-content]:grid-rows-[0fr]
 [&::details-content]:opacity-0
 [&::details-content]:transition-[grid-template-rows,opacity,content-visibility]
 [&::details-content]:duration-normal
 [&::details-content]:ease-in-out
 [&::details-content]:transition-behavior-[allow-discrete]
 open:[&::details-content]:grid-rows-[1fr]
 open:[&::details-content]:opacity-100'
```

**How animations work:**

1. **Initial state** (closed):
   - `grid-rows-[0fr]` - Content takes no space
   - `opacity-0` - Content is transparent
   - `overflow-hidden` - Prevents content from showing

2. **Open state**:
   - `open:[&::details-content]:grid-rows-[1fr]` - Content expands to full height
   - `open:[&::details-content]:opacity-100` - Content fades in
   - Browser adds `open` attribute to `<details>` when opened

3. **Transition**:
   - `transition-[grid-template-rows,opacity,content-visibility]` - Animates these properties
   - `duration-normal` - 200ms animation duration (from theme tokens)
   - `ease-in-out` - Smooth easing function
   - `transition-behavior-[allow-discrete]` - Allows animating discrete properties

**Theme tokens used:**
- `duration-normal` - 200ms (from `@theme` block)
- `ease-in-out` - Easing function
- `bg-card` - Card background color (auto light/dark)
- `border-border` - Border color (auto light/dark)
- `text-foreground` - Main text color
- `text-muted-foreground` - Secondary text color

### Batteries-Included-But-Swappable

The component follows Pegboard's core principle of providing pre-styled defaults while allowing full customization:

**Shorthand syntax:**
- Pre-styled heading with icon
- Pre-styled content wrapper
- Card appearance with borders and backgrounds
- Hover effects

**Verbose syntax:**
- Full control over all styling
- Compose custom designs with sub-components
- Animations still work (built into `<details>`)
- Maintain functionality without styling constraints

## Additional Resources

- [MDN: `<details>` element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details)
- [MDN: `<summary>` element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/summary)
- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
