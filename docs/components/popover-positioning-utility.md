# PopoverPositioning Utility (Developer Guide)

Internal developer documentation for the `PopoverPositioning` utility class used by Pegboard components.

## Overview

The `PopoverPositioning` utility provides centralized CSS anchor positioning logic for all popover-based components (Popover, Select, Dropdown, etc.). This ensures consistent positioning behavior and reduces code duplication.

**Location:** `src/Support/PopoverPositioning.php`

## Why This Utility Exists

Before this utility, each component duplicated positioning logic using either:
- Native CSS anchor positioning (Popover, Select)
- Alpine.js anchor plugin (Dropdown, Tooltip)

This utility standardizes on **native CSS anchor positioning** with the polyfill for browser support.

## Core Methods

### `getConfiguration()` - All-in-One

The recommended method for most use cases. Returns all necessary positioning attributes.

```php
$config = PopoverPositioning::getConfiguration(
    id: 'my-popover',
    placement: 'bottom-start',
    offset: 8,
    matchWidth: false
);

// Returns:
[
    'anchor' => '--anchor-my-popover',
    'styles' => 'position: absolute; position-anchor: ...',
    'transition' => 'origin-center transition-[opacity...] ...',
    'origin' => 'origin-top-left',
    'base' => 'p-0 m-0'
]
```

**Usage in Blade:**

```blade
@php
    use Stratos\Pegboard\Support\PopoverPositioning;

    $popoverId = 'popover-' . uniqid();
    $config = PopoverPositioning::getConfiguration($popoverId, 'bottom', 8);
@endphp

{{-- Trigger (anchor element) --}}
<button style="anchor-name: {{ $config['anchor'] }};">
    Open
</button>

{{-- Popover (positioned element) --}}
<div
    popover="manual"
    class="{{ $config['base'] }} {{ $config['transition'] }} {{ $config['origin'] }}"
    style="{{ $config['styles'] }}"
>
    Content
</div>
```

### `getStyles()` - CSS Positioning Styles

Generates complete inline CSS styles for anchor positioning.

```php
$styles = PopoverPositioning::getStyles(
    placement: 'bottom-start',
    anchorName: '--anchor-my-id',
    offset: 8
);

// Returns:
// "position: absolute; position-anchor: --anchor-my-id; top: anchor(bottom);
//  left: anchor(left); translate: 0 0.5rem; position-try-fallbacks: flip-block, flip-inline;"
```

**When to use:** When you need full control over styling or want to combine with custom styles.

### `getStylesWithWidthMatching()` - Match Trigger Width

Same as `getStyles()` but adds `min-width: anchor-size(width);` to match the anchor's width.

```php
$styles = PopoverPositioning::getStylesWithWidthMatching(
    placement: 'bottom-start',
    anchorName: '--anchor-select',
    offset: 8
);

// Returns styles + "min-width: anchor-size(width);"
```

**When to use:** For Select, Autocomplete, or any dropdown that should match trigger width.

### `generateAnchorName()` - Unique Anchor Names

Generates a consistent anchor name for an ID.

```php
$anchorName = PopoverPositioning::generateAnchorName('my-popover');
// Returns: "--anchor-my-popover"
```

### `transitionClasses()` - Default Transitions

Returns standardized Tailwind classes for popover animations.

```php
$classes = PopoverPositioning::transitionClasses();
// Returns: "origin-center transition-[opacity,transform,overlay,display]
//           duration-fast ease-out transition-discrete starting:opacity-0 starting:scale-95"
```

### `baseClasses()` - Reset Styles

Returns base reset classes to remove default popover styling.

```php
$classes = PopoverPositioning::baseClasses();
// Returns: "p-0 m-0"
```

### `getOriginClass()` - Transform Origin

Returns the appropriate `origin-*` class for a placement.

```php
$origin = PopoverPositioning::getOriginClass('bottom-start');
// Returns: "origin-top-left"

$origin = PopoverPositioning::getOriginClass('top');
// Returns: "origin-bottom"
```

**Why this matters:** Correct transform origin ensures popovers scale from the correct point.

### `getFallbacks()` - Position Try Fallbacks

Returns appropriate fallback strategy for a placement.

```php
$fallbacks = PopoverPositioning::getFallbacks('bottom');
// Returns: "flip-block, flip-inline"

$fallbacks = PopoverPositioning::getFallbacks('right');
// Returns: "flip-inline, flip-block"
```

## Supported Placements

All 12 standard placements are supported:

**Primary Directions:**
- `top`, `bottom`, `left`, `right`

**Start Aligned:**
- `top-start`, `bottom-start`, `left-start`, `right-start`

**End Aligned:**
- `top-end`, `bottom-end`, `left-end`, `right-end`

## Component Integration Examples

### Example 1: Simple Popover

```blade
@php
    use Stratos\Pegboard\Support\PopoverPositioning;

    $id = 'simple-popover';
    $config = PopoverPositioning::getConfiguration($id, 'bottom', 8);
@endphp

<div x-data="popover()">
    <button
        popovertarget="{{ $id }}"
        style="anchor-name: {{ $config['anchor'] }};"
    >
        Click me
    </button>

    <div
        id="{{ $id }}"
        popover="auto"
        class="{{ $config['base'] }} {{ $config['transition'] }} bg-popover p-4 rounded-lg"
        style="{{ $config['styles'] }}"
    >
        Popover content
    </div>
</div>
```

### Example 2: Select Dropdown (Width Matching)

