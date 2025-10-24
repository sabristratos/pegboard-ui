# Checkbox Component

A customizable checkbox with validation states, multiple sizes, card variant, and full Livewire compatibility. Built with pure CSS and Tailwind, using native HTML form elements with smooth animations.

## Basic Usage

```blade
<x-pegboard::checkbox.group name="features">
    <x-pegboard::checkbox value="feature1" label="Feature 1" />
    <x-pegboard::checkbox value="feature2" label="Feature 2" />
    <x-pegboard::checkbox value="feature3" label="Feature 3" />
</x-pegboard::checkbox.group>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string\|int | required | Checkbox value |
| `label` | string\|null | `null` | Label text displayed next to checkbox |
| `description` | string\|null | `null` | Description text displayed below label |
| `variant` | string | `'default'` | Validation variant: `'default'`, `'error'`, `'success'` |
| `displayVariant` | string | `'default'` | Display variant: `'default'`, `'card'` |
| `size` | string | `'md'` | Size variant: `'xs'`, `'sm'`, `'md'`, `'lg'` |
| `name` | string\|null | `null` | Form field name (for standalone use) |
| `disabled` | bool | `false` | Disables the checkbox |

## Variants

Checkboxes support three validation variants for visual feedback:

```blade
<!-- Default state -->
<x-pegboard::checkbox.group name="settings">
    <x-pegboard::checkbox variant="default" value="1" label="Enable notifications" />
</x-pegboard::checkbox.group>

<!-- Error state -->
<x-pegboard::checkbox.group name="terms">
    <x-pegboard::checkbox variant="error" value="1" label="I agree to the terms" />
</x-pegboard::checkbox.group>
<p class="text-sm text-destructive mt-1">You must agree to continue</p>

<!-- Success state -->
<x-pegboard::checkbox.group name="verified">
    <x-pegboard::checkbox variant="success" value="1" label="Email verified" />
</x-pegboard::checkbox.group>
<p class="text-sm text-success mt-1">Verification successful</p>
```

## Sizes

Four size options are available to match your design:

```blade
<!-- Extra Small -->
<x-pegboard::checkbox.group name="xs">
    <x-pegboard::checkbox size="xs" value="1" label="XS Checkbox" />
</x-pegboard::checkbox.group>

<!-- Small -->
<x-pegboard::checkbox.group name="sm">
    <x-pegboard::checkbox size="sm" value="1" label="SM Checkbox" />
</x-pegboard::checkbox.group>

<!-- Medium (Default) -->
<x-pegboard::checkbox.group name="md">
    <x-pegboard::checkbox size="md" value="1" label="MD Checkbox" />
</x-pegboard::checkbox.group>

<!-- Large -->
<x-pegboard::checkbox.group name="lg">
    <x-pegboard::checkbox size="lg" value="1" label="LG Checkbox" />
</x-pegboard::checkbox.group>
```

## Display Variants

### Default Variant

The default variant displays the checkbox indicator on the left with label on the right:

```blade
<x-pegboard::checkbox.group name="permissions">
    <x-pegboard::checkbox
        value="read"
        label="Read Access"
        description="View files and folders"
    />
    <x-pegboard::checkbox
        value="write"
        label="Write Access"
        description="Create and modify files"
    />
</x-pegboard::checkbox.group>
```

### Card Variant

The card variant displays as a full-width card with the checkbox indicator on the left. Card variants include hover effects and focus rings for enhanced interactivity:

```blade
<x-pegboard::checkbox.group name="features">
    <x-pegboard::checkbox
        display-variant="card"
        value="analytics"
        label="Analytics Dashboard"
        description="Track your metrics and performance"
    />
    <x-pegboard::checkbox
        display-variant="card"
        value="reports"
        label="Advanced Reports"
        description="Generate detailed PDF reports"
    />
</x-pegboard::checkbox.group>
```

## With Description

Add descriptions to provide additional context:

```blade
<x-pegboard::checkbox.group name="preferences">
    <x-pegboard::checkbox
        value="email_notifications"
        label="Email Notifications"
        description="Receive updates via email"
    />
    <x-pegboard::checkbox
        value="push_notifications"
        label="Push Notifications"
        description="Get alerts on your device"
    />
