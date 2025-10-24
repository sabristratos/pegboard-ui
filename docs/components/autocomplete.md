# Autocomplete Component

A smart autocomplete input with real-time filtering, keyboard navigation, validation states, and full Livewire compatibility.

## Basic Usage

```blade
<x-pegboard::autocomplete placeholder="Search...">
    <x-pegboard::autocomplete.option value="apple">Apple</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="banana">Banana</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="cherry">Cherry</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Visual variant: `'default'`, `'error'`, `'success'` |
| `size` | string | `'md'` | Size variant: `'xs'`, `'sm'`, `'md'`, `'lg'` |
| `label` | string\|null | `null` | Label text displayed above the input |
| `description` | string\|null | `null` | Description text displayed below the label |
| `placeholder` | string\|null | `null` | Placeholder text |
| `icon` | string\|null | `null` | Icon name to display on the left |
| `iconVariant` | string\|null | `'outline'` | Icon variant (mini, micro, outline, solid) |
| `clearable` | bool | `false` | Shows a clear button when input has value |
| `disabled` | bool | `false` | Disables the autocomplete |
| `emptyText` | string | `'No results found'` | Text to display when no options match |
| `value` | string\|null | `null` | Initial value |

## Option Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string\|null | `null` | Option value |
| `disabled` | bool | `false` | Disables this option |
| `searchText` | string\|null | `null` | Custom search text (if different from display text) |
| `href` | string\|null | `null` | Makes option a link instead of button |

## Variants

Autocomplete components support three validation variants for visual feedback:

```blade
<!-- Default state -->
<x-pegboard::autocomplete variant="default" placeholder="Search...">
    <x-pegboard::autocomplete.option value="apple">Apple</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="banana">Banana</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>

<!-- Error state -->
<x-pegboard::autocomplete variant="error" placeholder="Required field">
    <x-pegboard::autocomplete.option value="apple">Apple</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="banana">Banana</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
<p class="text-sm text-destructive mt-1">Please select an option</p>

<!-- Success state -->
<x-pegboard::autocomplete variant="success" value="Apple">
    <x-pegboard::autocomplete.option value="apple">Apple</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="banana">Banana</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
<p class="text-sm text-success mt-1">Valid selection</p>
```

## Sizes

Four size options are available to match your design:

```blade
<!-- Extra Small -->
<x-pegboard::autocomplete size="xs" placeholder="XS Autocomplete">
    <x-pegboard::autocomplete.option value="1">Option 1</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>

<!-- Small -->
<x-pegboard::autocomplete size="sm" placeholder="SM Autocomplete">
    <x-pegboard::autocomplete.option value="1">Option 1</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>

<!-- Medium (Default) -->
<x-pegboard::autocomplete size="md" placeholder="MD Autocomplete">
    <x-pegboard::autocomplete.option value="1">Option 1</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>

<!-- Large -->
<x-pegboard::autocomplete size="lg" placeholder="LG Autocomplete">
    <x-pegboard::autocomplete.option value="1">Option 1</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

## With Icon

Add an icon to the left side of the input:

```blade
<x-pegboard::autocomplete icon="magnifying-glass" placeholder="Search...">
    <x-pegboard::autocomplete.option value="apple">Apple</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="banana">Banana</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="cherry">Cherry</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

## Clearable

Add a clear button that appears when the input has a value:

```blade
<x-pegboard::autocomplete clearable placeholder="Type to search...">
    <x-pegboard::autocomplete.option value="apple">Apple</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="banana">Banana</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

## With Label and Description

Provide context with labels and descriptions:

```blade
<x-pegboard::autocomplete
    label="Favorite Fruit"
    description="Select your favorite fruit from the list"
    icon="heart"
    clearable
    placeholder="Choose..."
>
    <x-pegboard::autocomplete.option value="apple">Apple</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="banana">Banana</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="cherry">Cherry</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

## Disabled State

Disable the autocomplete to make it read-only:

```blade
<!-- Disabled empty -->
<x-pegboard::autocomplete disabled placeholder="Cannot edit...">
    <x-pegboard::autocomplete.option value="locked">Locked</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>

<!-- Disabled with value -->
<x-pegboard::autocomplete disabled value="Locked">
    <x-pegboard::autocomplete.option value="locked">Locked</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

## Disabled Options

Disable specific options while keeping others selectable:

```blade
<x-pegboard::autocomplete placeholder="Select...">
    <x-pegboard::autocomplete.option value="available">Available Option</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="unavailable" disabled>Unavailable Option</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="coming-soon" disabled>Coming Soon</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

## Custom Empty State

Customize the message shown when no results are found:

```blade
<x-pegboard::autocomplete
    emptyText="No cities found matching your search"
    placeholder="Search cities..."
>
    <x-pegboard::autocomplete.option value="new-york">New York</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="los-angeles">Los Angeles</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

Or use the empty slot for custom HTML:

```blade
<x-pegboard::autocomplete placeholder="Search...">
    <x-pegboard::autocomplete.option value="1">Option 1</x-pegboard::autocomplete.option>

    <x-slot:empty>
        <div class="px-4 py-6 text-center">
            <p class="text-sm text-muted-foreground mb-2">No results found</p>
            <button type="button" class="text-sm text-primary hover:underline">
                Add new item
            </button>
        </div>
    </x-slot:empty>
</x-pegboard::autocomplete>
```

## Form Submission

The Autocomplete component works with traditional form submissions and Livewire:

### Traditional Forms

