# Textarea Component

A flexible, multi-line text input component with validation states, interactive features, and full Livewire compatibility.

## Basic Usage

```blade
<x-pegboard::textarea placeholder="Enter your message..." />
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Visual variant: `'default'`, `'error'`, `'success'` |
| `size` | string | `'md'` | Size variant: `'xs'`, `'sm'`, `'md'`, `'lg'` |
| `rows` | int | `4` | Number of visible text rows |
| `clearable` | bool | `false` | Shows a clear button when textarea has content |
| `copy` | bool | `false` | Shows a copy-to-clipboard button |
| `disabled` | bool | `false` | Disables the textarea |
| `placeholder` | string | `''` | Placeholder text |

## Variants

Textareas support three validation variants for visual feedback:

```blade
<!-- Default state -->
<x-pegboard::textarea variant="default" placeholder="Enter text..." />

<!-- Error state -->
<x-pegboard::textarea variant="error" placeholder="Invalid content">
    This message is too short
</x-pegboard::textarea>

<!-- Success state -->
<x-pegboard::textarea variant="success" placeholder="Valid content">
    This is a valid message that meets all requirements.
</x-pegboard::textarea>
```

## Sizes

Four size options are available to match your design:

```blade
<!-- Extra Small -->
<x-pegboard::textarea size="xs" rows="3" placeholder="Extra small..." />

<!-- Small -->
<x-pegboard::textarea size="sm" rows="3" placeholder="Small..." />

<!-- Medium (Default) -->
<x-pegboard::textarea size="md" rows="4" placeholder="Medium..." />

<!-- Large -->
<x-pegboard::textarea size="lg" rows="5" placeholder="Large..." />
```

## Interactive Features

### Clearable

Add a clear button that appears when the textarea has content:

```blade
<x-pegboard::textarea clearable placeholder="Type something...">
    Clear this content by clicking the X button!
</x-pegboard::textarea>
```

### Copy to Clipboard

Enable copy-to-clipboard functionality with success feedback:

```blade
<x-pegboard::textarea copy placeholder="Content to copy">
    Click the clipboard icon to copy this text!
</x-pegboard::textarea>
```

### Combined Features

You can combine multiple features:

```blade
<x-pegboard::textarea clearable copy placeholder="Combined features">
    This textarea has both clear and copy actions enabled.
</x-pegboard::textarea>
```

## Disabled State

Disable the textarea to make it read-only:

```blade
<!-- Disabled empty -->
<x-pegboard::textarea disabled placeholder="Cannot edit..." />

<!-- Disabled with content -->
<x-pegboard::textarea disabled>
    This is read-only content.
</x-pegboard::textarea>

<!-- Disabled with validation state -->
<x-pegboard::textarea disabled variant="error">
    This content has errors but is locked for editing.
</x-pegboard::textarea>
```

## Livewire Integration

The Textarea component is fully compatible with Livewire's `wire:model`:

```blade
<!-- Two-way binding -->
<x-pegboard::textarea wire:model="comment" placeholder="Your comment..." />

<!-- Live binding -->
<x-pegboard::textarea wire:model.live="message" placeholder="Live updates..." />

<!-- Debounced binding -->
<x-pegboard::textarea wire:model.live.debounce.500ms="content" placeholder="Debounced..." />
```

The component will work seamlessly with or without Livewire - it reads and writes directly to the DOM, ensuring compatibility in all scenarios.

## Real-World Examples

### Comment Form

```blade
<div>
    <label class="block text-sm font-medium mb-2">Your Comment</label>
    <x-pegboard::textarea
        wire:model="comment"
        rows="4"
        clearable
        placeholder="Share your thoughts..."
    />
</div>
```

### Code Snippet with Copy

```blade
<div>
    <label class="block text-sm font-medium mb-2">Code</label>
    <x-pegboard::textarea size="sm" rows="6" copy>
function greet(name) {
    return `Hello, ${name}!`;
}

console.log(greet('World'));
    </x-pegboard::textarea>
</div>
```

### Feedback Form with Validation

```blade
<div class="space-y-4">
    <!-- Positive feedback -->
    <div>
        <label class="block text-sm font-medium mb-2">What did you like?</label>
        <x-pegboard::textarea
            variant="success"
            rows="3"
            clearable
            placeholder="Tell us what worked well..."
        >
            The user interface is clean and intuitive!
        </x-pegboard::textarea>
        <p class="text-sm text-success mt-1">Thank you for the positive feedback!</p>
    </div>

    <!-- Improvement suggestions -->
    <div>
        <label class="block text-sm font-medium mb-2">What could be improved?</label>
        <x-pegboard::textarea
            variant="error"
            rows="3"
            clearable
            placeholder="Tell us what could be better..."
        >
            Loading times could be faster
        </x-pegboard::textarea>
        <p class="text-sm text-destructive mt-1">Please provide more specific details</p>
    </div>
</div>
```

### Product Description

```blade
<div>
    <label class="block text-sm font-medium mb-2">Description</label>
    <x-pegboard::textarea
        wire:model="product.description"
        size="lg"
        rows="8"
        clearable
        copy
        placeholder="Enter product description..."
    >
        Premium wireless headphones with active noise cancellation,
        30-hour battery life, and crystal-clear audio quality.
    </x-pegboard::textarea>
</div>
```

## Accessibility

The Textarea component includes proper accessibility features:

- Semantic `<textarea>` element
- Proper ARIA labels for action buttons
- Keyboard navigation support
- Clear visual focus states
- Screen reader friendly

## Styling

The component uses semantic design tokens from the Pegboard theme system, ensuring consistent appearance across light and dark modes. All variants automatically adapt to your theme configuration.
