# Input Component

A versatile input component with multiple variants, sizes, interactive features, and support for prefixes/suffixes. Built with Tailwind CSS v4 and fully compatible with Livewire.

## Features

- ✅ Three validation variants (default, error, success)
- ✅ Four sizes (xs, sm, md, lg)
- ✅ Left and right icon support
- ✅ Prefix and suffix slots (e.g., "$", "https://", "%")
- ✅ Clearable input with X button
- ✅ Password visibility toggle
- ✅ Copy to clipboard (1-second success feedback)
- ✅ Open URL in new tab
- ✅ Disabled state
- ✅ Number input spinners hidden by default
- ✅ Full TypeScript definitions
- ✅ Livewire compatible (DOM-based state)
- ✅ Theme-aware (auto light/dark mode)

---

## Basic Usage

```blade
<x-pegboard::input placeholder="Enter your email..." />
```

---

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'default'` | Visual style: `default`, `error`, `success` |
| `size` | `string` | `'md'` | Input size: `xs`, `sm`, `md`, `lg` |
| `icon` | `string` | `null` | Heroicon name to display on the left |
| `iconRight` | `string` | `null` | Heroicon name to display on the right |
| `iconVariant` | `string` | Auto | Icon variant (auto-selected: xs=micro, default=mini) |
| `clearable` | `bool` | `false` | Show clear button when input has value |
| `showPassword` | `bool` | `false` | Show password visibility toggle (for password inputs) |
| `copy` | `bool` | `false` | Show copy to clipboard button (feedback shows for 1 second) |
| `viewInNewPage` | `bool` | `false` | Show "open in new tab" button (for URL inputs) |
| `disabled` | `bool` | `false` | Disable the input |

### Slots

| Slot | Description |
|------|-------------|
| `prefix` | Text/content displayed before the input (e.g., "$", "https://") |
| `suffix` | Text/content displayed after the input (e.g., ".com", "%") |
| `actions` | Custom action buttons between input and built-in actions |

All standard HTML input attributes are supported via `$attributes` (e.g., `type`, `name`, `value`, `placeholder`, `wire:model`, etc.).

---

## Variants

### Default
Standard input style for regular form fields.

```blade
<x-pegboard::input placeholder="Enter text..." />
```

### Error
Red border and background tint for validation errors.

```blade
<x-pegboard::input variant="error" value="invalid@" />
<p class="text-sm text-destructive mt-1">Invalid email format</p>
```

### Success
Green border and background tint for successful validation.

```blade
<x-pegboard::input variant="success" value="valid@email.com" />
<p class="text-sm text-success mt-1">Email is valid</p>
```

---

## Sizes

```blade
<x-pegboard::input size="xs" placeholder="Extra small..." />
<x-pegboard::input size="sm" placeholder="Small..." />
<x-pegboard::input size="md" placeholder="Medium (default)..." />
<x-pegboard::input size="lg" placeholder="Large..." />
```

**Note:** Placeholder text automatically scales with input size.

---

## Icons

### Icon on the Left

```blade
<x-pegboard::input icon="envelope" placeholder="Enter email..." />
<x-pegboard::input icon="user" placeholder="Username..." />
<x-pegboard::input icon="magnifying-glass" placeholder="Search..." />
```

### Icon on the Right

```blade
<x-pegboard::input iconRight="check-circle" placeholder="Verified field..." />
<x-pegboard::input iconRight="arrow-right" placeholder="Next step..." />
```

### Both Icons

```blade
<x-pegboard::input
    icon="user"
    iconRight="check-circle"
    placeholder="Username..."
/>
```

---

## Prefix & Suffix

Add static text before or after the input value.

### URL Prefix

```blade
<x-pegboard::input placeholder="yoursite.com">
    <x-slot:prefix>https://</x-slot:prefix>
</x-pegboard::input>
```

### Currency (Prefix & Suffix)

```blade
<x-pegboard::input placeholder="0.00" type="number">
    <x-slot:prefix>$</x-slot:prefix>
    <x-slot:suffix>USD</x-slot:suffix>
</x-pegboard::input>
```

### Username Prefix

```blade
<x-pegboard::input placeholder="username">
    <x-slot:prefix>@</x-slot:prefix>
</x-pegboard::input>
```

### Domain Suffix

```blade
<x-pegboard::input placeholder="mysite">
    <x-slot:suffix>.com</x-slot:suffix>
