# Pegboard

> A modern, CSS-first UI component library for Laravel + Livewire applications.

Built by [Stratos Digital](https://stratosdigital.io)

## Why Pegboard?

- **Batteries-Included** - 96+ production-ready components covering all UI patterns
- **CSS-First Design** - Customize via CSS custom properties, not config files
- **Native HTML** - Uses `<details>`, `<dialog>`, modern CSS instead of excessive JavaScript
- **Livewire Integration** - Full `wire:model` support, validation states, loading states
- **Alpine.js Enhanced** - Lightweight interactivity only where needed
- **Dark Mode** - Auto light/dark support via `@theme inline`
- **Flexible Slots** - Pre-styled defaults, easily swap with your own design

## Requirements

- PHP 8.2+
- Laravel 11 or 12
- Livewire 3+
- Tailwind CSS v4

## Installation

Install via Composer:

```bash
composer require stratos/pegboard
```

### Setup (3 Steps)

**1. Import Pegboard CSS** in your `resources/css/app.css`:

```css
@import 'tailwindcss';
@import '../../vendor/stratos/pegboard/resources/css/pegboard.css';
```

**2. Add the `@pegboard` directive** to your layout (before `</body>`):

```blade
<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>
<body>
    {{ $slot }}

    @pegboard  {{-- Add this line --}}
</body>
</html>
```

**3. Build assets:**

```bash
npm run build
```

That's it! You're ready to use Pegboard components.

## Quick Start

```blade
{{-- Button --}}
<x-pegboard::button variant="primary" size="md">
    Click Me
</x-pegboard::button>

{{-- Input with Livewire --}}
<x-pegboard::input
    wire:model="email"
    type="email"
    placeholder="Enter email"
/>

{{-- File Upload with drag & drop --}}
<x-pegboard::file-upload
    wire:model="avatar"
    accept="image/*"
    max-size="5MB"
/>

{{-- Modal --}}
<x-pegboard::modal>
    <x-slot:trigger>
        <x-pegboard::button>Open Modal</x-pegboard::button>
    </x-slot:trigger>

    <x-pegboard::heading>Welcome</x-pegboard::heading>
    <p>Modal content goes here.</p>
</x-pegboard::modal>

{{-- Dropdown Menu --}}
<x-pegboard::dropdown align="right">
    <x-slot:trigger>
        <x-pegboard::button variant="secondary">
            Options
        </x-pegboard::button>
    </x-slot:trigger>

    <a href="#" class="block px-4 py-2 hover:bg-popover-hover">Profile</a>
    <a href="#" class="block px-4 py-2 hover:bg-popover-hover">Settings</a>
</x-pegboard::dropdown>
```

## Available Components

> **Note:** Sub-components use dot notation (e.g., `<x-pegboard::menu.item>`, `<x-pegboard::card.header>`).

### Form Components (30+)

**Basic Inputs**
- `<x-pegboard::button>` - Versatile button (primary, secondary, danger, success, ghost)
  - `<x-pegboard::button.group>` - Button group container
- `<x-pegboard::input>` - Text input with variants, icons, prefix/suffix, clearable
- `<x-pegboard::textarea>` - Multi-line input with validation states
- `<x-pegboard::select>` - Styled dropdown selection
  - `<x-pegboard::select.option>` - Select option component
- `<x-pegboard::checkbox>` - Multiple selection with card variant, indeterminate state
  - `<x-pegboard::checkbox.group>` - Checkbox group container
- `<x-pegboard::radio>` - Single selection with card variant
  - `<x-pegboard::radio.group>` - Radio group container
- `<x-pegboard::toggle>` - Switch/toggle for boolean values
- `<x-pegboard::range>` - Slider for numeric ranges
- `<x-pegboard::rating>` / `<x-pegboard::rating-input>` - Star rating components

**Advanced Inputs**
- `<x-pegboard::date-picker>` - Calendar-based date selection
- `<x-pegboard::time-picker>` - Time selection (12/24 hour)
- `<x-pegboard::autocomplete>` - Searchable dropdown with typeahead
  - `<x-pegboard::autocomplete.option>` - Autocomplete option
- `<x-pegboard::editor>` - Rich text editor (TipTap integration)

**File Management**
- `<x-pegboard::file-upload>` - Drag & drop file upload with previews
  - `<x-pegboard::file-upload.dropzone>` - Pre-styled dropzone UI
  - `<x-pegboard::file-upload.avatar>` - Circular avatar upload
- `<x-pegboard::file-item>` - Individual file preview card
- `<x-pegboard::file-item-remove>` - Remove button for file items

**Form Layout**
- `<x-pegboard::field>` - Form field wrapper (block/inline variants)
- `<x-pegboard::fieldset>` - Semantic fieldset grouping
- `<x-pegboard::label>` - Form labels with tooltip support
- `<x-pegboard::legend>` - Fieldset legend
- `<x-pegboard::description>` - Helper text for form fields
- `<x-pegboard::error>` - Validation error display
- `<x-pegboard::group>` - Generic grouping component

### Layout Components (20+)

- `<x-pegboard::card>` - Container with header/footer slots
  - `<x-pegboard::card.header>` - Card header section
  - `<x-pegboard::card.footer>` - Card footer section
- `<x-pegboard::alert>` - Alerts/notifications (info, success, warning, danger)
- `<x-pegboard::separator>` - Divider line
- `<x-pegboard::modal>` - Dialog/modal with blur backdrop, positions
  - `<x-pegboard::modal.trigger>` - Modal trigger button
  - `<x-pegboard::modal.close>` - Modal close button
- `<x-pegboard::popover>` - Popover positioning (anchor-based)
- `<x-pegboard::tooltip>` - Pre-styled tooltip with placement options
- `<x-pegboard::sidebar>` - Left/right sidebar with sections, search
  - `<x-pegboard::sidebar.header>` - Sidebar header section
  - `<x-pegboard::sidebar.footer>` - Sidebar footer section
  - `<x-pegboard::sidebar.nav>` - Sidebar navigation container
  - `<x-pegboard::sidebar.section>` - Sidebar section with grouping
  - `<x-pegboard::sidebar.item>` - Sidebar navigation item
  - `<x-pegboard::sidebar.search>` - Sidebar search input

### Navigation Components (25+)

- `<x-pegboard::dropdown>` - Dropdown menu with positioning
- `<x-pegboard::menu>` - Context/action menu system
  - `<x-pegboard::menu.item>` - Menu item with icon support
  - `<x-pegboard::menu.separator>` - Menu divider
  - `<x-pegboard::menu.group>` - Menu item grouping
  - `<x-pegboard::menu.checkbox>` - Menu checkbox item
  - `<x-pegboard::menu.radio>` - Menu radio item
  - `<x-pegboard::menu.radio-group>` - Menu radio group
  - `<x-pegboard::menu.checkbox-group>` - Menu checkbox group
  - `<x-pegboard::menu.submenu>` - Nested submenu with arrow
- `<x-pegboard::nav-menu>` - Navigation menu
  - `<x-pegboard::nav-menu.item>` - Navigation menu item
- `<x-pegboard::breadcrumbs>` - Breadcrumb navigation
  - `<x-pegboard::breadcrumbs-item>` - Individual breadcrumb item
- `<x-pegboard::tabs>` - Tab navigation system
  - `<x-pegboard::tab.group>` - Tab group container
  - `<x-pegboard::tab.button>` - Tab button/trigger
  - `<x-pegboard::tab.panel>` - Tab content panel
- `<x-pegboard::accordion>` - Collapsible accordion sections
  - `<x-pegboard::accordion.item>` - Individual accordion item
  - `<x-pegboard::accordion.heading>` - Accordion heading
  - `<x-pegboard::accordion.content>` - Accordion content

### Data Display (20+)

- `<x-pegboard::table>` - Semantic data table
  - `<x-pegboard::table.head>` - Table header section
  - `<x-pegboard::table.header>` - Table header cell
  - `<x-pegboard::table.body>` - Table body section
  - `<x-pegboard::table.row>` - Table row
  - `<x-pegboard::table.cell>` - Table cell
  - `<x-pegboard::table.foot>` - Table footer section
- `<x-pegboard::badge>` - Label/badge component
  - `<x-pegboard::badge.group>` - Badge group container
- `<x-pegboard::status>` - Status indicator with variants
- `<x-pegboard::avatar>` - User avatar with image/initials
  - `<x-pegboard::avatar.group>` - Avatar group with overflow handling
- `<x-pegboard::icon>` - Icon rendering (Heroicons: solid, outline, mini, micro)
- `<x-pegboard::kbd>` - Keyboard key representation

### Interactive Components (15+)

- `<x-pegboard::carousel>` - Image carousel with autoplay, thumbnails, indicators
  - `<x-pegboard::carousel-item>` - Individual carousel slide
  - `<x-pegboard::carousel-controls>` - Prev/Next navigation buttons
  - `<x-pegboard::carousel-indicators>` - Dot indicators
  - `<x-pegboard::carousel-thumbnails>` - Thumbnail navigation
- `<x-pegboard::toast>` - Toast/notification system
- `<x-pegboard::spinner>` - Loading spinner
- `<x-pegboard::timer>` - Countdown/stopwatch timer
  - `<x-pegboard::timer.display>` - Timer display output
  - `<x-pegboard::timer.controls>` - Timer control buttons
- `<x-pegboard::chart>` - Data visualization

### Typography (5+)

- `<x-pegboard::heading>` - Semantic headings (h1-h6)
- `<x-pegboard::text>` - Typography component
- `<x-pegboard::link>` - Semantic link component

## Component Examples

### Button Variants

```blade
<x-pegboard::button variant="primary">Primary</x-pegboard::button>
<x-pegboard::button variant="secondary">Secondary</x-pegboard::button>
<x-pegboard::button variant="danger">Delete</x-pegboard::button>
<x-pegboard::button variant="success">Save</x-pegboard::button>
<x-pegboard::button variant="ghost">Cancel</x-pegboard::button>
```

### Form with Validation

```blade
<form wire:submit="save">
    <x-pegboard::field>
        <x-pegboard::label>Email</x-pegboard::label>
        <x-pegboard::input
            wire:model="email"
            type="email"
        />
        <x-pegboard::error name="email" />
    </x-pegboard::field>

    <x-pegboard::field>
        <x-pegboard::label>Password</x-pegboard::label>
        <x-pegboard::input
            wire:model="password"
            type="password"
        />
        <x-pegboard::error name="password" />
    </x-pegboard::field>

    <x-pegboard::button type="submit">
        Sign In
    </x-pegboard::button>
</form>
```

### File Upload with Avatar

```blade
{{-- Simple dropzone --}}
<x-pegboard::file-upload
    wire:model="documents"
    accept="application/pdf"
    multiple
/>

{{-- Avatar upload --}}
<x-pegboard::file-upload wire:model="avatar">
    <x-slot:dropzone>
        <x-pegboard::file-upload.avatar />
    </x-slot:dropzone>
</x-pegboard::file-upload>
```

### Checkbox Group with Card Variant

```blade
<x-pegboard::fieldset>
    <x-pegboard::legend>Select Features</x-pegboard::legend>

    <x-pegboard::checkbox.group
        wire:model="selectedFeatures"
        class="grid gap-4"
    >
        <x-pegboard::checkbox
            value="analytics"
            displayVariant="card"
        >
            <x-slot:label>Analytics Dashboard</x-slot:label>
            <x-slot:description>Track user behavior and metrics</x-slot:description>
        </x-pegboard::checkbox>

        <x-pegboard::checkbox
            value="reports"
            displayVariant="card"
        >
            <x-slot:label>Custom Reports</x-slot:label>
            <x-slot:description>Generate detailed reports</x-slot:description>
        </x-pegboard::checkbox>
    </x-pegboard::checkbox.group>
</x-pegboard::fieldset>
```

### Carousel with Thumbnails

```blade
<x-pegboard::carousel autoplay loop :peek="true">
    @foreach($images as $image)
        <x-pegboard::carousel-item>
            <img src="{{ $image }}" alt="Slide">
        </x-pegboard::carousel-item>
    @endforeach

    <x-slot:controls>
        <x-pegboard::carousel.controls />
    </x-slot:controls>

    <x-slot:thumbnails>
        <x-pegboard::carousel.thumbnails />
    </x-slot:thumbnails>
</x-pegboard::carousel>
```

### Context Menu with Sub-Components

```blade
<x-pegboard::menu>
    <x-slot:trigger>
        <x-pegboard::button variant="secondary">
            Actions
        </x-pegboard::button>
    </x-slot:trigger>

    {{-- Regular menu items --}}
    <x-pegboard::menu.item href="/profile">
        <x-pegboard::icon name="user" /> Profile
    </x-pegboard::menu.item>

    <x-pegboard::menu.separator />

    {{-- Menu group with label --}}
    <x-pegboard::menu.group label="Preferences">
        <x-pegboard::menu.checkbox wire:model="notifications">
            Enable Notifications
        </x-pegboard::menu.checkbox>
        <x-pegboard::menu.checkbox wire:model="darkMode">
            Dark Mode
        </x-pegboard::menu.checkbox>
    </x-pegboard::menu.group>

    <x-pegboard::menu.separator />

    {{-- Radio group --}}
    <x-pegboard::menu.radio-group wire:model="theme">
        <x-pegboard::menu.radio value="light">Light</x-pegboard::menu.radio>
        <x-pegboard::menu.radio value="dark">Dark</x-pegboard::menu.radio>
        <x-pegboard::menu.radio value="system">System</x-pegboard::menu.radio>
    </x-pegboard::menu.radio-group>

    <x-pegboard::menu.separator />

    {{-- Nested submenu --}}
    <x-pegboard::menu.submenu label="More Options">
        <x-pegboard::menu.item>Export Data</x-pegboard::menu.item>
        <x-pegboard::menu.item>Import Data</x-pegboard::menu.item>
    </x-pegboard::menu.submenu>
</x-pegboard::menu>
```

### Modal with Trigger and Close

```blade
<x-pegboard::modal>
    {{-- Trigger slot - button that opens the modal --}}
    <x-slot:trigger>
        <x-pegboard::button variant="primary">
            Open Settings
        </x-pegboard::button>
    </x-slot:trigger>

    {{-- Modal content --}}
    <div class="space-y-4">
        <x-pegboard::heading>Settings</x-pegboard::heading>

        <x-pegboard::field>
            <x-pegboard::label>Username</x-pegboard::label>
            <x-pegboard::input wire:model="username" />
        </x-pegboard::field>

        <div class="flex gap-2 justify-end">
            {{-- Custom close button --}}
            <x-pegboard::modal.close>
                <x-pegboard::button variant="ghost">
                    Cancel
                </x-pegboard::button>
            </x-pegboard::modal.close>

            <x-pegboard::button variant="primary">
                Save Changes
            </x-pegboard::button>
        </div>
    </div>
</x-pegboard::modal>
```

### Table with Full Structure

```blade
<x-pegboard::table>
    <x-pegboard::table.head>
        <x-pegboard::table.row>
            <x-pegboard::table.header>Name</x-pegboard::table.header>
            <x-pegboard::table.header>Email</x-pegboard::table.header>
            <x-pegboard::table.header>Role</x-pegboard::table.header>
            <x-pegboard::table.header>Actions</x-pegboard::table.header>
        </x-pegboard::table.row>
    </x-pegboard::table.head>

    <x-pegboard::table.body>
        @foreach($users as $user)
            <x-pegboard::table.row>
                <x-pegboard::table.cell>{{ $user->name }}</x-pegboard::table.cell>
                <x-pegboard::table.cell>{{ $user->email }}</x-pegboard::table.cell>
                <x-pegboard::table.cell>
                    <x-pegboard::badge>{{ $user->role }}</x-pegboard::badge>
                </x-pegboard::table.cell>
                <x-pegboard::table.cell>
                    <x-pegboard::button size="sm">Edit</x-pegboard::button>
                </x-pegboard::table.cell>
            </x-pegboard::table.row>
        @endforeach
    </x-pegboard::table.body>

    <x-pegboard::table.foot>
        <x-pegboard::table.row>
            <x-pegboard::table.cell colspan="4">
                Total: {{ $users->count() }} users
            </x-pegboard::table.cell>
        </x-pegboard::table.row>
    </x-pegboard::table.foot>
</x-pegboard::table>
```

### Timer with Display and Controls

```blade
<x-pegboard::timer initial="60" countdown>
    <div class="space-y-4">
        {{-- Timer display --}}
        <x-pegboard::timer.display />

        {{-- Timer controls --}}
        <x-pegboard::timer.controls />
    </div>
</x-pegboard::timer>
```

### Sidebar with Navigation

```blade
<x-pegboard::sidebar>
    <x-slot:header>
        <div class="p-4">
            <h2>My App</h2>
        </div>
    </x-slot:header>

    <x-pegboard::sidebar.search placeholder="Search..." />

    <x-pegboard::sidebar.nav>
        <x-pegboard::sidebar.item href="/dashboard" active>
            Dashboard
        </x-pegboard::sidebar.item>
        <x-pegboard::sidebar.item href="/users">
            Users
        </x-pegboard::sidebar.item>
        <x-pegboard::sidebar.item href="/settings">
            Settings
        </x-pegboard::sidebar.item>
    </x-pegboard::sidebar.nav>
</x-pegboard::sidebar>
```

## Customization

Pegboard uses a **CSS-first design philosophy**. All visual customization is done by overriding CSS custom properties, not config files.

### Change Brand Colors

```css
/* In your app.css after importing pegboard.css */
@theme {
  --brand-500: var(--color-purple-500);  /* Change brand color to purple */
  --brand-600: var(--color-purple-600);
}
```

### Adjust Animation Speed

```css
@theme {
  --duration-fast: 100ms;    /* Speed up animations */
  --duration-normal: 150ms;
  --duration-slow: 250ms;
}
```

### Custom Component Styling

```blade
{{-- Override with Tailwind utilities --}}
<x-pegboard::button class="rounded-full shadow-lg">
    Custom Styled Button
</x-pegboard::button>
```

### Available Theme Tokens

**Colors:**
- `--color-primary`, `--color-primary-foreground`
- `--color-secondary`, `--color-secondary-foreground`
- `--color-destructive`, `--color-destructive-foreground`
- `--color-success`, `--color-warning`, `--color-info`
- `--color-muted`, `--color-muted-foreground`
- `--color-border`, `--color-input`, `--color-ring`
- `--color-popover`, `--color-popover-foreground`
- `--color-card`, `--color-card-foreground`

**Timing:**
- `--duration-fast` (150ms), `--duration-normal` (200ms), `--duration-slow` (300ms)
- `--ease-in-out`, `--ease-bounce`

**Brands:**
- `--brand-500`, `--brand-600`, `--accent-500`, etc.

## Batteries-Included-But-Swappable

Every complex component provides pre-styled sub-components that you can easily replace:

```blade
{{-- Default: uses pre-styled dropzone --}}
<x-pegboard::file-upload />

{{-- Custom: provide your own dropzone design --}}
<x-pegboard::file-upload>
    <x-slot:dropzone>
        <div class="my-custom-dropzone">
            Drop files here (your design)
        </div>
    </x-slot:dropzone>
</x-pegboard::file-upload>
```

Both work identically - your custom slot automatically receives all functionality.

## Documentation

Full component documentation available in the `docs/` directory:

- [Button](docs/button.md)
- [Input](docs/input.md)
- [File Upload](docs/file-upload.md)
- [Forms Guide](docs/forms.md)
- [Modal](docs/modal.md)
- [Carousel](docs/carousel.md)
- And 20+ more...

## Design Principles

### 1. CSS-First, Minimal JavaScript

Use modern HTML/CSS instead of JavaScript whenever possible:

```blade
{{-- Native <details> instead of Alpine.js toggle --}}
<details class="group">
    <summary>Click to expand</summary>
    <div>Content</div>
</details>

{{-- CSS animations instead of x-transition --}}
<dialog class="transition-discrete starting:opacity-0">
    Modal content
</dialog>
```

### 2. Livewire Compatible

All inputs work seamlessly with Livewire:

```blade
{{-- No x-model conflicts --}}
<x-pegboard::input wire:model.live="search" />
<x-pegboard::select wire:model="category" />
<x-pegboard::checkbox wire:model="terms" />
```

### 3. Progressive Enhancement

Components work with HTML/CSS, JavaScript enhances:

```blade
{{-- Works without JavaScript --}}
<x-pegboard::accordion>
    <x-pegboard::accordion.item>
        <x-pegboard::accordion.heading>Section 1</x-pegboard::accordion.heading>
        <x-pegboard::accordion.content>Content 1</x-pegboard::accordion.content>
    </x-pegboard::accordion.item>
</x-pegboard::accordion>

{{-- JavaScript adds smooth animations and keyboard navigation --}}
```

## Configuration

Minimal configuration at `config/pegboard.php`:

```php
return [
    'prefix' => 'pegboard',  // Component namespace
];
```

Visual customization is done via CSS custom properties (see Customization section above).

## Browser Support

- Chrome/Edge 119+
- Firefox 115+
- Safari 17.4+

Pegboard uses modern CSS features like `@starting-style`, `light-dark()`, `:has()`, and anchor positioning.

## Credits

- **Mohamed Sabri Ben Chaabane** - [sabri@stratosdigital.io](mailto:sabri@stratosdigital.io)
- Built with [Laravel](https://laravel.com), [Livewire](https://livewire.laravel.com), [Alpine.js](https://alpinejs.dev), and [Tailwind CSS](https://tailwindcss.com)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
