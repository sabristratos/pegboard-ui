# Radio Component

A customizable radio button with validation states, multiple sizes, card variant, and full Livewire compatibility. Built with pure CSS and Tailwind, using native HTML form elements with smooth animations.

## Basic Usage

```blade
<x-pegboard::radio.group name="plan">
    <x-pegboard::radio value="basic" label="Basic Plan" />
    <x-pegboard::radio value="pro" label="Pro Plan" />
    <x-pegboard::radio value="enterprise" label="Enterprise Plan" />
</x-pegboard::radio.group>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string\|int | required | Radio button value |
| `label` | string\|null | `null` | Label text displayed next to radio |
| `description` | string\|null | `null` | Description text displayed below label |
| `variant` | string | `'default'` | Validation variant: `'default'`, `'error'`, `'success'` |
| `displayVariant` | string | `'default'` | Display variant: `'default'`, `'card'` |
| `size` | string | `'md'` | Size variant: `'xs'`, `'sm'`, `'md'`, `'lg'` |
| `name` | string\|null | `null` | Form field name (for standalone use) |
| `disabled` | bool | `false` | Disables the radio button |

## Variants

Radio buttons support three validation variants for visual feedback:

```blade
<!-- Default state -->
<x-pegboard::radio.group name="status">
    <x-pegboard::radio variant="default" value="1" label="Active" />
</x-pegboard::radio.group>

<!-- Error state -->
<x-pegboard::radio.group name="status">
    <x-pegboard::radio variant="error" value="1" label="Invalid Option" />
</x-pegboard::radio.group>
<p class="text-sm text-destructive mt-1">Please select a valid option</p>

<!-- Success state -->
<x-pegboard::radio.group name="status">
    <x-pegboard::radio variant="success" value="1" label="Verified" />
</x-pegboard::radio.group>
<p class="text-sm text-success mt-1">Selection confirmed</p>
```

## Sizes

Four size options are available to match your design:

```blade
<!-- Extra Small -->
<x-pegboard::radio.group name="xs">
    <x-pegboard::radio size="xs" value="1" label="XS Radio" />
</x-pegboard::radio.group>

<!-- Small -->
<x-pegboard::radio.group name="sm">
    <x-pegboard::radio size="sm" value="1" label="SM Radio" />
</x-pegboard::radio.group>

<!-- Medium (Default) -->
<x-pegboard::radio.group name="md">
    <x-pegboard::radio size="md" value="1" label="MD Radio" />
</x-pegboard::radio.group>

<!-- Large -->
<x-pegboard::radio.group name="lg">
    <x-pegboard::radio size="lg" value="1" label="LG Radio" />
</x-pegboard::radio.group>
```

## Display Variants

### Default Variant

The default variant displays the radio indicator on the left with label on the right:

```blade
<x-pegboard::radio.group name="plan">
    <x-pegboard::radio
        value="basic"
        label="Basic Plan"
        description="Essential features for individuals"
    />
    <x-pegboard::radio
        value="pro"
        label="Pro Plan"
        description="Advanced features for professionals"
    />
</x-pegboard::radio.group>
```

### Card Variant

The card variant displays as a full-width card with the radio indicator on the right. Card variants include hover effects and focus rings for enhanced interactivity:

```blade
<x-pegboard::radio.group name="plan">
    <x-pegboard::radio
        display-variant="card"
        value="basic"
        label="Basic Plan"
        description="Essential features for individuals"
    />
    <x-pegboard::radio
        display-variant="card"
        value="pro"
        label="Pro Plan"
        description="Advanced features for professionals"
    />
</x-pegboard::radio.group>
```

## With Description

Add descriptions to provide additional context:

```blade
<x-pegboard::radio.group name="subscription">
    <x-pegboard::radio
        value="monthly"
        label="Monthly Billing"
        description="Pay month-to-month with no commitment"
    />
    <x-pegboard::radio
        value="yearly"
        label="Annual Billing"
        description="Save 20% with annual payment"
    />
</x-pegboard::radio.group>
```

## Disabled State

Disable radio buttons to make them non-selectable:

```blade
<!-- Disabled radio -->
<x-pegboard::radio.group name="plan">
    <x-pegboard::radio value="basic" label="Basic Plan" />
    <x-pegboard::radio value="pro" label="Pro Plan" disabled />
    <x-pegboard::radio value="enterprise" label="Enterprise Plan" />
</x-pegboard::radio.group>
```

## Form Submission

The Radio component works with traditional form submissions and Livewire:

### Traditional Forms

```blade
<form action="/submit" method="POST">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-2">Select Plan</label>
        <x-pegboard::radio.group name="plan">
            <x-pegboard::radio value="basic" label="Basic" />
            <x-pegboard::radio value="pro" label="Pro" />
            <x-pegboard::radio value="enterprise" label="Enterprise" />
        </x-pegboard::radio.group>
    </div>

    <button type="submit">Submit</button>
</form>
```

### Livewire Integration

```blade
<!-- Two-way binding -->
<x-pegboard::radio.group wire:model="selectedPlan">
    <x-pegboard::radio value="basic" label="Basic" />
    <x-pegboard::radio value="pro" label="Pro" />
    <x-pegboard::radio value="enterprise" label="Enterprise" />
</x-pegboard::radio.group>

<!-- Live binding -->
<x-pegboard::radio.group wire:model.live="selectedPlan">
    <x-pegboard::radio value="basic" label="Basic" />
    <x-pegboard::radio value="pro" label="Pro" />