</x-pegboard::input>
```

### Percentage Suffix

```blade
<x-pegboard::input placeholder="0" type="number">
    <x-slot:suffix>%</x-slot:suffix>
</x-pegboard::input>
```

### Weight/Measurement Suffix

```blade
<x-pegboard::input placeholder="0" type="number">
    <x-slot:suffix>kg</x-slot:suffix>
</x-pegboard::input>
```

**Styling:**
- Prefix/suffix uses muted text color to differentiate from user input
- Text is not selectable (`select-none`)
- Positioned inside the input wrapper for cohesive appearance

---

## Interactive Features

### Clearable

Shows an X button when the input has a value. Clicking clears the input and refocuses it.

```blade
<x-pegboard::input clearable placeholder="Type something..." />
```

**How it works:**
- Only visible when input has content
- Clears value on click
- Refocuses input after clearing
- Dispatches `input` event (Livewire compatible)

---

### Password Toggle

Shows an eye icon to toggle password visibility for password inputs.

```blade
<x-pegboard::input
    type="password"
    showPassword
    placeholder="Enter password..."
/>
```

**Icons:**
- Eye icon when password is hidden
- Eye-slash icon when password is visible
- Toggles input type between `password` and `text`

---

### Copy to Clipboard

Shows a clipboard icon that copies the input value to the clipboard.

```blade
<x-pegboard::input
    copy
    value="sk_test_1234567890"
    placeholder="API Key"
/>
```

**Feedback:**
- Icon changes from clipboard to checkmark for 1 second
- Button turns green during success state
- Automatically resets after 1 second

**Note:** Requires HTTPS or localhost for clipboard API to work.

---

### Open in New Tab

Shows a link icon that opens the input value as a URL in a new tab.

```blade
<x-pegboard::input
    viewInNewPage
    value="https://github.com"
    placeholder="Enter URL..."
/>
```

**Validation:**
- Only visible when input contains a valid URL
- Validates URL format before showing
- Opens in new tab with `rel="noopener noreferrer"`

---

## Combining Features

You can combine multiple features together:

### Email with Icon and Clear

```blade
<x-pegboard::input
    icon="envelope"
    clearable
    placeholder="john@example.com"
/>
```

### URL with All Actions

```blade
<x-pegboard::input
    icon="link"
    clearable
    copy
    viewInNewPage
    placeholder="https://..."
    value="https://tailwindcss.com"
/>
```

### Search with Icon and Clear

```blade
<x-pegboard::input
    icon="magnifying-glass"
    clearable
    size="lg"
    placeholder="Search products..."
/>
```

### API Key with Icon and Copy

```blade
<x-pegboard::input
    icon="key"
    copy
    value="pk_live_abc123xyz789"
/>
```

---

## Disabled State

```blade
<x-pegboard::input disabled placeholder="Cannot edit..." />
<x-pegboard::input disabled value="Read-only value" />
<x-pegboard::input disabled icon="lock-closed" placeholder="Locked field" />
```

**Styling:**
- Wrapper has reduced opacity and disabled cursor
- Input element gets `disabled` attribute
- Cursor changes to `not-allowed`

---

## Number Inputs

Number input spinners (up/down arrows) are hidden by default for a cleaner look.

```blade
<x-pegboard::input type="number" placeholder="0">
    <x-slot:prefix>$</x-slot:prefix>
</x-pegboard::input>
```

**Features:**
- No visible spinner arrows
- Users can still type numbers
- Keyboard arrow keys still increment/decrement
- Works across all browsers

---

## Livewire Integration

The Input component is fully compatible with Livewire using DOM-based state management.

### Basic Wire:model

```blade
<x-pegboard::input
    wire:model="email"
    placeholder="Enter email..."
/>
```

### With Validation States

```blade
<x-pegboard::input
    wire:model.blur="email"
    :variant="$errors->has('email') ? 'error' : ($this->emailVerified ? 'success' : 'default')"
    icon="envelope"
    placeholder="Enter email..."
/>

@error('email')
    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
@enderror
```

### With Interactive Features

```blade
<x-pegboard::input
    wire:model.live.debounce.300ms="search"
    icon="magnifying-glass"
    clearable
    placeholder="Search..."