</x-pegboard::checkbox.group>
```

## Disabled State

Disable checkboxes to make them non-interactive:

```blade
<!-- Disabled unchecked -->
<x-pegboard::checkbox
    value="locked"
    label="Locked Feature"
    disabled
/>

<!-- Disabled checked -->
<x-pegboard::checkbox.group name="features" :value="['required']">
    <x-pegboard::checkbox
        value="required"
        label="Required Feature"
        description="This feature is mandatory"
        disabled
    />
</x-pegboard::checkbox.group>
```

## Form Submission

The Checkbox component works with traditional form submissions and Livewire:

### Traditional Forms

```blade
<form action="/submit" method="POST">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-2">Select Features</label>
        <x-pegboard::checkbox.group name="features[]">
            <x-pegboard::checkbox value="analytics" label="Analytics" />
            <x-pegboard::checkbox value="reports" label="Reports" />
            <x-pegboard::checkbox value="api" label="API Access" />
        </x-pegboard::checkbox.group>
    </div>

    <button type="submit">Submit</button>
</form>
```

### Livewire Integration

```blade
<!-- Two-way binding -->
<x-pegboard::checkbox.group wire:model="selectedFeatures">
    <x-pegboard::checkbox value="analytics" label="Analytics" />
    <x-pegboard::checkbox value="reports" label="Reports" />
    <x-pegboard::checkbox value="api" label="API Access" />
</x-pegboard::checkbox.group>

<!-- Live binding -->
<x-pegboard::checkbox.group wire:model.live="selectedFeatures">
    <x-pegboard::checkbox value="analytics" label="Analytics" />
    <x-pegboard::checkbox value="reports" label="Reports" />
</x-pegboard::checkbox.group>
```

## Standalone Checkbox (Without Group)

You can use checkboxes standalone by providing the `name` prop:

```blade
<x-pegboard::checkbox
    name="terms_accepted"
    value="yes"
    label="I agree to the terms and conditions"
/>
```

## Real-World Examples

### Feature Selection with Cards

```blade
<div class="space-y-3">
    <label class="block text-sm font-medium mb-2">Select Features</label>
    <x-pegboard::checkbox.group wire:model.live="selectedFeatures">
        <x-pegboard::checkbox
            display-variant="card"
            size="lg"
            value="analytics"
            label="Analytics Dashboard"
            description="Track metrics and visualize data"
        />
        <x-pegboard::checkbox
            display-variant="card"
            size="lg"
            value="reports"
            label="Advanced Reports"
            description="Generate detailed PDF reports"
        />
        <x-pegboard::checkbox
            display-variant="card"
            size="lg"
            value="api"
            label="API Access"
            description="RESTful API with authentication"
        />
    </x-pegboard::checkbox.group>
</div>
```

### Permissions Management

```blade
<div class="space-y-3">
    <label class="block text-sm font-medium mb-2">User Permissions</label>
    <x-pegboard::checkbox.group
        wire:model="permissions"
        name="permissions[]"
    >
        <x-pegboard::checkbox
            display-variant="card"
            value="read"
            label="Read Access"
            description="View files and folders"
        />
        <x-pegboard::checkbox
            display-variant="card"
            value="write"
            label="Write Access"
            description="Create and modify files"
        />
        <x-pegboard::checkbox
            display-variant="card"
            value="delete"
            label="Delete Access"
            description="Remove files and folders"
            variant="error"
        />
    </x-pegboard::checkbox.group>
</div>
```

### Newsletter Subscription

```blade
<div>
    <label class="block text-sm font-medium mb-2">Newsletter Preferences</label>
    <x-pegboard::checkbox.group
        wire:model.live="subscriptions"
        name="subscriptions[]"
    >
        <x-pegboard::checkbox
            value="weekly"
            label="Weekly Newsletter"
            description="Receive our weekly digest"
        />
        <x-pegboard::checkbox
            value="product_updates"
            label="Product Updates"
            description="Get notified about new features"
        />
        <x-pegboard::checkbox
            value="promotions"
            label="Promotions & Offers"
            description="Special deals and discounts"
        />
    </x-pegboard::checkbox.group>
