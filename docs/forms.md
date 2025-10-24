# Building Forms with Pegboard

A comprehensive guide to building accessible, production-ready forms using Pegboard's composable components and Livewire integration.

## Overview

Pegboard provides a complete form-building system with semantic HTML, built-in validation support, and seamless Livewire integration. Every component is designed to work together while maintaining flexibility for custom layouts.

**Design Philosophy:**
- **Composable** - Mix and match components to build any form layout
- **Accessible** - WCAG 2.1 compliant with proper ARIA attributes
- **Livewire-first** - Built specifically for Laravel Livewire applications
- **Validation-ready** - Automatic Laravel error bag integration
- **Theme-aware** - Consistent styling using semantic design tokens

---

## Features

- ✅ Complete form component library (inputs, selects, checkboxes, etc.)
- ✅ Field wrapper with block and inline layouts
- ✅ Labels with optional tooltip support
- ✅ Automatic Laravel error bag integration
- ✅ Button loading states for form submission
- ✅ Real-time validation with Livewire
- ✅ File upload with progress tracking
- ✅ Responsive layouts using container queries
- ✅ Accessible by default (ARIA, keyboard navigation)
- ✅ Dark mode support
- ✅ TypeScript definitions for all components

---

## Quick Start

```blade
<form wire:submit="save">
    <x-pegboard::field>
        <x-pegboard::label for="email">Email Address</x-pegboard::label>
        <x-pegboard::input
            id="email"
            type="email"
            wire:model="email"
            placeholder="john@example.com"
        />
        <x-pegboard::error name="email" />
    </x-pegboard::field>

    <x-pegboard::button type="submit" :loading="$isSaving">
        Save Changes
    </x-pegboard::button>
</form>
```

---

## Table of Contents

