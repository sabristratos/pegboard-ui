# Select Component

A powerful select dropdown component with search functionality, multi-select support, validation states, and icon integration.

## Basic Usage

```blade
<x-pegboard::select placeholder="Choose an option...">
    <x-pegboard::select.option value="1">Option 1</x-pegboard::select.option>
    <x-pegboard::select.option value="2">Option 2</x-pegboard::select.option>
    <x-pegboard::select.option value="3">Option 3</x-pegboard::select.option>
</x-pegboard::select>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `multiple` | bool | `false` | Enable multi-select mode |
| `searchable` | bool | `false` | Enable search/filter functionality |
| `placeholder` | string | `'Select...'` | Placeholder text when nothing is selected |
| `displayVariant` | string | `'default'` | Display mode: `'default'` or `'pillbox'` (multi-select only) |
| `variant` | string | `'default'` | Validation variant: `'default'`, `'error'`, `'success'` |
| `size` | string | `'md'` | Size variant: `'xs'`, `'sm'`, `'md'`, `'lg'` |
| `icon` | string | `null` | Icon to display in the select trigger |
| `name` | string | `null` | Form field name for submissions |
| `value` | mixed | `null` | Initial selected value(s) |
| `disabled` | bool | `false` | Disables the select |

## Variants

Select components support three validation variants for visual feedback:

```blade
<!-- Default state -->
<x-pegboard::select variant="default" placeholder="Select...">
    <x-pegboard::select.option value="1">Option 1</x-pegboard::select.option>
    <x-pegboard::select.option value="2">Option 2</x-pegboard::select.option>
</x-pegboard::select>

<!-- Error state -->
<x-pegboard::select variant="error" placeholder="Required field">
    <x-pegboard::select.option value="1">Option 1</x-pegboard::select.option>
    <x-pegboard::select.option value="2">Option 2</x-pegboard::select.option>
</x-pegboard::select>
<p class="text-sm text-destructive mt-1">This field is required</p>

<!-- Success state -->
<x-pegboard::select variant="success" value="1">
    <x-pegboard::select.option value="1">Option 1</x-pegboard::select.option>
    <x-pegboard::select.option value="2">Option 2</x-pegboard::select.option>
</x-pegboard::select>
<p class="text-sm text-success mt-1">Selection confirmed</p>
```

## Sizes

Four size options are available to match your design:

```blade
<!-- Extra Small -->
<x-pegboard::select size="xs" placeholder="XS Select">
    <x-pegboard::select.option value="1">Option 1</x-pegboard::select.option>
</x-pegboard::select>

<!-- Small -->
<x-pegboard::select size="sm" placeholder="SM Select">
    <x-pegboard::select.option value="1">Option 1</x-pegboard::select.option>
</x-pegboard::select>

<!-- Medium (Default) -->
<x-pegboard::select size="md" placeholder="MD Select">
    <x-pegboard::select.option value="1">Option 1</x-pegboard::select.option>
</x-pegboard::select>

<!-- Large -->
<x-pegboard::select size="lg" placeholder="LG Select">
    <x-pegboard::select.option value="1">Option 1</x-pegboard::select.option>
</x-pegboard::select>
```

## Searchable Select

Enable search functionality to filter through options:

```blade
<x-pegboard::select searchable placeholder="Search options...">
    <x-pegboard::select.option value="apple">Apple</x-pegboard::select.option>
    <x-pegboard::select.option value="banana">Banana</x-pegboard::select.option>
    <x-pegboard::select.option value="cherry">Cherry</x-pegboard::select.option>
    <x-pegboard::select.option value="date">Date</x-pegboard::select.option>
    <x-pegboard::select.option value="elderberry">Elderberry</x-pegboard::select.option>
</x-pegboard::select>
```

## Multi-Select

Enable selecting multiple options with two display variants:

### Default Multi-Select

Shows a count of selected items:

```blade
<x-pegboard::select multiple searchable placeholder="Select multiple...">
    <x-pegboard::select.option value="js">JavaScript</x-pegboard::select.option>
    <x-pegboard::select.option value="py">Python</x-pegboard::select.option>
    <x-pegboard::select.option value="php">PHP</x-pegboard::select.option>
    <x-pegboard::select.option value="ruby">Ruby</x-pegboard::select.option>
    <x-pegboard::select.option value="go">Go</x-pegboard::select.option>
