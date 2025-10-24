# Alert Component

A flexible alert component for displaying important messages with visual variants and optional icons.

## Features

- 5 semantic variants (success, warning, danger, info, neutral)
- Optional icons with variant-specific defaults
- Optional title/heading

## Basic Usage

```blade
{{-- Simple alert --}}
<x-pegboard::alert variant="success">
    Your changes have been saved successfully.
</x-pegboard::alert>

{{-- With title --}}
<x-pegboard::alert variant="warning" title="Warning">
    This action cannot be undone.
</x-pegboard::alert>

{{-- Without icon --}}
<x-pegboard::alert variant="info" :show-icon="false">
    This is an informational message.
</x-pegboard::alert>

{{-- Custom icon --}}
<x-pegboard::alert variant="danger" icon="fire">
    Critical system alert!
</x-pegboard::alert>

{{-- Custom styling --}}
<x-pegboard::alert variant="success" class="my-4 !border-2">
    Custom styled alert with merged classes.
</x-pegboard::alert>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'info'` | Visual variant: `success`, `warning`, `danger`, `info`, `neutral` |
| `icon` | string\|null | `null` | Custom icon name (overrides default) |
| `title` | string\|null | `null` | Optional heading text |
| `showIcon` | bool | `true` | Whether to display the icon |

## Variants

### Success
Green theme for successful operations:
```blade
<x-pegboard::alert variant="success">
    Profile updated successfully!
</x-pegboard::alert>
```

### Warning
Yellow/orange theme for warnings:
```blade
<x-pegboard::alert variant="warning">
    Your trial expires in 3 days.
</x-pegboard::alert>
```

### Danger
Red theme for errors:
```blade
<x-pegboard::alert variant="danger">
    Failed to save changes.
</x-pegboard::alert>
```

### Info
Blue theme for informational messages:
```blade
<x-pegboard::alert variant="info">
    New features are now available.
</x-pegboard::alert>
```

### Neutral
Gray theme for neutral messages:
```blade
<x-pegboard::alert variant="neutral">
    This is a general notice.
</x-pegboard::alert>
```

## Customization

Pass custom classes that merge with base styles:

```blade
<x-pegboard::alert
    variant="success"
    class="my-8 shadow-xl"
>
    Classes are merged, not replaced!
</x-pegboard::alert>
```

## Accessibility

- Uses semantic HTML
- Icons are decorative (text provides full context)
- Proper color contrast ratios
- Works without JavaScript
