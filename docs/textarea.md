# Textarea Component

A flexible textarea component with optional clear, copy, and loading features for multi-line text input.

## Features

- Configurable row height
- Clearable with X button
- Copy to clipboard functionality
- Loading state with spinner
- Resizable (vertical resize enabled by default)
- Alpine.js-powered actions
- Data attribute-driven styling
- Works with Livewire wire:model

## Basic Usage

```blade
{{-- Simple textarea --}}
<x-pegboard::textarea placeholder="Enter your message" />

{{-- Custom rows --}}
<x-pegboard::textarea :rows="6" placeholder="Write something..." />

{{-- With name for form submission --}}
<x-pegboard::textarea
    name="description"
    placeholder="Product description"
/>

{{-- With Livewire wire:model --}}
<x-pegboard::textarea
    wire:model.live="comment"
    placeholder="Your comment"
/>

{{-- With attributes --}}
<x-pegboard::textarea
    name="bio"
    required
    maxlength="500"
    placeholder="Tell us about yourself"
/>

{{-- Pre-filled content --}}
<x-pegboard::textarea>
    This is pre-filled content.
</x-pegboard::textarea>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `rows` | int | `4` | Number of visible text rows |
| `clearable` | bool | `false` | Show clear button (X icon) when textarea has value |
| `copyable` | bool | `false` | Show copy to clipboard button |
| `loading` | bool | `false` | Show loading spinner and disable textarea |

## Built-in Features

### Clearable Textarea

Show a clear button that appears when textarea has content:

```blade
<x-pegboard::textarea
    :clearable="true"
    placeholder="Type to see clear button"
/>
```

**Behavior:**
- Clear button shows only when textarea has content (using Alpine.js `x-show="$refs.textarea.value"`)
- Clicking clear button empties the textarea
- Works with both Alpine.js and Livewire `wire:model`
- Button positioned absolutely in top-right corner

### Copy to Clipboard

Copy textarea content to clipboard with visual feedback:

```blade
<x-pegboard::textarea
    :copyable="true"
    placeholder="Content will be copyable"
>
Default content to copy
</x-pegboard::textarea>
```

**Behavior:**
- Shows clipboard icon by default
- Shows check icon for 2 seconds after successful copy
- Updates aria-label from "Copy to clipboard" to "Copied!"
- Uses Clipboard API for modern browsers
- Button positioned absolutely in top-right corner

### Loading State

Show loading spinner and disable textarea:

```blade
{{-- PHP-driven loading state --}}
<x-pegboard::textarea :loading="true" placeholder="Saving..." />

{{-- With Livewire wire:loading --}}
<x-pegboard::textarea
    wire:model="notes"
    wire:loading.delay.attr="loading"
    wire:target="saveNotes"
    placeholder="Enter notes"
/>
```

**Loading State Features:**
- Shows spinner in top-right corner
- Automatically disables textarea
- Adds `aria-busy="true"` for accessibility
- Spinner appears before clear/copy buttons

### Action Button Layout

When multiple features are enabled, buttons are arranged right-to-left:

```blade
<x-pegboard::textarea
    :loading="true"
    :clearable="true"
    :copyable="true"
>
```

**Button Order (right-to-left):**
1. Copy button (if `copyable="true"`)
2. Clear button (if `clearable="true"` and has content)
3. Loading spinner (if `loading="true"`)

All buttons positioned absolutely in `top-2 right-2` with `gap-2` spacing.

## Row Configuration

Control textarea height with the `rows` prop:

```blade
{{-- Small: 4 rows (default) --}}
<x-pegboard::textarea :rows="4" />

{{-- Medium: 6 rows --}}
<x-pegboard::textarea :rows="6" />

{{-- Large: 10 rows --}}
<x-pegboard::textarea :rows="10" />
```

**Note:** Textarea has `resize-y` class enabled by default, allowing users to resize vertically.

## Resizing

The textarea is vertically resizable by default:

```blade
{{-- Default: vertical resize enabled --}}
<x-pegboard::textarea />

{{-- Disable resize --}}
<x-pegboard::textarea class="!resize-none" />