</x-pegboard::select>
```

### Pillbox Multi-Select

Shows selected items as removable pills:

```blade
<x-pegboard::select multiple displayVariant="pillbox" searchable placeholder="Select tags...">
    <x-pegboard::select.option value="design">Design</x-pegboard::select.option>
    <x-pegboard::select.option value="development">Development</x-pegboard::select.option>
    <x-pegboard::select.option value="marketing">Marketing</x-pegboard::select.option>
    <x-pegboard::select.option value="sales">Sales</x-pegboard::select.option>
    <x-pegboard::select.option value="support">Support</x-pegboard::select.option>
</x-pegboard::select>
```

## Options with Icons

Add icons to options for better visual context:

```blade
<x-pegboard::select placeholder="Select status...">
    <x-pegboard::select.option value="active" icon="check-circle">
        Active
    </x-pegboard::select.option>
    <x-pegboard::select.option value="pending" icon="clock">
        Pending
    </x-pegboard::select.option>
    <x-pegboard::select.option value="inactive" icon="x-circle">
        Inactive
    </x-pegboard::select.option>
</x-pegboard::select>
```

## Disabled State

Disable the select to make it read-only:

```blade
<!-- Disabled empty -->
<x-pegboard::select disabled placeholder="Cannot select...">
    <x-pegboard::select.option value="1">Option 1</x-pegboard::select.option>
    <x-pegboard::select.option value="2">Option 2</x-pegboard::select.option>
</x-pegboard::select>

<!-- Disabled with pre-selected value -->
<x-pegboard::select disabled value="1">
    <x-pegboard::select.option value="1">Selected Option</x-pegboard::select.option>
    <x-pegboard::select.option value="2">Option 2</x-pegboard::select.option>
</x-pegboard::select>
```

## Form Submission

The Select component works with traditional form submissions and Livewire:

### Traditional Forms

```blade
<form action="/submit" method="POST">
    @csrf

    <!-- Single select -->
    <x-pegboard::select name="country" placeholder="Select country...">
        <x-pegboard::select.option value="us">United States</x-pegboard::select.option>
        <x-pegboard::select.option value="uk">United Kingdom</x-pegboard::select.option>
    </x-pegboard::select>

    <!-- Multi-select (submits as array) -->
    <x-pegboard::select name="skills" multiple placeholder="Select skills...">
        <x-pegboard::select.option value="js">JavaScript</x-pegboard::select.option>
        <x-pegboard::select.option value="php">PHP</x-pegboard::select.option>
    </x-pegboard::select>

    <button type="submit">Submit</button>
</form>
```

### Livewire Integration

```blade
<!-- Single select -->
<x-pegboard::select wire:model="selectedCountry" placeholder="Select country...">
    <x-pegboard::select.option value="us">United States</x-pegboard::select.option>
    <x-pegboard::select.option value="uk">United Kingdom</x-pegboard::select.option>
</x-pegboard::select>

<!-- Multi-select -->
<x-pegboard::select wire:model="selectedSkills" multiple placeholder="Select skills...">
    <x-pegboard::select.option value="js">JavaScript</x-pegboard::select.option>
    <x-pegboard::select.option value="php">PHP</x-pegboard::select.option>
</x-pegboard::select>

<!-- Live binding -->
<x-pegboard::select wire:model.live="category" placeholder="Select category...">
    <x-pegboard::select.option value="tech">Technology</x-pegboard::select.option>
    <x-pegboard::select.option value="design">Design</x-pegboard::select.option>
