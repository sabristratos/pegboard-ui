# Spinner Component

A versatile, accessible loading indicator component with multiple animation styles, sizes, and color variants for TALL stack applications.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Structure](#component-structure)
- [Props Reference](#props-reference)
- [Variants](#variants)
- [Sizes](#sizes)
- [Colors](#colors)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard Spinner component provides elegant loading indicators to communicate processing states to users. Built with Tailwind CSS v4 and native CSS animations, it offers six distinct visual styles with support for multiple sizes and semantic color variants.

**Key Features:**
- Six unique animation variants
- Three predefined sizes (sm, md, lg)
- Semantic color variants (primary, success, warning, destructive)
- Fully accessible with ARIA labels
- GPU-accelerated CSS animations
- Lightweight (no JavaScript required)
- Dark mode support
- Respects `prefers-reduced-motion`
- Customizable via Tailwind classes

## Basic Usage

### Simple Spinner

The most basic usage with default settings:

```blade
{{-- Default medium-sized spinner --}}
<x-pegboard::spinner />
```

### With Variant

Choose from six animation styles:

```blade
{{-- Simple SVG spinner --}}
<x-pegboard::spinner variant="simple" />

{{-- Gradient ring spinner --}}
<x-pegboard::spinner variant="gradient" />

{{-- 12-bar radial spinner --}}
<x-pegboard::spinner variant="spinner" />
```

### With Size

Control the spinner dimensions:

```blade
{{-- Small spinner (16x16px) --}}
<x-pegboard::spinner size="sm" />

{{-- Medium spinner (32x32px - default) --}}
<x-pegboard::spinner size="md" />

{{-- Large spinner (48x48px) --}}
<x-pegboard::spinner size="lg" />
```

### Full-Page Loading

Center a spinner for full-page loading states:

```blade
<div class="flex items-center justify-center min-h-screen">
    <x-pegboard::spinner variant="simple" size="lg" />
</div>
```

## Component Structure

The spinner component is a pure Blade component with CSS animations:

```
<div aria-label="Loading">              <!-- Wrapper with ARIA label -->
    <div>                                <!-- Size container -->
        <!-- Variant-specific markup -->
    </div>
</div>
```

**Important:** The component uses native CSS animations defined in `pegboard.css` with Tailwind v4 utilities.

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Animation style: `default`, `simple`, `gradient`, `spinner`, `wave`, `dots` |
| `size` | string | `'md'` | Spinner size: `sm` (16x16), `md` (32x32), `lg` (48x48) |
| `label` | string | `'Loading'` | Accessibility label for screen readers |
| `class` | string | - | Additional Tailwind classes (e.g., for custom colors) |

## Variants

### Default (Double Ring)

A sophisticated double-ring spinner with overlapping animations:

```blade
<x-pegboard::spinner variant="default" />
```

**Visual characteristics:**
- Two concentric rings
- Outer ring: solid border with ease-in-out animation
- Inner ring: dotted border with linear animation
- Rotation speed: 1.5s (outer), 1s (inner)
- Best for: General loading states

### Simple (SVG Circle)

A clean, minimal SVG-based spinner:

```blade
<x-pegboard::spinner variant="simple" />
```

**Visual characteristics:**
- Single SVG circle with partial fill
- Smooth 360° rotation
- Lightweight markup
- Best for: Buttons, inline loading

### Gradient (Conic Gradient)

A modern gradient ring with smooth color transition:

```blade
<x-pegboard::spinner variant="gradient" />
```

**Visual characteristics:**
- Conic gradient from transparent to primary color
- Smooth 1s rotation
- Visually striking effect
- Best for: Hero sections, splash screens

### Spinner (12-Bar Radial)

A classic radial spinner with 12 animated bars:

```blade
<x-pegboard::spinner variant="spinner" />
```

**Visual characteristics:**
- 12 bars arranged in a circle
- Sequential fade-in/fade-out animation
- Familiar iOS/Android style
- Best for: Mobile-first designs, app-like interfaces

### Wave (3 Dots)

Playful bouncing dots animation:

```blade
<x-pegboard::spinner variant="wave" />
```

**Visual characteristics:**
- Three dots in a row
- Smooth up-down wave motion
- Staggered animation delays
- Best for: Casual interfaces, chat applications

### Dots (3 Dots Blink)

Simple blinking dots for subtle loading indication:

```blade
<x-pegboard::spinner variant="dots" />
```

**Visual characteristics:**
- Three dots in a row
- Fade in/out blinking animation
- Minimal visual distraction
- Best for: Subtle loading states, typing indicators

## Sizes

### Small (sm)

Compact 16x16px spinner for inline usage:

```blade
<x-pegboard::spinner variant="simple" size="sm" />
```

**Use cases:**
- Inside buttons
- Inline with text
- Table cells
- Form inputs
- Compact UI elements

**Example:**

```blade
<button class="flex items-center gap-2">
    <x-pegboard::spinner variant="simple" size="sm" />
    <span>Loading...</span>
</button>
```

### Medium (md) - Default

Standard 32x32px spinner for general use:

```blade
<x-pegboard::spinner variant="default" size="md" />
```

**Use cases:**
- Card loading states
- Modal dialogs
- Form sections
- Default loading indicator

### Large (lg)

Prominent 48x48px spinner for full-page states:

```blade
<x-pegboard::spinner variant="simple" size="lg" />
```

**Use cases:**
- Full-page loading
- Empty states
- Splash screens
- Initial app load

**Example:**

```blade
<div class="flex flex-col items-center justify-center min-h-[400px] gap-4">
    <x-pegboard::spinner variant="gradient" size="lg" />
    <p class="text-muted-foreground">Loading your content...</p>
</div>
```

## Colors

Spinners use the `text-primary` color by default and inherit theme colors automatically. Customize colors using Tailwind classes:

### Primary (Default)

```blade
<x-pegboard::spinner variant="simple" class="text-primary" />
```

### Success

```blade
<x-pegboard::spinner variant="simple" class="text-success" />
```

### Warning

```blade
<x-pegboard::spinner variant="simple" class="text-warning" />
```

### Destructive

```blade
<x-pegboard::spinner variant="simple" class="text-destructive" />
```

### Custom Colors

```blade
{{-- Use any Tailwind color --}}
<x-pegboard::spinner variant="simple" class="text-blue-500" />
<x-pegboard::spinner variant="simple" class="text-purple-600" />
```

**Note:** Color customization works best with `simple`, `gradient`, `wave`, and `dots` variants. The `default` and `spinner` variants use the `border-b-primary` and `bg-primary` classes respectively.

## Examples

### Button Loading State

```blade
<button
    class="flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground rounded"
    wire:loading.attr="disabled"
>
    <span wire:loading.remove>Save Changes</span>
    <span wire:loading class="flex items-center gap-2">
        <x-pegboard::spinner variant="simple" size="sm" class="text-white" />
        Saving...
    </span>
</button>
```

### Card Loading State

```blade
<div class="bg-card border border-border rounded-lg p-6">
    @if($loading)
        <div class="flex flex-col items-center justify-center py-12 gap-4">
            <x-pegboard::spinner variant="default" size="md" />
            <p class="text-sm text-muted-foreground">Loading data...</p>
        </div>
    @else
        {{-- Card content --}}
    @endif
</div>
```

### Full-Page Loading

```blade
<div class="fixed inset-0 bg-background/80 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="flex flex-col items-center gap-4">
        <x-pegboard::spinner variant="gradient" size="lg" />
        <div class="text-center">
            <h3 class="font-semibold text-lg">Loading Application</h3>
            <p class="text-sm text-muted-foreground">Please wait...</p>
        </div>
    </div>
</div>
```

### Table Row Loading

```blade
<tr>
    <td colspan="5" class="text-center py-8">
        <div class="flex flex-col items-center gap-3">
            <x-pegboard::spinner variant="spinner" size="md" />
            <span class="text-sm text-muted-foreground">Fetching records...</span>
        </div>
    </td>
</tr>
```

### Inline Text Loading

```blade
<p class="flex items-center gap-2">
    <x-pegboard::spinner variant="dots" size="sm" />
    <span>Processing your request</span>
</p>
```

### Livewire Wire:Loading

```blade
{{-- Show spinner during Livewire actions --}}
<div>
    <button wire:click="fetchData">Fetch Data</button>

    <div wire:loading wire:target="fetchData" class="flex items-center gap-2 mt-4">
        <x-pegboard::spinner variant="simple" size="sm" />
        <span>Loading...</span>
    </div>
</div>
```

### Alpine.js Loading State

```blade
<div x-data="{ loading: false }">
    <button
        @click="loading = true; setTimeout(() => loading = false, 2000)"
        class="px-4 py-2 bg-primary text-primary-foreground rounded"
    >
        <span x-show="!loading">Click Me</span>
        <span x-show="loading" class="flex items-center gap-2">
            <x-pegboard::spinner variant="simple" size="sm" class="text-white" />
            Loading...
        </span>
    </button>
</div>
```

### Form Submission

```blade
<form wire:submit.prevent="save">
    {{-- Form fields --}}

    <button
        type="submit"
        class="px-4 py-2 bg-primary text-primary-foreground rounded disabled:opacity-50"
        wire:loading.attr="disabled"
    >
        <span wire:loading.remove>Submit Form</span>
        <span wire:loading class="flex items-center gap-2">
            <x-pegboard::spinner variant="simple" size="sm" class="text-white" />
            Submitting...
        </span>
    </button>
</form>
```

### Skeleton Loading with Spinner

```blade
<div class="space-y-4">
    <div class="flex items-center justify-center py-8">
        <x-pegboard::spinner variant="wave" size="md" />
    </div>

    {{-- Skeleton placeholders --}}
    <div class="space-y-3">
        <div class="h-4 bg-muted rounded animate-pulse"></div>
        <div class="h-4 bg-muted rounded animate-pulse w-5/6"></div>
        <div class="h-4 bg-muted rounded animate-pulse w-4/6"></div>
    </div>
</div>
```

### Different Spinners for Different States

```blade
<div>
    {{-- Loading --}}
    @if($state === 'loading')
        <div class="flex items-center gap-2">
            <x-pegboard::spinner variant="simple" size="sm" />
            <span>Loading...</span>
        </div>
    @endif

    {{-- Processing --}}
    @if($state === 'processing')
        <div class="flex items-center gap-2">
            <x-pegboard::spinner variant="spinner" size="sm" class="text-warning" />
            <span>Processing...</span>
        </div>
    @endif

    {{-- Uploading --}}
    @if($state === 'uploading')
        <div class="flex items-center gap-2">
            <x-pegboard::spinner variant="gradient" size="sm" class="text-success" />
            <span>Uploading...</span>
        </div>
    @endif
</div>
```

## Best Practices

### 1. Choose the Right Variant

**Match the variant to your design context:**

```blade
{{-- ✅ Good - Simple for buttons --}}
<button class="flex items-center gap-2">
    <x-pegboard::spinner variant="simple" size="sm" />
    Loading
</button>

{{-- ✅ Good - Gradient for hero sections --}}
<div class="hero flex items-center justify-center min-h-screen">
    <x-pegboard::spinner variant="gradient" size="lg" />
</div>

{{-- ✅ Good - Wave for casual interfaces --}}
<div class="chat-bubble">
    <x-pegboard::spinner variant="wave" size="sm" />
    <span>Typing...</span>
</div>

{{-- ❌ Bad - Large spinner in button --}}
<button>
    <x-pegboard::spinner size="lg" />
</button>
```

### 2. Use Appropriate Sizes

```blade
{{-- ✅ Good - Size matches context --}}
<button class="text-sm">
    <x-pegboard::spinner size="sm" />
</button>

<div class="card">
    <x-pegboard::spinner size="md" />
</div>

<div class="full-page-loader">
    <x-pegboard::spinner size="lg" />
</div>

{{-- ❌ Bad - Mismatched sizes --}}
<button class="text-xs">
    <x-pegboard::spinner size="lg" /> {{-- Too large --}}
</button>
```

### 3. Provide Context

**Always include text labels for clarity:**

```blade
{{-- ✅ Good - Clear context --}}
<div class="flex items-center gap-2">
    <x-pegboard::spinner variant="simple" size="sm" />
    <span>Loading your profile...</span>
</div>

{{-- ❌ Bad - No context --}}
<div>
    <x-pegboard::spinner />
</div>
```

### 4. Use Semantic Colors

```blade
{{-- ✅ Good - Colors match purpose --}}
<x-pegboard::spinner variant="simple" class="text-success" />
<span class="text-success">Upload complete</span>

<x-pegboard::spinner variant="simple" class="text-warning" />
<span class="text-warning">Processing payment...</span>

{{-- ❌ Avoid - Confusing color usage --}}
<x-pegboard::spinner class="text-destructive" />
<span>Loading successfully...</span> {{-- Red suggests error --}}
```

### 5. Center Appropriately

```blade
{{-- ✅ Good - Proper centering --}}
<div class="flex items-center justify-center min-h-[200px]">
    <x-pegboard::spinner variant="default" size="md" />
</div>

{{-- ✅ Good - Inline alignment --}}
<p class="flex items-center gap-2">
    <x-pegboard::spinner variant="dots" size="sm" />
    <span>Loading...</span>
</p>
```

### 6. Don't Overuse Spinners

```blade
{{-- ❌ Bad - Too many spinners --}}
<div>
    <x-pegboard::spinner /> Loading users...
    <x-pegboard::spinner /> Loading posts...
    <x-pegboard::spinner /> Loading comments...
</div>

{{-- ✅ Good - Single spinner for grouped loading --}}
<div class="flex flex-col items-center gap-3">
    <x-pegboard::spinner variant="default" size="md" />
    <p>Loading content...</p>
</div>
```

### 7. Consider Performance

**Spinners use GPU-accelerated animations:**

```blade
{{-- ✅ Good - Single spinner instance --}}
<div wire:loading>
    <x-pegboard::spinner />
</div>

{{-- ❌ Avoid - Multiple concurrent spinners --}}
<div>
    <x-pegboard::spinner variant="default" />
    <x-pegboard::spinner variant="simple" />
    <x-pegboard::spinner variant="gradient" />
    {{-- Unnecessary visual clutter --}}
</div>
```

### 8. Accessibility Labels

```blade
{{-- ✅ Good - Descriptive label --}}
<x-pegboard::spinner
    variant="simple"
    label="Loading user profile data"
/>

{{-- ✅ Good - Context-specific label --}}
<x-pegboard::spinner
    variant="spinner"
    label="Uploading files"
/>

{{-- ✅ Acceptable - Default label --}}
<x-pegboard::spinner /> {{-- Uses "Loading" by default --}}
```

## Accessibility

The Spinner component follows WCAG 2.1 guidelines and ARIA best practices:

### ARIA Attributes

Spinners automatically include the proper ARIA label:

```html
<div aria-label="Loading" class="relative inline-flex items-center justify-center">
    <!-- Spinner content -->
</div>
```

**Why `aria-label`?**
- Screen readers announce loading state to users
- Provides context for visual loading indicators
- Essential for users who cannot see animations

### Screen Reader Behavior

**Announcements:**
- Spinners are announced with their label when displayed
- Default label: "Loading"
- Custom labels should be descriptive

**Example screen reader output:**

```blade
<x-pegboard::spinner label="Loading user data" />
{{-- Announced as: "Loading user data" --}}

<x-pegboard::spinner label="Processing payment" />
{{-- Announced as: "Processing payment" --}}
```

### Keyboard Accessibility

**Spinners are non-interactive:**
- Cannot receive keyboard focus (not focusable)
- No keyboard interaction required
- Visual indicator only

### Visual Accessibility

**Color contrast:**
- All variants use theme colors with sufficient contrast
- Primary color: Meets WCAG AA standards (4.5:1 minimum)
- Semantic colors (success, warning, destructive): All accessible
- Dark mode support: Automatic via Tailwind v4 theme

**Animation clarity:**
- Clear, visible motion for sighted users
- Smooth animations at appropriate speeds
- No rapid flashing (seizure-safe)

### Reduced Motion

Spinners respect `prefers-reduced-motion` browser setting:

```css
@media (prefers-reduced-motion: reduce) {
    .spinner-animation {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
    }
}
```

**Users who prefer reduced motion will see:**
- Static spinner (no rotation)
- All functionality preserved
- Maintains loading indication
- Respects user preferences

### Best Practices for Accessibility

**1. Provide meaningful labels:**

```blade
{{-- ✅ Good - Descriptive label --}}
<x-pegboard::spinner label="Loading product details" />

{{-- ❌ Bad - Generic label --}}
<x-pegboard::spinner label="Loading" />
{{-- Default is fine, but be specific when possible --}}
```

**2. Combine with text for clarity:**

```blade
{{-- ✅ Good - Visual + text context --}}
<div class="flex items-center gap-2">
    <x-pegboard::spinner variant="simple" size="sm" label="Saving changes" />
    <span>Saving changes...</span>
</div>
```

**3. Ensure sufficient color contrast:**

```blade
{{-- ✅ Good - High contrast --}}
<div class="bg-background">
    <x-pegboard::spinner class="text-foreground" />
</div>

{{-- ❌ Avoid - Low contrast --}}
<div class="bg-gray-100">
    <x-pegboard::spinner class="text-gray-200" />
    {{-- Poor visibility --}}
</div>
```

**4. Don't use spinner as sole indicator:**

```blade
{{-- ✅ Good - Multiple indicators --}}
<button disabled class="opacity-50">
    <x-pegboard::spinner size="sm" />
    <span>Saving...</span>
    {{-- Visual (spinner), text ("Saving"), and state (disabled) --}}
</button>

{{-- ❌ Avoid - Spinner only --}}
<button>
    <x-pegboard::spinner size="sm" />
    {{-- No text, unclear what's loading --}}
</button>
```

**5. Test with assistive technology:**

Test spinners with:
- NVDA (Windows)
- JAWS (Windows)
- VoiceOver (macOS/iOS)
- TalkBack (Android)

Verify:
- Label is announced clearly
- Loading state is communicated
- No confusion about application state

---

## Additional Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [CSS Animations Guide](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Animations)
- [ARIA: aria-label](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Attributes/aria-label)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Reduced Motion Media Query](https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-reduced-motion)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
