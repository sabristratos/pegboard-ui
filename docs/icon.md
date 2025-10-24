# Icon Component

The Icon component provides a flexible, accessible way to display icons with intelligent fallback behavior and support for both Heroicons and custom SVG icons.

## Features

- **Automatic icon resolution** - Intelligently searches Heroicons first, then custom icons
- **Custom icon support** - Upload your own SVG icons to `resources/icons/`
- **Size presets** - Use semantic size names instead of manual Tailwind classes
- **Accessibility built-in** - Automatic ARIA attributes for decorative and semantic icons
- **Graceful fallbacks** - Never breaks, uses fallback icon when requested icon doesn't exist
- **Developer-friendly errors** - Visual warnings in dev mode when icons are missing

## Basic Usage

```blade
{{-- Simple icon (auto-resolves from Heroicons) --}}
<x-pegboard::icon name="home" />

{{-- With size preset --}}
<x-pegboard::icon name="user" size="lg" />

{{-- With variant (outline, solid, mini, micro) --}}
<x-pegboard::icon name="heart" variant="solid" size="md" />

{{-- With custom classes --}}
<x-pegboard::icon name="star" class="text-yellow-500" />
```

## Size Presets

Instead of manually specifying `class="h-4 w-4"`, use semantic size presets:

| Size | Class Output | Use Case |
|------|-------------|----------|
| `xs` | `h-3 w-3` | Tight inline icons, badges |
| `sm` | `h-4 w-4` | Default button icons, small UI elements |
| `md` | `h-5 w-5` | Standard UI icons, form inputs |
| `lg` | `h-6 w-6` | Headings, prominent actions |
| `xl` | `h-8 w-8` | Feature showcases, empty states |

```blade
<x-pegboard::icon name="check" size="xs" />
<x-pegboard::icon name="trash" size="sm" />
<x-pegboard::icon name="shield" size="md" />
<x-pegboard::icon name="bell" size="lg" />
<x-pegboard::icon name="trophy" size="xl" />
```

## Heroicon Variants

Heroicons come in four variants with different visual weights:

```blade
{{-- Outline (default) - Thin, detailed --}}
<x-pegboard::icon name="academic-cap" variant="outline" />

{{-- Solid - Filled, bold --}}
<x-pegboard::icon name="academic-cap" variant="solid" />

{{-- Mini - 20x20 grid, simplified --}}
<x-pegboard::icon name="academic-cap" variant="mini" />

{{-- Micro - 16x16 grid, minimal --}}
<x-pegboard::icon name="academic-cap" variant="micro" />
```

## Custom Icons

### Setup Custom Icons Directory

Publish the icons directory to your main Laravel app:

```bash
php artisan vendor:publish --tag=pegboard-icons
```

This creates `resources/icons/` in your Laravel application.

### Adding Custom Icons

1. Drop SVG files into `resources/icons/`
2. Icons are **immediately available** - no rebuild needed
3. Use the filename (without `.svg`) as the icon name

```bash
# Example: Add logo.svg to resources/icons/
resources/
  icons/
    logo.svg
    custom-badge.svg
```

```blade
{{-- Auto-resolves: tries heroicon 'logo' first, then custom --}}
<x-pegboard::icon name="logo" size="lg" />

{{-- Explicit custom set --}}
<x-pegboard::icon name="logo" set="custom" size="lg" />
```

### Icon Resolution Order

When you don't specify a `set`, Pegboard searches in this order:

1. **Heroicons** - Checks if Heroicon with that name exists
2. **Custom icons** - Checks `resources/icons/{name}.svg`
3. **Fallback** - Uses `question-mark-circle` icon from config

```blade
{{-- 'home' exists in Heroicons → uses heroicon-o-home --}}
<x-pegboard::icon name="home" />

{{-- 'brand-logo' doesn't exist in Heroicons → uses resources/icons/brand-logo.svg --}}
<x-pegboard::icon name="brand-logo" />

{{-- 'nonexistent' doesn't exist anywhere → uses fallback icon --}}
<x-pegboard::icon name="nonexistent" />
```

### Explicit Set Override

Force a specific icon set:

```blade
{{-- Always use custom, skip Heroicons --}}
<x-pegboard::icon name="logo" set="custom" />

{{-- Always use Heroicons --}}
<x-pegboard::icon name="home" set="heroicon" variant="solid" />
```

## Accessibility

### Decorative Icons

By default, icons are treated as **decorative** and get `aria-hidden="true"`:

```blade
{{-- Decorative icon (default) - hidden from screen readers --}}
<x-pegboard::icon name="sparkles" />
{{-- Renders: aria-hidden="true" --}}
```

### Semantic Icons

For icons that convey meaning without accompanying text, use `aria-label`:

```blade
{{-- Semantic icon with label for screen readers --}}
<button>
    <x-pegboard::icon name="trash" :decorative="false" aria-label="Delete item" />
</button>
{{-- Renders: aria-label="Delete item" role="img" --}}
```

### Best Practices

```blade
{{-- ✅ Good: Icon with text (decorative) --}}
<button>
    <x-pegboard::icon name="plus" size="sm" />
    Add Item
</button>

{{-- ✅ Good: Icon-only button (semantic) --}}
<button>
    <x-pegboard::icon name="pencil" :decorative="false" aria-label="Edit" />
</button>

{{-- ❌ Bad: Icon-only without label --}}
<button>
    <x-pegboard::icon name="pencil" />
</button>
```

## Configuration

Customize icon behavior in `config/pegboard.php`:

```php
'icons' => [
    // Custom icons directory (relative to resources/)
    'custom_path' => 'icons',

    // Fallback icon when requested icon doesn't exist
    'fallback' => 'question-mark-circle',

    // Default Heroicon variant
    'default_variant' => 'outline',

    // Resolution order (tries heroicon first, then custom)
    'resolution_order' => ['heroicon', 'custom'],

    // Size presets
    'sizes' => [
        'xs' => 'h-3 w-3',
        'sm' => 'h-4 w-4',
        'md' => 'h-5 w-5',
        'lg' => 'h-6 w-6',
        'xl' => 'h-8 w-8',
    ],
],
```

### Change Resolution Order

Prefer custom icons over Heroicons:

```php
'resolution_order' => ['custom', 'heroicon'],
```

### Disable Fallback

Set to `null` to disable fallback (will show error in dev mode):

```php
'fallback' => null,
```

### Custom Size Presets

Add your own size presets:

```php
'sizes' => [
    'xs' => 'h-3 w-3',
    'sm' => 'h-4 w-4',
    'md' => 'h-5 w-5',
    'lg' => 'h-6 w-6',
    'xl' => 'h-8 w-8',
    '2xl' => 'h-10 w-10',
    '3xl' => 'h-12 w-12',
],
```

## Error Handling

### Development Mode

When `APP_DEBUG=true`, missing icons show a visual warning:

```blade
<x-pegboard::icon name="doesnt-exist" />
```

Renders a warning triangle with tooltip: "Icon 'doesnt-exist' not found"

### Production Mode

When `APP_DEBUG=false`, missing icons:
- Use the fallback icon silently
- Don't break page rendering
- Don't show error indicators

### Logs

In development mode, warnings are logged when icons aren't found:

```
Icon 'brand-logo' not found, using fallback: question-mark-circle
```

## Complete Example

```blade
{{-- Navigation with mixed icon sources --}}
<nav class="flex gap-4">
    {{-- Heroicon --}}
    <a href="/" class="flex items-center gap-2">
        <x-pegboard::icon name="home" size="sm" />
        Home
    </a>

    {{-- Custom brand icon --}}
    <a href="/about" class="flex items-center gap-2">
        <x-pegboard::icon name="logo" set="custom" size="sm" />
        About
    </a>

    {{-- Icon-only button (semantic) --}}
    <button type="button">
        <x-pegboard::icon
            name="bell"
            variant="solid"
            size="md"
            :decorative="false"
            aria-label="Notifications"
            class="text-primary"
        />
    </button>
</nav>
```

## API Reference

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | required | Icon name (without prefix or extension) |
| `variant` | `string` | `'outline'` | Heroicon variant: `outline`, `solid`, `mini`, `micro` |
| `set` | `string` | `null` | Force icon set: `heroicon`, `custom` (auto-detect if null) |
| `size` | `string` | `null` | Size preset: `xs`, `sm`, `md`, `lg`, `xl` |
| `decorative` | `bool` | `true` | Whether icon is decorative (adds `aria-hidden="true"`) |
| `aria-label` | `string` | `null` | Label for semantic icons (adds `role="img"`) |
| `class` | `string` | `''` | Additional Tailwind classes |

### Attributes

All standard HTML attributes are passed through:

```blade
<x-pegboard::icon
    name="star"
    size="md"
    class="text-yellow-500 animate-pulse"
    data-tooltip="Favorite"
/>
```