```blade
@php
    use Stratos\Pegboard\Support\PopoverPositioning;

    $selectId = 'my-select';
    $config = PopoverPositioning::getConfiguration(
        $selectId,
        'bottom-start',
        8,
        matchWidth: true
    );
@endphp

<div style="anchor-name: {{ $config['anchor'] }};">
    <button>Select an option</button>
</div>

<div
    id="{{ $selectId }}"
    popover="manual"
    class="{{ $config['base'] }} {{ $config['transition'] }} bg-popover"
    style="{{ $config['styles'] }}"
>
    {{-- Options --}}
</div>
```

### Example 3: Custom Styling with Manual Methods

```blade
@php
    use Stratos\Pegboard\Support\PopoverPositioning;

    $id = 'custom-popover';
    $anchor = PopoverPositioning::generateAnchorName($id);
    $styles = PopoverPositioning::getStyles('top-end', $anchor, 12);
    $origin = PopoverPositioning::getOriginClass('top-end');
@endphp

<button style="anchor-name: {{ $anchor }};">
    Open
</button>

<div
    id="{{ $id }}"
    popover="auto"
    class="my-custom-classes {{ $origin }}"
    style="{{ $styles }} /* custom inline styles */"
>
    Custom popover
</div>
```

## Migration from Alpine Anchor Plugin

If you have components using `x-anchor`, migrate to native positioning:

**Before (Alpine Anchor Plugin):**
```blade
<button x-ref="trigger">Open</button>

<div
    x-show="open"
    x-anchor.bottom-start.offset.8="$refs.trigger"
>
    Content
</div>
```

**After (Native CSS Anchor):**
```blade
@php
    $config = PopoverPositioning::getConfiguration('my-id', 'bottom-start', 8);
@endphp

<button
    popovertarget="my-id"
    style="anchor-name: {{ $config['anchor'] }};"
>
    Open
</button>

<div
    id="my-id"
    popover="manual"
    class="{{ $config['base'] }} {{ $config['transition'] }}"
    style="{{ $config['styles'] }}"
>
    Content
</div>
```

## Best Practices

### 1. Always Use `getConfiguration()` First

Unless you have specific needs, use `getConfiguration()` as your starting point.

```php
// ✅ Good - one call, everything you need
$config = PopoverPositioning::getConfiguration($id, $placement, $offset);

// ❌ Unnecessary - manually calling each method
$anchor = PopoverPositioning::generateAnchorName($id);
$styles = PopoverPositioning::getStyles($placement, $anchor, $offset);
$transition = PopoverPositioning::transitionClasses();
// etc...
```

### 2. Generate Unique IDs

Always ensure IDs are unique to avoid anchor name collisions.

```php
// ✅ Good
$id = 'popover-' . uniqid();

// ✅ Also good
$id = $attributes->get('id', 'select-' . uniqid());

// ❌ Bad - hardcoded, could conflict
$id = 'my-popover';
```

### 3. Use Width Matching for Dropdowns

Selects and similar components should match trigger width.

```php
// ✅ Good for Select
$config = PopoverPositioning::getConfiguration($id, 'bottom-start', 8, matchWidth: true);

// ✅ Good for general Popover
$config = PopoverPositioning::getConfiguration($id, 'bottom', 8, matchWidth: false);
```

### 4. Respect the Config Array Keys

The config array has specific keys - use them correctly.

```php
$config = PopoverPositioning::getConfiguration($id, $placement, $offset);

// ✅ Good - use all config keys
style="anchor-name: {{ $config['anchor'] }};"
class="{{ $config['base'] }} {{ $config['transition'] }} {{ $config['origin'] }}"
style="{{ $config['styles'] }}"

// ❌ Bad - missing origin class
class="{{ $config['base'] }} {{ $config['transition'] }}"
```

## Browser Support

Native CSS anchor positioning has limited browser support:
- Chrome/Edge 125+
- Safari: Not supported (as of 2024)
- Firefox: Not supported (as of 2024)

**Solution:** Pegboard includes the `@oddbird/css-anchor-positioning` polyfill which provides support for all modern browsers.

The polyfill is automatically loaded in `resources/js/index.ts`:

```typescript
import polyfill from '@oddbird/css-anchor-positioning/fn';
```

## Performance Considerations

- **CSS-based:** Positioning is handled by CSS, not JavaScript
- **GPU-accelerated:** Uses `translate` for transforms
- **Minimal JS:** Alpine only handles open/close state
- **Polyfill overhead:** ~15KB gzipped when needed

## Troubleshooting

### Popover Not Positioning Correctly

Check:
1. Anchor name is set on trigger: `style="anchor-name: {{ $config['anchor'] }};"`
2. Positioning styles applied to popover: `style="{{ $config['styles'] }}"`
3. Popover has `popover` attribute
4. IDs are unique (no collisions)

### Popover Width Not Matching Trigger

Ensure you're using `matchWidth: true`:

```php
$config = PopoverPositioning::getConfiguration($id, $placement, $offset, matchWidth: true);
```

### Animations Not Working

Ensure you're using all transition classes:

```blade
class="{{ $config['base'] }} {{ $config['transition'] }} {{ $config['origin'] }}"
```

## Future Enhancements

Potential future additions:
- Custom fallback strategies
- Smart positioning (auto-detect best placement)
- Arrow/pointer positioning
- Collision detection helpers
- RTL support improvements

## Related Documentation

- [Popover API with Anchor Positioning](../popover-anchor-positioning.md) - User-facing guide
- [Popover Component](../popover.md) - Component usage docs
- [Select Component](../select.md) - Component usage docs
- [Dropdown Component](../dropdown.md) - Component usage docs