</x-pegboard::radio.group>
```

## Standalone Radio (Without Group)

You can use radio buttons standalone by providing the `name` prop:

```blade
<x-pegboard::radio
    name="agreement"
    value="yes"
    label="I agree to the terms and conditions"
/>
```

## Real-World Examples

### Plan Selection with Cards

```blade
<div class="space-y-3">
    <label class="block text-sm font-medium mb-2">Choose Your Plan</label>
    <x-pegboard::radio.group wire:model.live="selectedPlan">
        <x-pegboard::radio
            display-variant="card"
            size="lg"
            value="basic"
            label="Basic Plan"
            description="Perfect for individuals - $9/month"
        />
        <x-pegboard::radio
            display-variant="card"
            size="lg"
            value="pro"
            label="Pro Plan"
            description="For professionals - $29/month"
        />
        <x-pegboard::radio
            display-variant="card"
            size="lg"
            value="enterprise"
            label="Enterprise Plan"
            description="For organizations - Contact us"
        />
    </x-pegboard::radio.group>
</div>
```

### Payment Method Selection

```blade
<div class="space-y-3">
    <label class="block text-sm font-medium mb-2">Payment Method</label>
    <x-pegboard::radio.group
        wire:model="paymentMethod"
        name="payment_method"
    >
        <x-pegboard::radio
            display-variant="card"
            value="credit_card"
            label="Credit Card"
            description="Pay with Visa, Mastercard, or American Express"
        />
        <x-pegboard::radio
            display-variant="card"
            value="paypal"
            label="PayPal"
            description="Fast and secure payment with your PayPal account"
        />
        <x-pegboard::radio
            display-variant="card"
            value="bank_transfer"
            label="Bank Transfer"
            description="Direct transfer from your bank account"
        />
    </x-pegboard::radio.group>
</div>
```

### Shipping Options

```blade
<div>
    <label class="block text-sm font-medium mb-2">Shipping Method</label>
    <x-pegboard::radio.group
        wire:model.live="shippingMethod"
        name="shipping"
    >
        <x-pegboard::radio
            value="standard"
            label="Standard Shipping"
            description="5-7 business days - Free"
        />
        <x-pegboard::radio
            value="express"
            label="Express Shipping"
            description="2-3 business days - $9.99"
        />
        <x-pegboard::radio
            value="overnight"
            label="Overnight Shipping"
            description="Next business day - $24.99"
        />
    </x-pegboard::radio.group>
</div>
```

### Settings Toggle

```blade
<div class="max-w-md">
    <label class="block text-sm font-medium mb-2">Privacy Settings</label>
    <x-pegboard::radio.group
        wire:model="privacy"
        variant="{{ $errors->has('privacy') ? 'error' : 'default' }}"
    >
        <x-pegboard::radio
            display-variant="card"
            value="public"
            label="Public"
            description="Anyone can see your profile"
        />
        <x-pegboard::radio
            display-variant="card"
            value="friends"
            label="Friends Only"
            description="Only your friends can see your profile"
        />
        <x-pegboard::radio
            display-variant="card"
            value="private"
            label="Private"
            description="Only you can see your profile"
        />
    </x-pegboard::radio.group>

    @error('privacy')
        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
    @enderror
</div>
```

### Custom Content (Using Slots)

```blade
<x-pegboard::radio.group name="plan">
    <x-pegboard::radio display-variant="card" value="basic">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium">Basic Plan</div>
                <div class="text-xs text-muted-foreground">$9/month</div>
            </div>
            <div class="text-2xl font-bold text-primary">$9</div>
        </div>
    </x-pegboard::radio>

    <x-pegboard::radio display-variant="card" value="pro">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-medium">Pro Plan</div>
                <div class="text-xs text-muted-foreground">$29/month</div>
            </div>
            <div class="text-2xl font-bold text-primary">$29</div>
        </div>
    </x-pegboard::radio>
</x-pegboard::radio.group>
```

## Keyboard Navigation

The Radio component supports keyboard navigation:

- **Arrow Up/Down** - Navigate between radio options
- **Space/Enter** - Select the focused radio
- **Tab** - Move focus to next element

## Accessibility

The Radio component includes comprehensive accessibility features:

- Proper ARIA attributes
- Keyboard navigation support
- Screen reader friendly
- Clear visual focus states (card variant only)
- Semantic HTML structure
- Proper form associations
- Native HTML radio behavior

## Styling

The component uses semantic design tokens from the Pegboard theme system, ensuring consistent appearance across light and dark modes. All variants and sizes automatically adapt to your theme configuration.

### Interactive States

- **Default variant**: No hover effect, minimal styling for clean appearance
- **Card variant**: Includes `hover:bg-muted/50` background effect and focus-visible ring
- **All variants**: Smooth scale and opacity animations on the inner dot using `transition-transform-opacity duration-200`
- **Checked state**: Uses `group-has-[:checked]:` pattern for pure CSS state management
- **Disabled state**: Reduced opacity and disabled cursor using `has-[:disabled]:` variant

### Technical Implementation

This component follows Pegboard's design principles:

1. **Modern HTML/CSS First**: Uses native `<input type="radio">` with CSS pseudo-classes (`:checked`, `:disabled`, `:focus-visible`)
2. **No JavaScript**: Pure Tailwind CSS implementation using `group-has-[:checked]:` for state management
3. **Smooth Animations**: Inner dot animates with `scale-0 opacity-0` → `scale-100 opacity-100` transitions
4. **Livewire Compatible**: DOM-based approach works seamlessly with `wire:model` binding