</x-pegboard::select>
```

## Real-World Examples

### Country Selection

```blade
<div>
    <label class="block text-sm font-medium mb-2">Country</label>
    <x-pegboard::select
        wire:model="address.country"
        searchable
        placeholder="Search countries..."
    >
        <x-pegboard::select.option value="us" icon="flag">United States</x-pegboard::select.option>
        <x-pegboard::select.option value="uk" icon="flag">United Kingdom</x-pegboard::select.option>
        <x-pegboard::select.option value="ca" icon="flag">Canada</x-pegboard::select.option>
        <x-pegboard::select.option value="au" icon="flag">Australia</x-pegboard::select.option>
        <x-pegboard::select.option value="de" icon="flag">Germany</x-pegboard::select.option>
        <x-pegboard::select.option value="fr" icon="flag">France</x-pegboard::select.option>
    </x-pegboard::select>
</div>
```

### Blog Categories with Tags

```blade
<div>
    <label class="block text-sm font-medium mb-2">Categories</label>
    <x-pegboard::select
        wire:model="post.categories"
        multiple
        displayVariant="pillbox"
        searchable
        placeholder="Select categories..."
    >
        <x-pegboard::select.option value="tech" icon="code-bracket">Technology</x-pegboard::select.option>
        <x-pegboard::select.option value="design" icon="paint-brush">Design</x-pegboard::select.option>
        <x-pegboard::select.option value="business" icon="briefcase">Business</x-pegboard::select.option>
        <x-pegboard::select.option value="lifestyle" icon="heart">Lifestyle</x-pegboard::select.option>
        <x-pegboard::select.option value="travel" icon="globe-alt">Travel</x-pegboard::select.option>
    </x-pegboard::select>
</div>
```

### Project Status with Validation

```blade
<div>
    <label class="block text-sm font-medium mb-2">Project Status</label>
    <x-pegboard::select
        wire:model="project.status"
        variant="success"
        value="active"
    >
        <x-pegboard::select.option value="draft" icon="document-text">Draft</x-pegboard::select.option>
        <x-pegboard::select.option value="active" icon="play">Active</x-pegboard::select.option>
        <x-pegboard::select.option value="completed" icon="check-circle">Completed</x-pegboard::select.option>
        <x-pegboard::select.option value="archived" icon="archive-box">Archived</x-pegboard::select.option>
    </x-pegboard::select>
    <p class="text-sm text-success mt-1">Project is currently active</p>
</div>
```

### Team Members Multi-Select

```blade
<div>
    <label class="block text-sm font-medium mb-2">Team Members</label>
    <x-pegboard::select
        wire:model="project.members"
        multiple
        searchable
        placeholder="Add team members..."
    >
        <x-pegboard::select.option value="john" icon="user">John Doe</x-pegboard::select.option>
        <x-pegboard::select.option value="jane" icon="user">Jane Smith</x-pegboard::select.option>
        <x-pegboard::select.option value="bob" icon="user">Bob Johnson</x-pegboard::select.option>
        <x-pegboard::select.option value="alice" icon="user">Alice Williams</x-pegboard::select.option>
    </x-pegboard::select>
</div>
```

### Priority Selection

```blade
<div>
    <label class="block text-sm font-medium mb-2">Priority</label>
    <x-pegboard::select
        wire:model="task.priority"
        searchable
        placeholder="Select priority..."
    >
        <x-pegboard::select.option value="high" icon="exclamation-circle">
            High Priority
        </x-pegboard::select.option>
        <x-pegboard::select.option value="medium" icon="minus-circle">
            Medium Priority
        </x-pegboard::select.option>
        <x-pegboard::select.option value="low" icon="arrow-down-circle">
            Low Priority
        </x-pegboard::select.option>
    </x-pegboard::select>
</div>
```

## Keyboard Navigation

The Select component supports full keyboard navigation:

- **Enter/Space** - Open dropdown
- **Escape** - Close dropdown
- **Arrow Down** - Navigate to next option
- **Arrow Up** - Navigate to previous option
- **Enter** - Select active option
- **Type to search** - When searchable is enabled

## Accessibility

The Select component includes comprehensive accessibility features:

- Proper ARIA attributes (`role="combobox"`, `aria-expanded`, etc.)
- Keyboard navigation support
- Screen reader friendly announcements
- Focus management
- Clear visual focus states
- Semantic HTML structure

## Styling

The component uses semantic design tokens from the Pegboard theme system, ensuring consistent appearance across light and dark modes. All variants and sizes automatically adapt to your theme configuration.