{{-- Allow both directions --}}
<x-pegboard::textarea class="!resize" />
```

## Alpine.js Component

The textarea uses a simple Alpine.js component for actions:

```typescript
Alpine.data('pegboardTextarea', () => ({
    copied: false,

    clear() {
        this.$refs.textarea.value = '';
        this.$refs.textarea.focus();
    },

    async copy() {
        const text = this.$refs.textarea.value;
        await navigator.clipboard.writeText(text);
        this.copied = true;
        setTimeout(() => this.copied = false, 2000);
    }
}));
```

**Why no x-model:**
- Avoids conflicts with Livewire `wire:model`
- Reads/writes values directly from DOM element
- Works with both Alpine.js and Livewire

## Data Attribute Architecture

The Textarea component uses data attributes for CSS targeting:

```blade
<div data-pegboard-group-item>
    <textarea data-pegboard-control />
</div>
```

**Data Attributes:**
- `data-pegboard-group-item` - Identifies component for layout purposes
- `data-pegboard-control` - Identifies as a form control for styling/targeting

**Benefits:**
- CSS can target specific elements (e.g., `.form-group [data-pegboard-control]`)
- Consistent with Pegboard architecture

## Attribute Behavior

All attributes merge directly onto the `<textarea>` element:

```blade
{{-- Standard textarea attributes --}}
<x-pegboard::textarea
    name="content"
    required
    maxlength="1000"
    placeholder="Max 1000 characters"
    class="w-full"
/>
```

**Common Attributes:**
- `name` - Form input name
- `required` - Mark as required field
- `maxlength` - Maximum character limit
- `placeholder` - Placeholder text
- `disabled` - Disable textarea
- `readonly` - Make read-only
- `class` - Custom CSS classes (merged with base)

## Form Submission

Works like a standard textarea for form submission:

```blade
<form method="POST" action="/save">
    @csrf
    <x-pegboard::textarea
        name="description"
        required
        placeholder="Enter description"
    />

    <button type="submit">Save</button>
</form>
```

## Livewire Integration

Works seamlessly with Livewire wire:model:

```blade
{{-- Live updates --}}
<x-pegboard::textarea
    wire:model.live="comment"
    :clearable="true"
    placeholder="Your comment"
/>

{{-- Update on blur --}}
<x-pegboard::textarea
    wire:model.blur="notes"
    placeholder="Notes"
/>

{{-- With character counter (Livewire) --}}
<div>
    <x-pegboard::textarea
        wire:model.live="bio"
        maxlength="500"
        :rows="6"
    />
    <p class="text-sm text-muted-foreground mt-1">
        {{ strlen($bio) }} / 500 characters
    </p>
</div>
```

## Customization

Pass custom classes that merge with base styles:

```blade
{{-- Custom width --}}
<x-pegboard::textarea class="w-full max-w-2xl" />

{{-- Custom height (override rows) --}}
<x-pegboard::textarea class="!h-64" />

{{-- Disable resize --}}
<x-pegboard::textarea class="!resize-none" />

{{-- Custom border/shadow --}}
<x-pegboard::textarea class="!border-2 !border-primary !shadow-lg" />
```

## Styling System

Textarea uses comprehensive base classes:

```php
$baseClasses = 'w-full rounded-md border border-border bg-input px-3 py-2 text-sm text-foreground placeholder:text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-y';
```

**Key Classes:**
- `w-full` - Full width by default
- `rounded-md` - Rounded corners
- `border border-border` - Semantic border color
- `bg-input` - Semantic background color
- `focus-visible:ring-2` - Focus ring for keyboard navigation
- `disabled:opacity-50` - Visual feedback when disabled
- `resize-y` - Vertical resize enabled

## Accessibility

- Uses semantic `<textarea>` element
- Action buttons include proper `aria-label` attributes
- Copy button updates aria-label on success
- Loading state adds `disabled` and `aria-busy="true"` attributes
- Focus visible ring with offset for keyboard navigation
- Works without JavaScript (except action buttons)
- Proper contrast ratios for text and placeholders

## Use Cases

**Comment forms:**
```blade
<x-pegboard::textarea
    wire:model="comment"
    :rows="4"
    :clearable="true"
    placeholder="Write a comment..."
/>
```

**Code snippets:**
```blade
<x-pegboard::textarea
    :copyable="true"
    :rows="10"
    class="font-mono text-xs"
    placeholder="Paste your code here"
/>
```

**Long-form content:**
```blade
<x-pegboard::textarea
    name="article_content"
    :rows="20"
    :clearable="true"
    required
    placeholder="Write your article..."
/>
```

**Auto-saving notes:**
```blade
<x-pegboard::textarea
    wire:model.live.debounce.500ms="notes"
    wire:loading.attr="loading"
    :rows="8"
    placeholder="Your notes (auto-saved)"
/>
```