```blade
<form action="/submit" method="POST">
    @csrf

    <x-pegboard::autocomplete
        name="country"
        label="Country"
        placeholder="Search countries..."
    >
        <x-pegboard::autocomplete.option value="us">United States</x-pegboard::autocomplete.option>
        <x-pegboard::autocomplete.option value="uk">United Kingdom</x-pegboard::autocomplete.option>
        <x-pegboard::autocomplete.option value="ca">Canada</x-pegboard::autocomplete.option>
    </x-pegboard::autocomplete>

    <button type="submit">Submit</button>
</form>
```

### Livewire Integration

```blade
<!-- Two-way binding -->
<x-pegboard::autocomplete
    wire:model="selectedCountry"
    placeholder="Search countries..."
>
    <x-pegboard::autocomplete.option value="us">United States</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="uk">United Kingdom</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>

<!-- Live binding -->
<x-pegboard::autocomplete
    wire:model.live="searchQuery"
    placeholder="Live search..."
>
    @foreach($results as $result)
        <x-pegboard::autocomplete.option value="{{ $result->id }}">
            {{ $result->name }}
        </x-pegboard::autocomplete.option>
    @endforeach
</x-pegboard::autocomplete>
```

## Real-World Examples

### City Search

```blade
<x-pegboard::autocomplete
    wire:model="address.city"
    icon="map-pin"
    label="City"
    description="Type to filter cities"
    clearable
    placeholder="Search for a city..."
>
    <x-pegboard::autocomplete.option value="new-york">New York</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="los-angeles">Los Angeles</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="chicago">Chicago</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="houston">Houston</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="phoenix">Phoenix</x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option value="philadelphia">Philadelphia</x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

### Product Search

```blade
<x-pegboard::autocomplete
    wire:model.live="search"
    icon="magnifying-glass"
    size="lg"
    clearable
    placeholder="Search products..."
>
    @foreach($products as $product)
        <x-pegboard::autocomplete.option value="{{ $product->id }}">
            {{ $product->name }}
        </x-pegboard::autocomplete.option>
    @endforeach
</x-pegboard::autocomplete>
```

### Tag Selection

```blade
<div>
    <x-pegboard::autocomplete
        wire:model="selectedTag"
        label="Tags"
        description="Select or search for tags"
        icon="tag"
        clearable
        placeholder="Search tags..."
        variant="{{ $errors->has('selectedTag') ? 'error' : 'default' }}"
    >
        <x-pegboard::autocomplete.option value="php">PHP</x-pegboard::autocomplete.option>
        <x-pegboard::autocomplete.option value="javascript">JavaScript</x-pegboard::autocomplete.option>
        <x-pegboard::autocomplete.option value="laravel">Laravel</x-pegboard::autocomplete.option>
        <x-pegboard::autocomplete.option value="vue">Vue.js</x-pegboard::autocomplete.option>
        <x-pegboard::autocomplete.option value="react">React</x-pegboard::autocomplete.option>
    </x-pegboard::autocomplete>

    @error('selectedTag')
        <p class="text-sm text-destructive mt-1">{{ $message }}</p>
    @enderror
</div>
```

### User Search with Custom Search Text

```blade
<x-pegboard::autocomplete
    label="Assign To"
    icon="user"
    clearable
    placeholder="Search by name or email..."
>
    <x-pegboard::autocomplete.option
        value="john"
        searchText="John Doe john@example.com"
    >
        <div class="flex items-center gap-2">
            <div class="h-6 w-6 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xs">
                JD
            </div>
            <div>
                <div class="text-sm font-medium">John Doe</div>
                <div class="text-xs text-muted-foreground">john@example.com</div>
            </div>
        </div>
    </x-pegboard::autocomplete.option>

    <x-pegboard::autocomplete.option
        value="jane"
        searchText="Jane Smith jane@example.com"
    >
        <div class="flex items-center gap-2">
            <div class="h-6 w-6 rounded-full bg-success text-success-foreground flex items-center justify-center text-xs">
                JS
            </div>
            <div>
                <div class="text-sm font-medium">Jane Smith</div>
                <div class="text-xs text-muted-foreground">jane@example.com</div>
            </div>
        </div>
    </x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

### Navigation Menu with Links

```blade
<x-pegboard::autocomplete
    icon="command-line"
    placeholder="Quick navigation..."
    size="sm"
>
    <x-pegboard::autocomplete.option href="/dashboard" value="dashboard">
        Dashboard
    </x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option href="/users" value="users">
        Users
    </x-pegboard::autocomplete.option>
    <x-pegboard::autocomplete.option href="/settings" value="settings">
        Settings
    </x-pegboard::autocomplete.option>
</x-pegboard::autocomplete>
```

## Filtering Behavior

The Autocomplete component automatically filters options as you type:

- **Case-insensitive** - Matches regardless of letter casing
- **Partial matching** - Finds text anywhere in the option
- **Real-time** - Updates immediately as you type
- **Custom search text** - Use `searchText` prop to search on hidden content

## Keyboard Navigation

The Autocomplete supports full keyboard navigation:

- **Arrow Down** - Navigate to next option
- **Arrow Up** - Navigate to previous option
- **Enter** - Select active option
- **Escape** - Close dropdown
- **Type to search** - Filter options in real-time

## Focus Behavior

When the input receives focus:

- Existing value is selected (easy to replace)
- All options are shown
- User can start typing to filter
- Or arrow keys to navigate

## Accessibility

The Autocomplete component includes comprehensive accessibility features:

- Proper ARIA attributes (`role="combobox"`, `aria-expanded`, etc.)
- Keyboard navigation support
- Screen reader friendly announcements
- Active option tracking with `aria-activedescendant`
- Focus management
- Clear visual focus states
- Semantic HTML structure

## Styling

The component uses semantic design tokens from the Pegboard theme system, ensuring consistent appearance across light and dark modes. All variants and sizes automatically adapt to your theme configuration.