/>
```

**Important:** The clearable button dispatches an `input` event, so Livewire will pick up changes automatically.

---

## Real-World Examples

### Login Form

```blade
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium mb-2">Email</label>
        <x-pegboard::input
            icon="envelope"
            type="email"
            name="email"
            placeholder="john@example.com"
        />
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Password</label>
        <x-pegboard::input
            icon="lock-closed"
            type="password"
            showPassword
            name="password"
            placeholder="Enter password..."
        />
    </div>
</div>
```

### Search Bar

```blade
<x-pegboard::input
    icon="magnifying-glass"
    clearable
    size="lg"
    placeholder="Search for products, articles, or documentation..."
/>
```

### Settings Form

```blade
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium mb-2">Website URL</label>
        <x-pegboard::input
            icon="globe-alt"
            viewInNewPage
            clearable
            placeholder="https://yoursite.com"
        />
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">API Key</label>
        <x-pegboard::input
            icon="key"
            copy
            type="text"
            value="sk_test_1234567890abcdef"
        />
    </div>
</div>
```

### Price Input

```blade
<x-pegboard::input type="number" placeholder="0.00">
    <x-slot:prefix>$</x-slot:prefix>
    <x-slot:suffix>USD</x-slot:suffix>
</x-pegboard::input>
```

### Percentage Input

```blade
<label class="block text-sm font-medium mb-2">Discount</label>
<x-pegboard::input type="number" placeholder="0">
    <x-slot:suffix>%</x-slot:suffix>
</x-pegboard::input>
```

---

## TypeScript Definitions

The Input component includes full TypeScript definitions:

```typescript
export type InputVariant = 'default' | 'error' | 'success';
export type InputSize = 'xs' | 'sm' | 'md' | 'lg';

export interface InputProps {
    variant?: InputVariant;
    size?: InputSize;
    icon?: string;
    iconRight?: string;
    iconVariant?: string;
    prefix?: string;
    suffix?: string;
    clearable?: boolean;
    showPassword?: boolean;
    copy?: boolean;
    viewInNewPage?: boolean;
    disabled?: boolean;
}
```

---

## Accessibility

The Input component follows accessibility best practices:

- **Semantic HTML:** Uses native `<input>` element
- **ARIA Labels:** Action buttons include descriptive `aria-label` attributes
- **Keyboard Support:** All interactive features work with keyboard navigation
- **Focus Management:** Clear button refocuses input after clearing
- **Screen Readers:** Prefix/suffix text is readable by screen readers
- **Disabled State:** Properly sets `disabled` attribute and visual indicators

---

## Styling & Theming

The Input component uses semantic design tokens from Tailwind v4's `@theme` block:

```css
/* Variant colors */
border-border, bg-input (default)
border-destructive, bg-destructive/5 (error)
border-success, bg-success/5 (success)

/* Text colors */
text-foreground (input value)
text-muted-foreground (placeholder, prefix, suffix, icons)
text-success (copy button when copied)

/* Transitions */
duration-fast (150ms)
```

### Custom Styling

You can add custom classes via the standard `class` attribute (applies to wrapper):

```blade
<x-pegboard::input class="w-full max-w-md" placeholder="Custom width..." />
<x-pegboard::input class="shadow-lg" placeholder="Custom shadow..." />
```

---

## Component Files

- **PHP Class:** `packages/stratos/pegboard/src/View/Components/Input.php`
- **Blade Template:** `packages/stratos/pegboard/resources/views/components/input.blade.php`
- **TypeScript Logic:** `packages/stratos/pegboard/resources/js/components/input.ts`
- **TypeScript Types:** `packages/stratos/pegboard/resources/js/types/components.ts`

---

## Browser Compatibility

- **Chrome/Edge:** Full support
- **Safari:** Full support
- **Firefox:** Full support
- **Number spinners:** Hidden across all browsers
- **Clipboard API:** Requires HTTPS or localhost

---

## Notes

- Prefix/suffix slots are optional and can be used independently or together
- Icons auto-scale with input size (xs=micro, default=mini)
- Copy feedback duration is 1 second (not configurable)
- URL validation uses native JavaScript `URL()` constructor
- Number input spinners are hidden using CSS for a cleaner appearance
- All interactive features work with both mouse and keyboard
- Component is fully reactive with Livewire without requiring Alpine `x-model`
