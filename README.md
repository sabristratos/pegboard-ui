# Pegboard UI

A professional Alpine.js and TypeScript UI component library for TALL stack applications.

Built by [Stratos Digital](https://stratosdigital.io)

## Features

- **Alpine.js Components**: Lightweight, reactive components with full TypeScript support
- **Blade Components**: Server-side rendered components that integrate seamlessly with Laravel
- **TypeScript First**: Full type safety and IDE autocompletion
- **TALL Stack Optimized**: Built specifically for Tailwind, Alpine.js, Laravel, and Livewire
- **Dark Mode Support**: All components support dark mode out of the box
- **Customizable**: Extensive configuration options and theme support
- **Auto-discovery**: Automatic registration with Laravel's package discovery

## Requirements

- PHP 8.2 or higher
- Laravel 11.0 or 12.0
- Livewire 3.0 or higher
- Alpine.js 3.0 or higher
- Tailwind CSS

## Installation

Install the package via Composer:

```bash
composer require stratos/pegboard
```

Install the NPM package:

```bash
npm install @stratos/pegboard
```

Publish the package assets:

```bash
php artisan vendor:publish --tag=pegboard
```

Or publish specific resources:

```bash
# Publish configuration only
php artisan vendor:publish --tag=pegboard-config

# Publish views only
php artisan vendor:publish --tag=pegboard-views

# Publish compiled assets only
php artisan vendor:publish --tag=pegboard-assets
```

## Usage

### JavaScript Setup

Import and register Pegboard components in your main JavaScript file:

```javascript
import Alpine from 'alpinejs';
import Pegboard from '@stratos/pegboard';

// IMPORTANT: Register Pegboard BEFORE Alpine.start()
Alpine.plugin(Pegboard);

// Start Alpine - must be called AFTER all plugins
Alpine.start();
```

**⚠️ Important:** Pegboard must be registered as an Alpine plugin **before** calling `Alpine.start()`, otherwise the components won't be available.

Or import specific components:

```javascript
import { dropdown } from '@stratos/pegboard';

Alpine.data('pegboardDropdown', dropdown);
```

### Blade Components

Use Pegboard components in your Blade templates:

```blade
{{-- Button Component --}}
<x-pegboard::button variant="primary" size="md">
    Click Me
</x-pegboard::button>

{{-- Dropdown Component --}}
<x-pegboard::dropdown>
    <x-slot:trigger>
        <x-pegboard::button variant="secondary">
            Open Menu
        </x-pegboard::button>
    </x-slot:trigger>

    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Option 1</a>
    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Option 2</a>
</x-pegboard::dropdown>
```

### Alpine.js Components

Use Pegboard's Alpine.js components directly:

```html
<div x-data="pegboardDropdown()">
    <button @click="toggle">Toggle Dropdown</button>

    <div x-show="open" @click.away="close">
        Dropdown content
    </div>
</div>
```

### TypeScript Usage

Pegboard provides full TypeScript support:

```typescript
import type { ComponentFunction, DropdownData } from '@stratos/pegboard';

// Create custom components with full type safety
const myComponent: ComponentFunction<DropdownData> = function() {
    return {
        open: false,
        toggle() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        },
        isOpen() {
            return this.open;
        }
    };
};
```

## Components

### Form Components

#### Button

A versatile button component with multiple variants and sizes.

**Props:**
- `variant` - primary, secondary, danger, success, ghost (default: primary)
- `size` - xs, sm, md, lg (default: md)
- `type` - button, submit, reset (default: button)
- `disabled` - boolean (default: false)

```blade
<x-pegboard::button variant="danger" size="lg">
    Delete
</x-pegboard::button>
```

[Full Button Documentation](docs/components/button.md)

#### Input

A customizable text input with validation states and multiple sizes.

**Props:**
- `type` - text, email, password, number, etc. (default: text)
- `variant` - default, error, success (default: default)
- `size` - xs, sm, md, lg (default: md)
- `disabled` - boolean (default: false)

```blade
<x-pegboard::input
    variant="error"
    placeholder="Enter email"
    type="email"
/>
```

[Full Input Documentation](docs/components/input.md)

#### Textarea

A resizable textarea component with validation states.

**Props:**
- `variant` - default, error, success (default: default)
- `size` - xs, sm, md, lg (default: md)
- `rows` - number (default: 3)
- `disabled` - boolean (default: false)

```blade
<x-pegboard::textarea
    rows="5"
    placeholder="Enter your message..."
/>
```

[Full Textarea Documentation](docs/components/textarea.md)

#### Select

A styled select dropdown with validation states.

**Props:**
- `variant` - default, error, success (default: default)
- `size` - xs, sm, md, lg (default: md)
- `disabled` - boolean (default: false)

```blade
<x-pegboard::select variant="default" size="md">
    <option value="1">Option 1</option>
    <option value="2">Option 2</option>
</x-pegboard::select>
```

[Full Select Documentation](docs/components/select.md)

#### Radio

A customizable radio button with validation states, multiple sizes, and card variant.

**Props:**
- `value` - string|int (required)
- `variant` - default, error, success (default: default)
- `displayVariant` - default, card (default: default)
- `size` - xs, sm, md, lg (default: md)
- `disabled` - boolean (default: false)

```blade
<x-pegboard::radio.group wire:model="selectedPlan">
    <x-pegboard::radio value="basic" label="Basic Plan" />
    <x-pegboard::radio value="pro" label="Pro Plan" />
    <x-pegboard::radio value="enterprise" label="Enterprise Plan" />
</x-pegboard::radio.group>
```

[Full Radio Documentation](docs/components/radio.md)

#### Checkbox

A customizable checkbox with validation states, multiple sizes, card variant, and indeterminate state.

**Props:**
- `value` - string|int (required)
- `variant` - default, error, success (default: default)
- `displayVariant` - default, card (default: default)
- `size` - xs, sm, md, lg (default: md)
- `indeterminate` - boolean (default: false)
- `disabled` - boolean (default: false)

```blade
<x-pegboard::checkbox.group wire:model="selectedFeatures">
    <x-pegboard::checkbox value="analytics" label="Analytics" />
    <x-pegboard::checkbox value="reports" label="Reports" />
    <x-pegboard::checkbox value="api" label="API Access" />
</x-pegboard::checkbox.group>
```

[Full Checkbox Documentation](docs/components/checkbox.md)

### Layout Components

#### Dropdown

A flexible dropdown component with positioning options.

**Props:**
- `align` - left, right, top (default: right)
- `width` - 48, 64, 96 (default: 48)
- `contentClasses` - custom CSS classes for dropdown content

```blade
<x-pegboard::dropdown align="left" width="64">
    <x-slot:trigger>
        <button>Options</button>
    </x-slot:trigger>

    {{-- Dropdown content --}}
</x-pegboard::dropdown>
```

## Configuration

The package configuration file is located at `config/pegboard.php`:

```php
return [
    'prefix' => 'pegboard',
    'load_alpinejs' => true,
    'asset_path' => 'vendor/pegboard',
    'theme' => [
        'colors' => [
            'primary' => 'blue',
            'secondary' => 'gray',
            'success' => 'green',
            'danger' => 'red',
            'warning' => 'yellow',
            'info' => 'cyan',
        ],
    ],
    'dev_mode' => env('APP_DEBUG', false),
];
```

## Development

### Building the Package

```bash
# Install dependencies
cd packages/stratos/pegboard
npm install

# Build for production
npm run build

# Build and watch for changes
npm run dev

# Type check
npm run type-check
```

### Testing

```bash
# Run PHP tests
cd packages/stratos/pegboard
composer test

# Or from root
./vendor/bin/phpunit packages/stratos/pegboard
```

## Roadmap

### Completed ✅
- [x] Form components (Button, Input, Textarea, Select, Radio, Checkbox)

### In Progress
- [ ] Date picker
- [ ] Time picker
- [ ] Autocomplete

### Planned
- [ ] Modal component
- [ ] Toast/Notification component
- [ ] Accordion component
- [ ] Tabs component
- [ ] Loading states and skeletons
- [ ] Data tables
- [ ] File upload component
- [ ] Color picker
- [ ] Range slider

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Credits

- **Mohamed Sabri Ben Chaabane** - [sabri@stratosdigital.io](mailto:sabri@stratosdigital.io)
- Built with [Laravel](https://laravel.com), [Livewire](https://livewire.laravel.com), [Alpine.js](https://alpinejs.dev), and [Tailwind CSS](https://tailwindcss.com)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