</div>
```

### Settings Page

```blade
<div class="max-w-md space-y-4">
    <div>
        <label class="block text-sm font-medium mb-2">Notification Settings</label>
        <x-pegboard::checkbox.group
            wire:model="notifications"
            variant="{{ $errors->has('notifications') ? 'error' : 'default' }}"
        >
            <x-pegboard::checkbox
                display-variant="card"
                value="email"
                label="Email Notifications"
                description="Receive notifications via email"
            />
            <x-pegboard::checkbox
                display-variant="card"
                value="push"
                label="Push Notifications"
                description="Get push notifications on your device"
            />
            <x-pegboard::checkbox
                display-variant="card"
                value="sms"
                label="SMS Notifications"
                description="Receive text message alerts"
            />
        </x-pegboard::checkbox.group>

        @error('notifications')
            <p class="text-sm text-destructive mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
```

### Terms Agreement

```blade
<x-pegboard::checkbox
    name="terms"
    value="accepted"
    variant="{{ $errors->has('terms') ? 'error' : 'default' }}"
>
    <span class="text-sm">
        I agree to the
        <a href="/terms" class="text-primary hover:underline">Terms of Service</a>
        and
        <a href="/privacy" class="text-primary hover:underline">Privacy Policy</a>
    </span>
</x-pegboard::checkbox>

@error('terms')
    <p class="text-sm text-destructive mt-1">{{ $message }}</p>
@enderror
```

### Custom Content (Using Slots)

```blade
<x-pegboard::checkbox.group name="addons">
    <x-pegboard::checkbox display-variant="card" value="premium">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium">Premium Support</div>
                <div class="text-xs text-muted-foreground">24/7 priority assistance</div>
            </div>
            <div class="text-sm font-bold text-primary">+$49/mo</div>
        </div>
    </x-pegboard::checkbox>

    <x-pegboard::checkbox display-variant="card" value="backup">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium">Daily Backups</div>
                <div class="text-xs text-muted-foreground">Automatic data protection</div>
            </div>
            <div class="text-sm font-bold text-primary">+$19/mo</div>
        </div>
    </x-pegboard::checkbox>
</x-pegboard::checkbox.group>
```

## Keyboard Navigation

The Checkbox component supports keyboard navigation:

- **Space/Enter** - Toggle checkbox state
- **Tab** - Move focus to next element
- **Shift+Tab** - Move focus to previous element

## Accessibility

The Checkbox component includes comprehensive accessibility features:

- Proper ARIA attributes
- Keyboard navigation support
- Screen reader friendly
- Clear visual focus states (card variant only)
- Semantic HTML structure
- Proper form associations
- Native HTML checkbox behavior

## Styling

The component uses semantic design tokens from the Pegboard theme system, ensuring consistent appearance across light and dark modes. All variants and sizes automatically adapt to your theme configuration.

### Interactive States

- **Default variant**: No hover effect, minimal styling for clean appearance
- **Card variant**: Includes `hover:bg-muted/50` background effect and focus-visible ring
- **All variants**: Smooth scale and opacity animations on the checkmark icon using `transition-transform-opacity duration-200`
- **Checked state**: Uses `group-has-[:checked]:` pattern for pure CSS state management
- **Disabled state**: Reduced opacity and disabled cursor using `has-[:disabled]:` variant

### Technical Implementation

This component follows Pegboard's design principles:

1. **Modern HTML/CSS First**: Uses native `<input type="checkbox">` with CSS pseudo-classes (`:checked`, `:disabled`, `:focus-visible`)
2. **No JavaScript**: Pure Tailwind CSS implementation using `group-has-[:checked]:` for state management
3. **Smooth Animations**: Check icon animates with `scale-0 opacity-0` → `scale-100 opacity-100` transitions
4. **Livewire Compatible**: DOM-based approach works seamlessly with `wire:model` binding