- [Form Components Reference](#form-components-reference)
- [Form Structure](#form-structure)
- [Field Wrapper Pattern](#field-wrapper-pattern)
- [Labels & Descriptions](#labels--descriptions)
- [Validation & Error Handling](#validation--error-handling)
- [Button Loading States](#button-loading-states)
- [Livewire Integration](#livewire-integration)
- [Accessibility](#accessibility)
- [Complete Examples](#complete-examples)
- [Common Patterns](#common-patterns)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)

---

## Form Components Reference

### Layout Components

| Component | Purpose | Key Props |
|-----------|---------|-----------|
| `<x-pegboard::field>` | Form field wrapper with consistent spacing | `variant="block\|inline"` |
| `<x-pegboard::label>` | Semantic label with tooltip support | `for`, `tooltip` |
| `<x-pegboard::legend>` | Fieldset legend for grouping | - |
| `<x-pegboard::description>` | Helper text below inputs | - |
| `<x-pegboard::error>` | Validation error display | `name`, `bag`, `message` |

### Input Components

| Component | Purpose | Documentation |
|-----------|---------|---------------|
| `<x-pegboard::input>` | Text inputs with variants, icons, prefix/suffix | [Input Docs](components/input.md) |
| `<x-pegboard::textarea>` | Multi-line text input | [Textarea Docs](components/textarea.md) |
| `<x-pegboard::select>` | Dropdown selection | [Select Docs](components/select.md) |
| `<x-pegboard::autocomplete>` | Searchable dropdown | [Autocomplete Docs](components/autocomplete.md) |
| `<x-pegboard::checkbox>` | Checkboxes and checkbox groups | [Checkbox Docs](components/checkbox.md) |
| `<x-pegboard::radio>` | Radio buttons and groups | [Radio Docs](components/radio.md) |
| `<x-pegboard::date-picker>` | Date selection with calendar | [DatePicker Docs](components/date-picker.md) |
| `<x-pegboard::time-picker>` | Time selection (12/24 hour) | [TimePicker Docs](components/time-picker.md) |
| `<x-pegboard::file-upload>` | File uploads with drag/drop | [File Upload Docs](file-upload.md) |

### Action Components

| Component | Purpose | Documentation |
|-----------|---------|---------------|
| `<x-pegboard::button>` | Buttons with loading states | [Button Docs](components/button.md) |

---

## Form Structure

### Basic Form Layout

The recommended pattern for building forms:

```blade
<form wire:submit="save">
    {{-- Text Input Field --}}
    <x-pegboard::field>
        <x-pegboard::label for="name">Full Name</x-pegboard::label>
        <x-pegboard::input id="name" wire:model="name" />
        <x-pegboard::error name="name" />
    </x-pegboard::field>

    {{-- Textarea Field --}}
    <x-pegboard::field>
        <x-pegboard::label for="bio">Biography</x-pegboard::label>
        <x-pegboard::textarea id="bio" wire:model="bio" rows="4" />
        <x-pegboard::description>
            Tell us a bit about yourself (optional)
        </x-pegboard::description>
        <x-pegboard::error name="bio" />
    </x-pegboard::field>

    {{-- Checkbox Field --}}
    <x-pegboard::field>
        <x-pegboard::checkbox wire:model="terms" value="1">
            I agree to the terms and conditions
        </x-pegboard::checkbox>
        <x-pegboard::error name="terms" />
    </x-pegboard::field>

    {{-- Submit Button --}}
    <x-pegboard::button type="submit" :loading="$isSaving">
        Save Profile
    </x-pegboard::button>
</form>
```

### Fieldset Grouping

Group related fields using `<fieldset>` and `<x-pegboard::legend>`:

```blade
<form wire:submit="save">
    <fieldset class="space-y-4">
        <x-pegboard::legend>Personal Information</x-pegboard::legend>

        <x-pegboard::field>
            <x-pegboard::label for="first_name">First Name</x-pegboard::label>
            <x-pegboard::input id="first_name" wire:model="first_name" />
            <x-pegboard::error name="first_name" />
        </x-pegboard::field>

        <x-pegboard::field>
            <x-pegboard::label for="last_name">Last Name</x-pegboard::label>
            <x-pegboard::input id="last_name" wire:model="last_name" />
            <x-pegboard::error name="last_name" />
        </x-pegboard::field>
    </fieldset>

    <fieldset class="space-y-4">
        <x-pegboard::legend>Contact Details</x-pegboard::legend>

        <x-pegboard::field>
            <x-pegboard::label for="email">Email</x-pegboard::label>
            <x-pegboard::input id="email" type="email" wire:model="email" />
            <x-pegboard::error name="email" />
        </x-pegboard::field>

        <x-pegboard::field>
            <x-pegboard::label for="phone">Phone</x-pegboard::label>
            <x-pegboard::input id="phone" type="tel" wire:model="phone" />
            <x-pegboard::error name="phone" />
        </x-pegboard::field>
    </fieldset>

    <x-pegboard::button type="submit">Save Changes</x-pegboard::button>
</form>
```

---

## Field Wrapper Pattern

The `<x-pegboard::field>` component provides consistent spacing and layout for form fields.

### Block Layout (Default)

Vertical stacked layout - label above input:

```blade
<x-pegboard::field>
    <x-pegboard::label for="email">Email Address</x-pegboard::label>
    <x-pegboard::input id="email" wire:model="email" />
    <x-pegboard::description>We'll never share your email</x-pegboard::description>
    <x-pegboard::error name="email" />
</x-pegboard::field>
```

**Visual Structure:**
```
┌─────────────────────────┐
│ Email Address           │ ← Label
├─────────────────────────┤
│ [input field here]      │ ← Input
├─────────────────────────┤
│ We'll never share...    │ ← Description
├─────────────────────────┤
│ Error message here      │ ← Error
└─────────────────────────┘
```

### Inline Layout

Horizontal layout - label beside input:

```blade
<x-pegboard::field variant="inline">
    <x-pegboard::label for="remember">Remember Me</x-pegboard::label>
    <x-pegboard::checkbox id="remember" wire:model="remember" />
</x-pegboard::field>
```

**Visual Structure:**
```
┌──────────────┬──────────────┐
│ Remember Me  │ [checkbox]   │
└──────────────┴──────────────┘
```

**Responsive Behavior:**

The inline variant uses container queries to automatically stack on narrow widths:

```blade
{{-- Automatically stacks when container is narrow --}}
<x-pegboard::field variant="inline">
    <x-pegboard::label for="newsletter">Subscribe to Newsletter</x-pegboard::label>
    <x-pegboard::checkbox id="newsletter" wire:model="newsletter" />
</x-pegboard::field>
```

### Without Field Wrapper

You can skip the field wrapper for custom layouts:

```blade
{{-- Custom grid layout --}}
<div class="grid grid-cols-2 gap-4">
    <div>
        <x-pegboard::label for="first_name">First Name</x-pegboard::label>
        <x-pegboard::input id="first_name" wire:model="first_name" />
        <x-pegboard::error name="first_name" />
    </div>

    <div>
        <x-pegboard::label for="last_name">Last Name</x-pegboard::label>
        <x-pegboard::input id="last_name" wire:model="last_name" />
        <x-pegboard::error name="last_name" />
    </div>
</div>
```

---

## Labels & Descriptions

### Basic Labels

Always associate labels with their inputs using the `for` attribute:

```blade
<x-pegboard::label for="username">Username</x-pegboard::label>
<x-pegboard::input id="username" wire:model="username" />
```

### Labels with Tooltips

Provide additional context via tooltip icons:

```blade
<x-pegboard::label
    for="api_key"
    tooltip="Your API key is used to authenticate API requests"
>
    API Key
</x-pegboard::label>
<x-pegboard::input id="api_key" wire:model="api_key" copy />
```

**Visual:** Label text + ⓘ icon (hover shows tooltip)

### Helper Descriptions

Use `<x-pegboard::description>` for longer explanatory text:

```blade
<x-pegboard::field>
    <x-pegboard::label for="bio">Biography</x-pegboard::label>
    <x-pegboard::textarea id="bio" wire:model="bio" />
    <x-pegboard::description>
        Write a brief description about yourself. This will be displayed publicly on your profile.
    </x-pegboard::description>
    <x-pegboard::error name="bio" />
</x-pegboard::field>
```

### Multiple Fields Sharing a Label

For checkbox/radio groups:

```blade
<fieldset>
    <x-pegboard::legend>Select Your Interests</x-pegboard::legend>
    <x-pegboard::description>Choose one or more topics</x-pegboard::description>

    <div class="space-y-2">
        <x-pegboard::checkbox wire:model="interests" value="tech">
            Technology
        </x-pegboard::checkbox>
        <x-pegboard::checkbox wire:model="interests" value="design">
            Design
        </x-pegboard::checkbox>
        <x-pegboard::checkbox wire:model="interests" value="business">
            Business
        </x-pegboard::checkbox>
    </div>

    <x-pegboard::error name="interests" />
</fieldset>
```

---

## Validation & Error Handling

Pegboard integrates seamlessly with Laravel's validation system.

### Laravel Error Bag Integration

The `<x-pegboard::error>` component automatically displays errors from Laravel's error bag:

```blade
<x-pegboard::field>
    <x-pegboard::label for="email">Email</x-pegboard::label>
    <x-pegboard::input id="email" wire:model="email" />
    <x-pegboard::error name="email" />
    {{-- Automatically displays $errors->first('email') --}}
</x-pegboard::field>
```

**Livewire Component:**
```php
namespace App\Livewire;

use Livewire\Component;

class UserForm extends Component
{
    public string $email = '';

    public function save()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        // Errors automatically displayed via <x-pegboard::error>
    }
}
```

### Custom Error Messages

Override default validation messages:

```php
public function save()
{
    $this->validate(
        ['email' => 'required|email|unique:users,email'],
        ['email.unique' => 'This email is already registered. Please use a different email or login.']
    );
}
```

### Multiple Error Bags

Handle multiple forms on the same page:

```blade
{{-- Login Form --}}
<form wire:submit="login">
    <x-pegboard::input wire:model="loginEmail" />
    <x-pegboard::error name="loginEmail" bag="login" />
</form>

{{-- Register Form --}}
<form wire:submit="register">
    <x-pegboard::input wire:model="registerEmail" />
    <x-pegboard::error name="registerEmail" bag="register" />
</form>
```

**Livewire Component:**
```php
public function login()
{
    $this->validate(
        ['loginEmail' => 'required|email'],
        [],
        [],
        'login' // Error bag name
    );
}

public function register()
{
    $this->validate(
        ['registerEmail' => 'required|email|unique:users,email'],
        [],
        [],
        'register' // Error bag name
    );
}
```

### Visual Error States

Use the `error` variant to highlight invalid fields:

```blade
<x-pegboard::input
    wire:model="email"
    :variant="$errors->has('email') ? 'error' : 'default'"
/>
<x-pegboard::error name="email" />
```

**Better approach - automatic variant:**

Create a helper method in your Livewire component:

```php
public function fieldVariant(string $field): string
{
    return $this->getErrorBag()->has($field) ? 'error' : 'default';
}
```

```blade
<x-pegboard::input
    wire:model="email"
    :variant="$this->fieldVariant('email')"
/>
<x-pegboard::error name="email" />
```

### Real-Time Validation

Validate as the user types:

```blade
<x-pegboard::field>
    <x-pegboard::label for="username">Username</x-pegboard::label>
    <x-pegboard::input
        id="username"
        wire:model.live.debounce.300ms="username"
        :variant="$this->fieldVariant('username')"
    />
    <x-pegboard::error name="username" />
</x-pegboard::field>
```

**Livewire Component:**
```php
use Livewire\Attributes\Validate;

#[Validate('required|min:3|max:20|alpha_dash|unique:users,username')]
public string $username = '';

public function updated($property)
{
    $this->validateOnly($property);
}
```

### Array Validation Errors

Display errors for array items:

```blade
@foreach($items as $index => $item)
    <x-pegboard::input wire:model="items.{{ $index }}.name" />
    <x-pegboard::error name="items.{{ $index }}.name" />
@endforeach

{{-- Or show generic array error --}}
<x-pegboard::error name="items.*" />
```

---

## Button Loading States

Show visual feedback during form submission.

### Basic Loading State

```blade
<x-pegboard::button
    type="submit"
    wire:click="save"
    :loading="$isSaving"
>
    Save Changes
</x-pegboard::button>
```

**Livewire Component:**
```php
public bool $isSaving = false;

public function save()
{
    $this->isSaving = true;

    try {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        // Save logic...

        session()->flash('message', 'Saved successfully!');
    } finally {
        $this->isSaving = false;
    }
}
```

### Custom Loading Text

```blade
<x-pegboard::button
    type="submit"
    :loading="$isSaving"
    loadingText="Saving..."
>
    Save Profile
</x-pegboard::button>
```

### Multiple Buttons with Different States

```blade
<div class="flex gap-2">
    <x-pegboard::button
        variant="outline"
        wire:click="saveDraft"
        :loading="$isSavingDraft"
        loadingText="Saving Draft..."
    >
        Save Draft
    </x-pegboard::button>

    <x-pegboard::button
        wire:click="publish"
        :loading="$isPublishing"
        loadingText="Publishing..."
    >
        Publish
    </x-pegboard::button>
</div>
```

**Livewire Component:**
```php
public bool $isSavingDraft = false;
public bool $isPublishing = false;

public function saveDraft()
{
    $this->isSavingDraft = true;
    // Save logic...
    $this->isSavingDraft = false;
}

public function publish()
{
    $this->isPublishing = true;
    // Publish logic...
    $this->isPublishing = false;
}
```

### Wire:loading Alternative

Use Livewire's wire:loading for simple cases:

```blade
<x-pegboard::button type="submit">
    <span wire:loading.remove wire:target="save">Save</span>
    <span wire:loading wire:target="save">Saving...</span>
</x-pegboard::button>
```

**Recommendation:** Use the `:loading` prop for cleaner templates.

---

## Livewire Integration

Pegboard components are built specifically for Livewire applications.

### Wire:model Modifiers

**Live updates (on every keystroke):**
```blade
<x-pegboard::input wire:model.live="search" />
```

**Debounced live updates:**
```blade
<x-pegboard::input wire:model.live.debounce.300ms="search" />
```

**On blur (when input loses focus):**
```blade
<x-pegboard::input wire:model.blur="email" />
```

**Deferred (on form submit only):**
```blade
<x-pegboard::input wire:model="name" />
{{-- Default behavior - updates on submit --}}
```

### Form Submission

```blade
<form wire:submit="save">
    <x-pegboard::field>
        <x-pegboard::label for="title">Title</x-pegboard::label>
        <x-pegboard::input id="title" wire:model="title" />
        <x-pegboard::error name="title" />
    </x-pegboard::field>

    <x-pegboard::button type="submit" :loading="$isSaving">
        Save Article
    </x-pegboard::button>
</form>
```

**Livewire Component:**
```php
namespace App\Livewire;

use Livewire\Component;

class ArticleForm extends Component
{
    public string $title = '';
    public bool $isSaving = false;

    public function save()
    {
        $this->isSaving = true;

        $validated = $this->validate([
            'title' => 'required|string|max:255',
        ]);

        // Create article...

        $this->isSaving = false;
        $this->redirect('/articles');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}
```

### Real-Time Validation

Validate fields as users interact:

```blade
<x-pegboard::field>
    <x-pegboard::label for="username">Username</x-pegboard::label>
    <x-pegboard::input
        id="username"
        wire:model.live.debounce.500ms="username"
        :variant="$errors->has('username') ? 'error' : 'default'"
    />
    <x-pegboard::description>
        @if($usernameAvailable && $username)
            <span class="text-success">✓ Username is available</span>
        @endif
    </x-pegboard::description>
    <x-pegboard::error name="username" />
</x-pegboard::field>
```

**Livewire Component:**
```php
use Livewire\Attributes\Validate;

#[Validate('required|min:3|max:20|alpha_dash|unique:users,username')]
public string $username = '';

public bool $usernameAvailable = false;

public function updatedUsername()
{
    $this->validateOnly('username');
    $this->usernameAvailable = !$this->getErrorBag()->has('username');
}
```

### File Upload with Progress

```blade
<x-pegboard::field>
    <x-pegboard::label for="avatar">Profile Picture</x-pegboard::label>
    <x-pegboard::file-upload wire:model="avatar">
        <x-pegboard::file-upload-dropzone
            heading="Drop image here"
            text="JPG, PNG, GIF up to 10MB"
        />
    </x-pegboard::file-upload>
    <x-pegboard::error name="avatar" />
</x-pegboard::field>
```

**Livewire Component:**
```php
use Livewire\WithFileUploads;

class ProfileForm extends Component
{
    use WithFileUploads;

    public $avatar;

    public function save()
    {
        $this->validate([
            'avatar' => 'image|max:10240',
        ]);

        $this->avatar->store('avatars', 'public');
    }
}
```

---

## Accessibility

Pegboard components follow WCAG 2.1 Level AA guidelines.

### Form Labels

**✅ Good - Proper label association:**
```blade
<x-pegboard::label for="email">Email Address</x-pegboard::label>
<x-pegboard::input id="email" wire:model="email" />
```

**❌ Bad - No label association:**
```blade
<label>Email</label>
<x-pegboard::input wire:model="email" />
```

### Required Fields

Indicate required fields visually and programmatically:

```blade
<x-pegboard::label for="name">
    Name <span class="text-destructive">*</span>
</x-pegboard::label>
<x-pegboard::input id="name" wire:model="name" required />
```

### Error Announcements

The `<x-pegboard::error>` component automatically announces errors to screen readers:

```blade
<x-pegboard::error name="email" />
{{-- Renders with proper ARIA attributes --}}
```

### Keyboard Navigation

All Pegboard components support full keyboard navigation:

- **Tab** - Move between fields
- **Shift + Tab** - Move backwards
- **Enter** - Submit forms (on buttons)
- **Space** - Toggle checkboxes/radio buttons
- **Arrow keys** - Navigate options in selects

### Focus Management

Maintain logical focus order:

```blade
<form wire:submit="save">
    {{-- Focus order: 1, 2, 3, 4 --}}
    <x-pegboard::input wire:model="firstName" /> {{-- 1 --}}
    <x-pegboard::input wire:model="lastName" />  {{-- 2 --}}
    <x-pegboard::input wire:model="email" />     {{-- 3 --}}
    <x-pegboard::button type="submit">Save</x-pegboard::button> {{-- 4 --}}
</form>
```

### Screen Reader Support

**Fieldset grouping:**
```blade
<fieldset>
    <x-pegboard::legend>Contact Information</x-pegboard::legend>
    {{-- Screen readers announce: "Contact Information, group" --}}

    <x-pegboard::field>
        <x-pegboard::label for="phone">Phone</x-pegboard::label>
        <x-pegboard::input id="phone" wire:model="phone" />
    </x-pegboard::field>
</fieldset>
```

**Helper descriptions:**
```blade
<x-pegboard::description id="email-help">
    We'll never share your email with anyone else.
</x-pegboard::description>
<x-pegboard::input
    wire:model="email"
    aria-describedby="email-help"
/>
{{-- Screen reader reads description after announcing the input --}}
```

---

## Complete Examples

### Login Form

```blade
<form wire:submit="login" class="space-y-6">
    <x-pegboard::field>
        <x-pegboard::label for="email">Email Address</x-pegboard::label>
        <x-pegboard::input
            id="email"
            type="email"
            wire:model="email"
            icon="envelope"
            placeholder="john@example.com"
            :variant="$errors->has('email') ? 'error' : 'default'"
        />
        <x-pegboard::error name="email" />
    </x-pegboard::field>

    <x-pegboard::field>
        <x-pegboard::label for="password">Password</x-pegboard::label>
        <x-pegboard::input
            id="password"
            type="password"
            wire:model="password"
            icon="lock-closed"
            showPassword
            placeholder="Enter your password"
            :variant="$errors->has('password') ? 'error' : 'default'"
        />
        <x-pegboard::error name="password" />
    </x-pegboard::field>

    <x-pegboard::field variant="inline">
        <x-pegboard::checkbox wire:model="remember" id="remember">
            Remember me
        </x-pegboard::checkbox>
    </x-pegboard::field>

    <div class="flex items-center justify-between">
        <x-pegboard::link href="/forgot-password">
            Forgot your password?
        </x-pegboard::link>

        <x-pegboard::button
            type="submit"
            :loading="$isLoggingIn"
            loadingText="Logging in..."
        >
            Log In
        </x-pegboard::button>
    </div>
</form>
```

### Registration Form

```blade
<form wire:submit="register" class="space-y-6">
    <div class="grid grid-cols-2 gap-4">
        <x-pegboard::field>
            <x-pegboard::label for="first_name">First Name</x-pegboard::label>
            <x-pegboard::input id="first_name" wire:model="first_name" />
            <x-pegboard::error name="first_name" />
        </x-pegboard::field>

        <x-pegboard::field>
            <x-pegboard::label for="last_name">Last Name</x-pegboard::label>
            <x-pegboard::input id="last_name" wire:model="last_name" />
            <x-pegboard::error name="last_name" />
        </x-pegboard::field>
    </div>

    <x-pegboard::field>
        <x-pegboard::label for="email">Email Address</x-pegboard::label>
        <x-pegboard::input
            id="email"
            type="email"
            wire:model.blur="email"
            icon="envelope"
            :variant="$errors->has('email') ? 'error' : 'default'"
        />
        <x-pegboard::error name="email" />
    </x-pegboard::field>

    <x-pegboard::field>
        <x-pegboard::label for="password">Password</x-pegboard::label>
        <x-pegboard::input
            id="password"
            type="password"
            wire:model="password"
            showPassword
            :variant="$errors->has('password') ? 'error' : 'default'"
        />
        <x-pegboard::description>
            Must be at least 8 characters
        </x-pegboard::description>
        <x-pegboard::error name="password" />
    </x-pegboard::field>

    <x-pegboard::field>
        <x-pegboard::label for="password_confirmation">Confirm Password</x-pegboard::label>
        <x-pegboard::input
            id="password_confirmation"
            type="password"
            wire:model="password_confirmation"
            showPassword
        />
        <x-pegboard::error name="password_confirmation" />
    </x-pegboard::field>

    <x-pegboard::field>
        <x-pegboard::checkbox wire:model="terms" value="1">
            I agree to the
            <x-pegboard::link href="/terms">Terms of Service</x-pegboard::link>
            and
            <x-pegboard::link href="/privacy">Privacy Policy</x-pegboard::link>
        </x-pegboard::checkbox>
        <x-pegboard::error name="terms" />
    </x-pegboard::field>

    <x-pegboard::button
        type="submit"
        :loading="$isRegistering"
        loadingText="Creating account..."
        class="w-full"
    >
        Create Account
    </x-pegboard::button>
</form>
```

### Profile Edit Form

```blade
<form wire:submit="save" class="space-y-6">
    {{-- Avatar Upload --}}
    <x-pegboard::field>
        <x-pegboard::label>Profile Picture</x-pegboard::label>
        <x-pegboard::file-upload-avatar
            wire:model="avatar"
            size="lg"
            description="JPG, PNG, or GIF up to 10MB"
        />
        <x-pegboard::error name="avatar" />
    </x-pegboard::field>

    {{-- Personal Information --}}
    <fieldset class="space-y-4">
        <x-pegboard::legend>Personal Information</x-pegboard::legend>

        <x-pegboard::field>
            <x-pegboard::label for="name">Display Name</x-pegboard::label>
            <x-pegboard::input
                id="name"
                wire:model="name"
                icon="user"
            />
            <x-pegboard::error name="name" />
        </x-pegboard::field>

        <x-pegboard::field>
            <x-pegboard::label for="bio">Biography</x-pegboard::label>
            <x-pegboard::textarea
                id="bio"
                wire:model="bio"
                rows="4"
            />
            <x-pegboard::description>
                Write a short bio about yourself (max 500 characters)
            </x-pegboard::description>
            <x-pegboard::error name="bio" />
        </x-pegboard::field>

        <x-pegboard::field>
            <x-pegboard::label for="website">Website</x-pegboard::label>
            <x-pegboard::input
                id="website"
                wire:model="website"
                icon="globe-alt"
                viewInNewPage
            >
                <x-slot:prefix>https://</x-slot:prefix>
            </x-pegboard::input>
            <x-pegboard::error name="website" />
        </x-pegboard::field>

        <x-pegboard::field>
            <x-pegboard::label for="country">Country</x-pegboard::label>
            <x-pegboard::select id="country" wire:model="country">
                <option value="">Select a country</option>
                <option value="US">United States</option>
                <option value="CA">Canada</option>
                <option value="GB">United Kingdom</option>
                <option value="AU">Australia</option>
            </x-pegboard::select>
            <x-pegboard::error name="country" />
        </x-pegboard::field>

        <x-pegboard::field>
            <x-pegboard::label for="birthdate">Date of Birth</x-pegboard::label>
            <x-pegboard::date-picker id="birthdate" wire:model="birthdate" />
            <x-pegboard::error name="birthdate" />
        </x-pegboard::field>
    </fieldset>

    {{-- Preferences --}}
    <fieldset class="space-y-4">
        <x-pegboard::legend>Email Preferences</x-pegboard::legend>

        <x-pegboard::checkbox wire:model="email_notifications" value="1">
            Receive email notifications
        </x-pegboard::checkbox>

        <x-pegboard::checkbox wire:model="newsletter" value="1">
            Subscribe to newsletter
        </x-pegboard::checkbox>
    </fieldset>

    {{-- Actions --}}
    <div class="flex gap-2">
        <x-pegboard::button
            variant="outline"
            wire:click="cancel"
        >
            Cancel
        </x-pegboard::button>

        <x-pegboard::button
            type="submit"
            :loading="$isSaving"
            loadingText="Saving..."
        >
            Save Changes
        </x-pegboard::button>
    </div>
</form>
```

### Search Form

```blade
<form wire:submit="search" class="space-y-4">
    <x-pegboard::field variant="inline">
        <x-pegboard::label for="query" class="sr-only">
            Search
        </x-pegboard::label>
        <x-pegboard::input
            id="query"
            wire:model.live.debounce.300ms="query"
            icon="magnifying-glass"
            clearable
            placeholder="Search products..."
            size="lg"
        />
    </x-pegboard::field>

    {{-- Live search results --}}
    @if($query && $results->isNotEmpty())
        <div class="border border-border rounded-lg divide-y">
            @foreach($results as $result)
                <a href="{{ $result->url }}" class="block p-4 hover:bg-muted">
                    <h3 class="font-medium">{{ $result->title }}</h3>
                    <p class="text-sm text-muted-foreground">{{ $result->description }}</p>
                </a>
            @endforeach
        </div>
    @endif
</form>
```

---

## Common Patterns

### Inline Editing

Toggle between view and edit mode:

```blade
@if($editing)
    <form wire:submit="save" class="flex gap-2">
        <x-pegboard::input wire:model="name" />
        <x-pegboard::button type="submit" size="sm" icon="check">
            Save
        </x-pegboard::button>
        <x-pegboard::button
            variant="outline"
            size="sm"
            icon="x-mark"
            wire:click="cancel"
        >
            Cancel
        </x-pegboard::button>
    </form>
@else
    <div class="flex items-center gap-2">
        <span>{{ $name }}</span>
        <x-pegboard::button
            variant="ghost"
            size="sm"
            icon="pencil"
            wire:click="edit"
        >
            Edit
        </x-pegboard::button>
    </div>
@endif
```

### Conditional Fields

Show/hide fields based on selections:

```blade
<x-pegboard::field>
    <x-pegboard::label for="account_type">Account Type</x-pegboard::label>
    <x-pegboard::select id="account_type" wire:model.live="accountType">
        <option value="personal">Personal</option>
        <option value="business">Business</option>
    </x-pegboard::select>
</x-pegboard::field>

@if($accountType === 'business')
    <x-pegboard::field>
        <x-pegboard::label for="company_name">Company Name</x-pegboard::label>
        <x-pegboard::input id="company_name" wire:model="companyName" />
        <x-pegboard::error name="companyName" />
    </x-pegboard::field>

    <x-pegboard::field>
        <x-pegboard::label for="tax_id">Tax ID</x-pegboard::label>
        <x-pegboard::input id="tax_id" wire:model="taxId" />
        <x-pegboard::error name="taxId" />
    </x-pegboard::field>
@endif
```

### Dynamic Field Addition

Add/remove fields dynamically:

```blade
<div class="space-y-4">
    @foreach($emails as $index => $email)
        <div class="flex gap-2">
            <x-pegboard::input
                wire:model="emails.{{ $index }}"
                placeholder="email@example.com"
                type="email"
            />
            <x-pegboard::button
                variant="outline"
                icon="x-mark"
                iconOnly
                wire:click="removeEmail({{ $index }})"
            >
                <span class="sr-only">Remove</span>
            </x-pegboard::button>
        </div>
        <x-pegboard::error name="emails.{{ $index }}" />
    @endforeach

    <x-pegboard::button
        variant="outline"
        icon="plus"
        wire:click="addEmail"
    >
        Add Email
    </x-pegboard::button>
</div>
```

**Livewire Component:**
```php
public array $emails = [''];

public function addEmail()
{
    $this->emails[] = '';
}

public function removeEmail(int $index)
{
    unset($this->emails[$index]);
    $this->emails = array_values($this->emails);
}
```

### Form in Modal

```blade
<x-pegboard::modal name="edit-user" dismissible>
    <x-slot:heading>Edit User</x-slot:heading>

    <form wire:submit="save">
        <div class="space-y-4">
            <x-pegboard::field>
                <x-pegboard::label for="name">Name</x-pegboard::label>
                <x-pegboard::input id="name" wire:model="name" />
                <x-pegboard::error name="name" />
            </x-pegboard::field>

            <x-pegboard::field>
                <x-pegboard::label for="email">Email</x-pegboard::label>
                <x-pegboard::input id="email" wire:model="email" />
                <x-pegboard::error name="email" />
            </x-pegboard::field>
        </div>

        <x-slot:actions>
            <x-pegboard::button
                variant="outline"
                x-on:click="$dispatch('close-modal', { name: 'edit-user' })"
            >
                Cancel
            </x-pegboard::button>
            <x-pegboard::button type="submit" :loading="$isSaving">
                Save
            </x-pegboard::button>
        </x-slot:actions>
    </form>
</x-pegboard::modal>
```

### Multi-Step Form

```blade
<form wire:submit="submit">
    {{-- Step Indicator --}}
    <div class="mb-6">
        <x-pegboard::tabs :activeTab="$currentStep">
            <x-pegboard::tab name="step1">Personal Info</x-pegboard::tab>
            <x-pegboard::tab name="step2">Account Details</x-pegboard::tab>
            <x-pegboard::tab name="step3">Preferences</x-pegboard::tab>
        </x-pegboard::tabs>
    </div>

    {{-- Step 1: Personal Info --}}
    @if($currentStep === 'step1')
        <div class="space-y-4">
            <x-pegboard::field>
                <x-pegboard::label for="first_name">First Name</x-pegboard::label>
                <x-pegboard::input id="first_name" wire:model="first_name" />
                <x-pegboard::error name="first_name" />
            </x-pegboard::field>

            <x-pegboard::field>
                <x-pegboard::label for="last_name">Last Name</x-pegboard::label>
                <x-pegboard::input id="last_name" wire:model="last_name" />
                <x-pegboard::error name="last_name" />
            </x-pegboard::field>

            <x-pegboard::button wire:click="nextStep">
                Continue
            </x-pegboard::button>
        </div>
    @endif

    {{-- Step 2: Account Details --}}
    @if($currentStep === 'step2')
        <div class="space-y-4">
            <x-pegboard::field>
                <x-pegboard::label for="email">Email</x-pegboard::label>
                <x-pegboard::input id="email" wire:model="email" />
                <x-pegboard::error name="email" />
            </x-pegboard::field>

            <x-pegboard::field>
                <x-pegboard::label for="password">Password</x-pegboard::label>
                <x-pegboard::input id="password" type="password" wire:model="password" showPassword />
                <x-pegboard::error name="password" />
            </x-pegboard::field>

            <div class="flex gap-2">
                <x-pegboard::button variant="outline" wire:click="previousStep">
                    Back
                </x-pegboard::button>
                <x-pegboard::button wire:click="nextStep">
                    Continue
                </x-pegboard::button>
            </div>
        </div>
    @endif

    {{-- Step 3: Preferences --}}
    @if($currentStep === 'step3')
        <div class="space-y-4">
            <x-pegboard::checkbox wire:model="newsletter" value="1">
                Subscribe to newsletter
            </x-pegboard::checkbox>

            <div class="flex gap-2">
                <x-pegboard::button variant="outline" wire:click="previousStep">
                    Back
                </x-pegboard::button>
                <x-pegboard::button type="submit" :loading="$isSubmitting">
                    Complete Registration
                </x-pegboard::button>
            </div>
        </div>
    @endif
</form>
```

---

## Best Practices

### 1. Always Use Field Wrappers

**✅ Good:**
```blade
<x-pegboard::field>
    <x-pegboard::label for="email">Email</x-pegboard::label>
    <x-pegboard::input id="email" wire:model="email" />
    <x-pegboard::error name="email" />
</x-pegboard::field>
```

**❌ Bad:**
```blade
<x-pegboard::label for="email">Email</x-pegboard::label>
<x-pegboard::input id="email" wire:model="email" />
<x-pegboard::error name="email" />
```

### 2. Match Error Variants with Error Display

**✅ Good:**
```blade
<x-pegboard::input
    wire:model="email"
    :variant="$errors->has('email') ? 'error' : 'default'"
/>
<x-pegboard::error name="email" />
```

**❌ Bad:**
```blade
<x-pegboard::input wire:model="email" />
<x-pegboard::error name="email" />
{{-- No visual indication on the input itself --}}
```

### 3. Provide Clear Labels and Descriptions

**✅ Good:**
```blade
<x-pegboard::field>
    <x-pegboard::label for="api_key">API Key</x-pegboard::label>
    <x-pegboard::input id="api_key" wire:model="api_key" copy />
    <x-pegboard::description>
        Your API key is used to authenticate requests to our API. Keep it secure.
    </x-pegboard::description>
    <x-pegboard::error name="api_key" />
</x-pegboard::field>
```

**❌ Bad:**
```blade
<x-pegboard::input wire:model="api_key" placeholder="Key" />
```

### 4. Use Appropriate Input Types

**✅ Good:**
```blade
<x-pegboard::input type="email" wire:model="email" />
<x-pegboard::input type="tel" wire:model="phone" />
<x-pegboard::input type="url" wire:model="website" />
<x-pegboard::input type="number" wire:model="age" />
<x-pegboard::input type="password" wire:model="password" showPassword />
```

**❌ Bad:**
```blade
<x-pegboard::input type="text" wire:model="email" />
{{-- Use type="email" for better validation and mobile keyboard --}}
```

### 5. Show Loading States on Submit Buttons

**✅ Good:**
```blade
<x-pegboard::button
    type="submit"
    :loading="$isSaving"
    loadingText="Saving..."
>
    Save Changes
</x-pegboard::button>
```

**❌ Bad:**
```blade
<x-pegboard::button type="submit">
    Save Changes
</x-pegboard::button>
{{-- No feedback during submission --}}
```

### 6. Validate on Both Client and Server

**✅ Good:**
```blade
<x-pegboard::input
    type="email"
    required
    wire:model.blur="email"
/>
```

```php
public function save()
{
    $this->validate([
        'email' => 'required|email|unique:users,email',
    ]);
}
```

**❌ Bad:**
```blade
<x-pegboard::input wire:model="email" />
```

```php
public function save()
{
    // No validation - security risk!
    User::create(['email' => $this->email]);
}
```

### 7. Use Debouncing for Live Updates

**✅ Good:**
```blade
<x-pegboard::input
    wire:model.live.debounce.300ms="search"
    placeholder="Search..."
/>
```

**❌ Bad:**
```blade
<x-pegboard::input
    wire:model.live="search"
    placeholder="Search..."
/>
{{-- Sends request on every keystroke --}}
```

### 8. Group Related Fields with Fieldsets

**✅ Good:**
```blade
<fieldset class="space-y-4">
    <x-pegboard::legend>Shipping Address</x-pegboard::legend>
    <x-pegboard::field><!-- address fields --></x-pegboard::field>
    <x-pegboard::field><!-- city field --></x-pegboard::field>
    <x-pegboard::field><!-- zip field --></x-pegboard::field>
</fieldset>
```

**❌ Bad:**
```blade
<div class="space-y-4">
    <h3>Shipping Address</h3>
    {{-- Fields without semantic grouping --}}
</div>
```

### 9. Provide Helpful Error Messages

**✅ Good:**
```php
protected $messages = [
    'email.required' => 'Please enter your email address.',
    'email.email' => 'Please enter a valid email address.',
    'email.unique' => 'This email is already registered. Please use a different email or login.',
];
```

**❌ Bad:**
```php
// Using default Laravel error messages
// "The email field is required."
// "The email must be a valid email address."
```

### 10. Mobile-Friendly Layouts

**✅ Good:**
```blade
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-pegboard::field>
        <x-pegboard::label for="first_name">First Name</x-pegboard::label>
        <x-pegboard::input id="first_name" wire:model="first_name" />
    </x-pegboard::field>

    <x-pegboard::field>
        <x-pegboard::label for="last_name">Last Name</x-pegboard::label>
        <x-pegboard::input id="last_name" wire:model="last_name" />
    </x-pegboard::field>
</div>
```

**❌ Bad:**
```blade
<div class="grid grid-cols-2 gap-4">
    {{-- Always 2 columns, even on mobile --}}
</div>
```

---

## Troubleshooting

### Error Display Not Working

**Problem:** `<x-pegboard::error>` doesn't show validation errors

**Solution:**
```blade
{{-- ✅ Make sure the name matches the property --}}
<x-pegboard::input wire:model="email" />
<x-pegboard::error name="email" /> {{-- Not "user.email" or "form.email" --}}
```

**Also check:**
- Validation is actually running in Livewire component
- Error bag name matches (default is 'default')
- Property name in component matches input name

### Loading State Not Showing

**Problem:** Button doesn't show loading state during submission

**Solution:**
```php
// ✅ Set loading property before long operations
public function save()
{
    $this->isSaving = true;

    try {
        // Long operation...
    } finally {
        $this->isSaving = false; // Reset even if error
    }
}
```

### Wire:model Not Updating

**Problem:** Input value doesn't sync with Livewire property

**Solution:**
```php
// ✅ Make sure property is public
public string $email = ''; // Not private or protected

// ✅ Property name matches wire:model
<x-pegboard::input wire:model="email" />
```

### File Upload Progress Not Tracking

**Problem:** Upload progress bar not showing

**Solution:**
```blade
{{-- ✅ Make sure wire:model is present --}}
<x-pegboard::file-upload wire:model="file">
    <x-pegboard::file-upload-dropzone with-progress />
</x-pegboard::file-upload>
```

```php
// ✅ Use WithFileUploads trait
use Livewire\WithFileUploads;

class FileForm extends Component
{
    use WithFileUploads;

    public $file;
}
```

### Validation Not Triggering on Blur

**Problem:** `wire:model.blur` doesn't validate

**Solution:**
```php
// ✅ Implement updated() hook
public function updated($property)
{
    $this->validateOnly($property);
}

// Or use Validate attribute
use Livewire\Attributes\Validate;

#[Validate('required|email')]
public string $email = '';
```

### Form Submission Reloading Page

**Problem:** Form submits and page reloads

**Solution:**
```blade
{{-- ✅ Use wire:submit instead of just submit --}}
<form wire:submit="save">
    {{-- Not: <form action="..." method="POST"> --}}
</form>
```

### Input Value Not Clearing After Submit

**Problem:** Form values persist after successful submission

**Solution:**
```php
public function save()
{
    $this->validate([...]);

    // Save logic...

    // ✅ Reset form properties
    $this->reset(['name', 'email', 'message']);

    session()->flash('message', 'Form submitted successfully!');
}
```

---

## Additional Resources

- [Pegboard Component Documentation](README.md)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Laravel Validation](https://laravel.com/docs/validation)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Tailwind CSS v4](https://tailwindcss.com/docs)

---

## Support

For issues, questions, or feature requests related to Pegboard forms, please open an issue in the Pegboard UI repository.
