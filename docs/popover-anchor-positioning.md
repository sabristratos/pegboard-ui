# Popover API with CSS Anchor Positioning & Tailwind CSS

Complete guide for building modern, accessible popovers using native browser APIs with Tailwind CSS.

## Overview

This guide demonstrates how to combine three powerful web platform features:

- **Popover API** - Native browser popover elements with built-in accessibility
- **CSS Anchor Positioning** - Position elements relative to anchor elements
- **Tailwind CSS** - Utility-first styling with custom properties

## Table of Contents

1. [Quick Start](#quick-start)
2. [Popover API Fundamentals](#popover-api-fundamentals)
3. [CSS Anchor Positioning](#css-anchor-positioning)
4. [Tailwind CSS Integration](#tailwind-css-integration)
5. [Complete Examples](#complete-examples)
6. [Best Practices](#best-practices)
7. [Browser Support](#browser-support)

---

## Quick Start

Here's a minimal working example combining all three technologies:

```blade
{{-- Define custom anchor properties in your CSS --}}
<style>
@theme {
  /* Add anchor positioning utilities */
  --anchor-name-button: --my-button;
}
</style>

{{-- Button (anchor element) --}}
<button
  id="trigger"
  popovertarget="my-popover"
  class="[anchor-name:--my-button]"
>
  Open Popover
</button>

{{-- Popover (positioned element) --}}
<div
  id="my-popover"
  popover="auto"
  class="m-0 [position-anchor:--my-button] [top:anchor(bottom)] [left:anchor(center)] -translate-x-1/2 mt-2"
>
  Popover content
</div>
```

---

## Popover API Fundamentals

### Creating a Popover

Add the `popover` attribute to any HTML element:

```html
<div id="my-popover" popover>
  I'm a popover!
</div>
```

### Popover States

#### Auto State (default)

```html
<div popover="auto">Content</div>
```

- Supports "light dismiss" (clicking outside closes it)
- Only one auto popover visible at a time
- Closes on Esc key
- **Best for:** Dropdowns, menus, dialogs

#### Manual State

```html
<div popover="manual">Content</div>
```

- Requires explicit show/hide
- Multiple can be open simultaneously
- No light dismiss
- **Best for:** Toast notifications, persistent panels

#### Hint State

```html
<div popover="hint">Content</div>
```

- Doesn't close other auto popovers
- Closes other hint popovers
- **Best for:** Tooltips alongside UI popovers

### Control Buttons

#### Basic Toggle

```html
<button popovertarget="my-popover">Toggle</button>
<div id="my-popover" popover>Content</div>
```

#### Specific Actions

```html
<!-- Show only -->
<button popovertarget="my-popover" popovertargetaction="show">
  Show
</button>

<!-- Hide only -->
<button popovertarget="my-popover" popovertargetaction="hide">
  Hide
</button>

<!-- Toggle (default) -->
<button popovertarget="my-popover" popovertargetaction="toggle">
  Toggle
</button>
```

### JavaScript Control

```javascript
const popover = document.getElementById('my-popover');

// Show/hide/toggle
popover.showPopover();
popover.hidePopover();
popover.togglePopover();

// Listen for events
popover.addEventListener('beforetoggle', (event) => {
  console.log(`Going from ${event.oldState} to ${event.newState}`);
  // event.preventDefault() to cancel
});

popover.addEventListener('toggle', (event) => {
  console.log(`Popover is now ${event.newState}`);
  console.log(`Source: ${event.source}`); // Triggering element
});
```

### Styling Popovers

#### Open State

```html
<div
  popover
  class="opacity-0 open:opacity-100 transition-opacity"
>
  Fades in when open
</div>
```

#### Backdrop

```html
<div
  popover
  class="[&::backdrop]:bg-black/50 [&::backdrop]:backdrop-blur-sm"
>
  Content with styled backdrop
</div>
```

---

## CSS Anchor Positioning

### Core Concepts

CSS Anchor Positioning allows you to position elements relative to other elements without JavaScript.

#### 1. Define an Anchor

Assign a unique identifier to the anchor element:

```css
.button {
  anchor-name: --my-anchor;
}
```

#### 2. Associate with Positioned Element

Link the positioned element to its anchor:

```css
.popover {
  position: absolute;
  position-anchor: --my-anchor;
}
```

#### 3. Position Using anchor() Function

Use the `anchor()` function in inset properties:

```css
.popover {
  top: anchor(bottom);    /* Below the anchor */
  left: anchor(center);   /* Horizontally centered */
}
```

### Anchor Function Syntax

```css
anchor(<anchor-name>? <anchor-side>, <fallback>?)
```

#### Parameters

- **anchor-name** (optional): Reference to named anchor (e.g., `--my-anchor`)
- **anchor-side**: Which edge/point to reference
- **fallback** (optional): Fallback value if anchor is invalid

#### Valid Anchor Sides

**Physical Sides:**
- `top`, `bottom`, `left`, `right`
- `center` (special value for centering)

**Logical Sides:**
- `start`, `end` (block direction)
- `self-start`, `self-end` (inline direction)

**Special Values:**
- `inside` - Inside edge of the anchor
- `outside` - Outside edge of the anchor
- Percentages - Position along the anchor's axis

### Compatible Properties

The `anchor()` function works with:

- `top`, `bottom`, `left`, `right`
- `inset-block-start`, `inset-block-end`
- `inset-inline-start`, `inset-inline-end`
- `inset` (shorthand)

### Common Positioning Patterns

```css
/* Below anchor, centered */
.popover {
  top: anchor(bottom);
  left: anchor(center);
  translate: -50% 0; /* Center horizontally */
}

/* Above anchor, aligned left */
.popover {
  bottom: anchor(top);
  left: anchor(left);
}

/* To the right, vertically centered */
.popover {
  left: anchor(right);
  top: anchor(center);
  translate: 0 -50%; /* Center vertically */
}

/* With spacing using calc() */
.popover {
  top: calc(anchor(bottom) + 8px);
  left: anchor(left);
}
```

### Multiple Anchors

Position relative to different anchors on different axes:

```css
.popover {
  position: fixed;
  position-anchor: --primary-anchor;
  top: anchor(--primary-anchor bottom);
  right: anchor(--secondary-anchor left);
}
```

### Implicit Anchor Association

When using `popovertarget`, the browser automatically creates an anchor relationship:

```html
<button id="trigger" popovertarget="menu">Menu</button>
<div id="menu" popover>
  <!-- Automatically associated with #trigger -->
</div>
```

You can then use `anchor()` without specifying the anchor name:

```css
#menu {
  top: anchor(bottom);
  left: anchor(left);
}
```

---

## Tailwind CSS Integration

### Using Arbitrary Values

Tailwind's arbitrary value syntax (`[property:value]`) enables anchor positioning:

```html
<div class="[anchor-name:--my-anchor]">Anchor</div>

<div class="[position-anchor:--my-anchor] [top:anchor(bottom)]">
  Positioned
</div>
```

### Creating Custom Theme Tokens

For reusable anchor names, add them to your `@theme` block:

```css
@theme {
  --anchor-name-button: --button-anchor;
  --anchor-name-menu: --menu-anchor;
  --anchor-name-tooltip: --tooltip-anchor;
}
```

Then reference in HTML:

```html
<button class="[anchor-name:var(--anchor-name-button)]">
  Button
</button>
```

### Common Positioning Utilities

```html
<!-- Below anchor, centered -->
<div class="[top:anchor(bottom)] [left:anchor(center)] -translate-x-1/2">

<!-- Above anchor, left-aligned -->
<div class="[bottom:anchor(top)] [left:anchor(left)]">

<!-- Right of anchor, vertically centered -->
<div class="[left:anchor(right)] [top:anchor(center)] -translate-y-1/2">

<!-- With spacing -->
<div class="[top:calc(anchor(bottom)+0.5rem)] [left:anchor(left)]">
```

### Combining with Tailwind Variants

```html
<!-- Responsive anchor positioning -->
<div class="
  [top:anchor(bottom)]
  md:[top:anchor(top)]
  lg:[left:anchor(right)]
">

<!-- Conditional positioning based on state -->
<div class="
  [top:anchor(bottom)]
  open:[top:anchor(top)]
">
```

### Popover Transitions

Use Tailwind's `starting` variant for entrance animations:

```html
<div
  popover
  class="
    m-0
    transition-[opacity,transform,overlay,display]
    transition-discrete
    duration-200
    starting:opacity-0
    starting:scale-95
    open:opacity-100
    open:scale-100
  "
>
  Animated popover
</div>
```

**Key utilities:**
- `transition-discrete` - Enables transitions on `display` and `overlay`
- `starting:opacity-0` - Initial state using `@starting-style`
- `open:opacity-100` - State when popover is open
- `duration-200` - Transition duration

### Backdrop Styling

```html
<div
  popover
  class="
    [&::backdrop]:bg-black/50
    [&::backdrop]:backdrop-blur-sm
    [&::backdrop]:transition-all
    [&::backdrop]:duration-200
    [&::backdrop]:starting:opacity-0
  "
>
  Content
</div>
```

### Reset Default Popover Styles

Popovers have default browser styles. Reset them for full control:

```html
<div
  popover
  class="
    m-0              <!-- Remove default margins -->
    [inset:auto]     <!-- Remove default positioning -->
    p-4              <!-- Add your own spacing -->
    bg-white         <!-- Add your own background -->
    border           <!-- Add your own border -->
    rounded-lg       <!-- Add your own border radius -->
    shadow-lg        <!-- Add your own shadow -->
  "
>
  Content
</div>
```

---

## Complete Examples

### Example 1: Dropdown Menu

```blade
<button
  id="menu-button"
  popovertarget="dropdown-menu"
  class="
    px-4 py-2
    bg-primary text-primary-foreground
    rounded-lg
    [anchor-name:--menu-button]
  "
>
  Options
</button>

<div
  id="dropdown-menu"
  popover="auto"
  class="
    m-0 p-0
    [inset:auto]
    [position-anchor:--menu-button]
    [top:calc(anchor(bottom)+0.5rem)]
    [left:anchor(left)]
    min-w-48
    bg-popover
    text-popover-foreground
    border border-border
    rounded-lg
    shadow-lg
    transition-[opacity,transform,overlay,display]
    transition-discrete
    duration-fast
    starting:opacity-0
    starting:scale-95
    origin-top-left
  "
>
  <ul class="py-1">
    <li>
      <button class="w-full px-4 py-2 text-left hover:bg-muted">
        Edit
      </button>
    </li>
    <li>
      <button class="w-full px-4 py-2 text-left hover:bg-muted">
        Delete
      </button>
    </li>
  </ul>
</div>
```

### Example 2: Tooltip

```blade
<button
  id="help-button"
  popovertarget="tooltip"
  popovertargetaction="show"
  class="[anchor-name:--help-button] p-2"
  @mouseenter="$refs.tooltip.showPopover()"
  @mouseleave="$refs.tooltip.hidePopover()"
>
  ?
</button>

<div
  x-ref="tooltip"
  id="tooltip"
  popover="hint"
  class="
    m-0 px-3 py-1.5
    [inset:auto]
    [position-anchor:--help-button]
    [bottom:calc(anchor(top)+0.5rem)]
    [left:anchor(center)]
    -translate-x-1/2
    max-w-xs
    bg-gray-900
    text-white text-sm
    rounded-md
    shadow-lg
    transition-[opacity,overlay,display]
    transition-discrete
    duration-150
    starting:opacity-0
  "
>
  This is helpful information
</div>
```

### Example 3: Contextual Panel

```blade
<div class="relative">
  <article
    id="post"
    class="[anchor-name:--post] p-6"
  >
    <h2>Article Title</h2>
    <p>Article content...</p>

    <button
      popovertarget="actions-panel"
      class="absolute top-4 right-4"
    >
      Actions
    </button>
  </article>

  <div
    id="actions-panel"
    popover="auto"
    class="
      m-0 p-4
      [inset:auto]
      [position-anchor:--post]
      [top:anchor(top)]
      [left:calc(anchor(right)+1rem)]
      w-64
      bg-card
      border border-border
      rounded-lg
      shadow-xl
      transition-[opacity,transform,overlay,display]
      transition-discrete
      duration-200
      starting:opacity-0
      starting:translate-x-4
      origin-left
    "
  >
    <h3 class="font-semibold mb-2">Quick Actions</h3>
    <ul class="space-y-2">
      <li><button class="text-blue-600">Share</button></li>
      <li><button class="text-blue-600">Bookmark</button></li>
      <li><button class="text-red-600">Report</button></li>
    </ul>
  </div>
</div>
```

### Example 4: Multi-Position Popover

Popover that repositions based on available space:

```blade
<button
  id="smart-button"
  popovertarget="smart-popover"
  class="[anchor-name:--smart-anchor]"
>
  Smart Popover
</button>

<div
  id="smart-popover"
  popover="auto"
  class="
    m-0 p-4
    [inset:auto]
    [position-anchor:--smart-anchor]

    /* Try bottom first */
    [top:anchor(bottom)]
    [left:anchor(center)]
    -translate-x-1/2 mt-2

    /* Fallback to top if not enough space */
    [position-try-fallbacks:flip-block]

    bg-popover
    border border-border
    rounded-lg
    shadow-lg
    transition-[opacity,transform,overlay,display]
    transition-discrete
    duration-200
    starting:opacity-0
    starting:scale-95
  "
>
  Smart content
</div>
```

### Example 5: Nested Popovers

```blade
<button
  id="main-trigger"
  popovertarget="main-menu"
  class="[anchor-name:--main-button]"
>
  Main Menu
</button>

<div
  id="main-menu"
  popover="auto"
  class="
    m-0 p-2
    [inset:auto]
    [position-anchor:--main-button]
    [top:anchor(bottom)]
    [left:anchor(left)]
    mt-2
    bg-popover border rounded-lg shadow-lg
  "
>
  <button
    popovertarget="submenu"
    class="[anchor-name:--submenu-button] w-full text-left px-4 py-2"
  >
    More Options →
  </button>

  <div
    id="submenu"
    popover="auto"
    class="
      m-0 p-2
      [inset:auto]
      [position-anchor:--submenu-button]
      [left:calc(anchor(right)+0.5rem)]
      [top:anchor(top)]
      bg-popover border rounded-lg shadow-lg
    "
  >
    <button class="w-full text-left px-4 py-2">Sub Item 1</button>
    <button class="w-full text-left px-4 py-2">Sub Item 2</button>
  </div>
</div>
```

---

## Best Practices

### 1. Reset Default Styles

Always reset default popover styles for full control:

```html
<div popover class="m-0 [inset:auto]">
  <!-- Your styled content -->
</div>
```

### 2. Use Semantic Anchor Names

```css
/* Good */
@theme {
  --anchor-name-user-menu: --user-menu;
  --anchor-name-settings-panel: --settings-panel;
}

/* Avoid */
@theme {
  --anchor-name-thing1: --x;
  --anchor-name-stuff: --y;
}
```

### 3. Provide Fallback Values

```html
<div class="[top:anchor(bottom,100px)]">
  <!-- Fallback to 100px if anchor is invalid -->
</div>
```

### 4. Choose the Right Popover State

- **auto** - Dropdowns, menus, dialogs (most common)
- **manual** - Toast notifications, multi-step flows
- **hint** - Tooltips that shouldn't close other UI

### 5. Accessibility Considerations

The Popover API provides built-in accessibility, but enhance it:

```html
<button
  popovertarget="menu"
  aria-label="Open navigation menu"
>
  Menu
</button>

<div
  id="menu"
  popover="auto"
  role="menu"
>
  <button role="menuitem">Option 1</button>
  <button role="menuitem">Option 2</button>
</div>
```

### 6. Handle Focus Management

```javascript
popover.addEventListener('toggle', (event) => {
  if (event.newState === 'open') {
    // Focus first interactive element
    popover.querySelector('button, a, input')?.focus();
  }
});
```

### 7. Combine with Alpine.js Wisely

```html
<div
  x-data="{ isOpen: false }"
  x-ref="popover"
  popover="manual"
  @toggle="isOpen = ($event.newState === 'open')"
>
  <div x-show="isOpen" x-transition>
    Content with Alpine animations
  </div>
</div>
```

**Important:** Don't duplicate state management - use popover events to sync Alpine state.

### 8. Responsive Positioning

Use Tailwind's responsive variants:

```html
<div class="
  [top:anchor(bottom)]
  [left:anchor(center)]
  -translate-x-1/2

  md:[top:anchor(top)]
  md:[bottom:auto]

  lg:[top:anchor(center)]
  lg:[left:anchor(right)]
  lg:-translate-x-0
  lg:-translate-y-1/2
">
```

### 9. Performance Optimization

For many popovers, use event delegation:

```javascript
document.addEventListener('toggle', (event) => {
  if (event.target.matches('[popover]')) {
    console.log(`Popover ${event.target.id} is now ${event.newState}`);
  }
}, true); // Use capture phase
```

### 10. Progressive Enhancement

Provide fallback for browsers without support:

```html
@supports not (anchor-name: --test) {
  [popover] {
    /* Fallback positioning */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
}
```

---

## Browser Support

### Popover API

- **Chrome/Edge:** 114+
- **Safari:** 17+
- **Firefox:** 125+

### CSS Anchor Positioning

- **Limited availability** - Check [caniuse.com](https://caniuse.com/css-anchor-positioning)
- **Chrome/Edge:** 125+ (with flag in earlier versions)
- **Safari:** Not yet supported
- **Firefox:** Not yet supported

### Fallback Strategy

```css
@supports (anchor-name: --test) {
  /* Modern anchor positioning */
  .popover {
    position-anchor: --button;
    top: anchor(bottom);
  }
}

@supports not (anchor-name: --test) {
  /* Fallback positioning */
  .popover {
    position: absolute;
    margin-top: 0.5rem;
  }
}
```

Or use a polyfill like [@oddbird/css-anchor-polyfill](https://github.com/oddbird/css-anchor-positioning).

---

## Additional Resources

- [MDN: Popover API](https://developer.mozilla.org/en-US/docs/Web/API/Popover_API)
- [MDN: CSS Anchor Positioning](https://developer.mozilla.org/en-US/docs/Web/CSS/anchor)
- [Tailwind CSS: Adding Custom Styles](https://tailwindcss.com/docs/adding-custom-styles)
- [Tailwind CSS: Hover, Focus, and Other States](https://tailwindcss.com/docs/hover-focus-and-other-states)
- [OddBird Anchor Positioning Polyfill](https://github.com/oddbird/css-anchor-positioning)

---

## Summary

The combination of Popover API, CSS Anchor Positioning, and Tailwind CSS creates powerful, accessible popovers with minimal JavaScript:

1. **Popover API** handles visibility, focus management, and accessibility
2. **CSS Anchor Positioning** maintains spatial relationships between elements
3. **Tailwind CSS** provides flexible, responsive styling through utility classes

This approach is:
- **Native** - Uses web platform features
- **Accessible** - Built-in ARIA relationships and keyboard support
- **Performant** - Minimal JavaScript required
- **Maintainable** - Declarative HTML and CSS
- **Flexible** - Easy to customize and extend
