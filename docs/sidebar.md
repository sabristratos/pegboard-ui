# Sidebar Component

A responsive, accessible sidebar navigation component with mobile support, collapsible sections, nested navigation, and search functionality.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Structure](#component-structure)
- [Props Reference](#props-reference)
- [Sub-Components](#sub-components)
  - [Sidebar Header](#sidebar-header)
  - [Sidebar Nav](#sidebar-nav)
  - [Sidebar Item](#sidebar-item)
  - [Sidebar Section](#sidebar-section)
  - [Sidebar Search](#sidebar-search)
  - [Sidebar Footer](#sidebar-footer)
- [Features](#features)
  - [Responsive Behavior](#responsive-behavior)
  - [Mobile Overlay](#mobile-overlay)
  - [Active State Detection](#active-state-detection)
  - [Expandable/Collapsible Items](#expandablecollapsible-items)
  - [Keyboard Navigation](#keyboard-navigation)
- [Examples](#examples)
- [Accessibility](#accessibility)
- [Best Practices](#best-practices)
- [Theming](#theming)

## Overview

The Pegboard sidebar component provides a fully-featured navigation solution for your application. It automatically adapts to mobile screens with an overlay behavior, supports nested navigation with smooth animations, and includes built-in search functionality.

**Key Features:**
- Responsive design (always visible on desktop, toggle on mobile)
- Mobile overlay with smooth backdrop transitions
- Automatic active state detection
- Collapsible/expandable sections
- Nested navigation support
- Search functionality with keyboard shortcuts
- Icons and badges support
- Full keyboard accessibility
- Smooth animations
- Left or right positioning
- Semantic HTML with proper ARIA labels

## Basic Usage

### Simple Sidebar

```blade
<x-pegboard::sidebar>
    <x-slot:header>
        <h1 class="text-lg font-bold">My App</h1>
    </x-slot:header>

    <x-pegboard::sidebar.nav>
        <x-pegboard::sidebar.item href="/dashboard" icon="home">
            Dashboard
        </x-pegboard::sidebar.item>

        <x-pegboard::sidebar.item href="/users" icon="users">
            Users
        </x-pegboard::sidebar.item>

        <x-pegboard::sidebar.item href="/settings" icon="cog-6-tooth">
            Settings
        </x-pegboard::sidebar.item>
    </x-pegboard::sidebar.nav>
</x-pegboard::sidebar>
```

### With Mobile Toggle Button

```blade
{{-- In your header/navbar --}}
<button
    @click="document.querySelector('[data-sidebar]').dataset.open = 'true'"
    class="md:hidden"
>
    <x-pegboard::icon name="bars-3" class="h-6 w-6" />
</button>

{{-- Sidebar --}}
<x-pegboard::sidebar>
    {{-- Content --}}
</x-pegboard::sidebar>
```

## Component Structure

The sidebar consists of several modular parts:

```
<x-pegboard::sidebar>
    <x-slot:header>             <!-- Optional: Logo, brand, close button -->
    <x-pegboard::sidebar.search />  <!-- Optional: Search input -->
    <x-pegboard::sidebar.nav>   <!-- Main scrollable navigation area -->
        <x-pegboard::sidebar.section>  <!-- Optional: Grouped sections -->
            <x-pegboard::sidebar.item>  <!-- Navigation links -->
        </x-pegboard::sidebar.section>
    </x-pegboard::sidebar.nav>
    <x-slot:footer>             <!-- Optional: User profile, settings -->
</x-pegboard::sidebar>
```

## Props Reference

### Main Sidebar

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `position` | string | `'left'` | Sidebar position: `left` or `right` |
| `open` | bool | `false` | Initial open state on mobile |

### Sidebar Item

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `href` | string\|null | `null` | Link URL (creates `<a>` tag if provided) |
| `icon` | string\|null | `null` | Heroicon name for item icon |
| `badge` | string\|int\|null | `null` | Badge content (e.g., count, "New") |
| `active` | bool\|null | `null` | Explicitly set active state (auto-detected if null) |
| `expandable` | bool | `false` | Enables nested items (use with `nested` slot) |

### Sidebar Section

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | string\|null | `null` | Section heading text |

### Sidebar Search

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `placeholder` | string | `'Search...'` | Search input placeholder text |
| `shortcut` | array\|null | `null` | Keyboard shortcut (e.g., `['⌘', 'K']`) |

## Sub-Components

### Sidebar Header

Fixed header area containing logo/brand and mobile close button.

```blade
<x-pegboard::sidebar>
    <x-slot:header>
        {{-- Logo/Brand --}}
        <div class="flex items-center gap-2">
            <img src="/logo.svg" class="h-8 w-8" />
            <span class="font-bold text-lg">My App</span>
        </div>
    </x-slot:header>
</x-pegboard::sidebar>
```

**Features:**
- Automatically includes mobile close button with icon (hidden on desktop)
- Fixed at top, won't scroll with content
- Border bottom for visual separation
- Close button uses `x-mark` Heroicon

### Sidebar Nav

Scrollable navigation container.

```blade
<x-pegboard::sidebar.nav>
    <x-pegboard::sidebar.item href="/dashboard">
        Dashboard
    </x-pegboard::sidebar.item>

    <x-pegboard::sidebar.item href="/settings">
        Settings
    </x-pegboard::sidebar.item>
</x-pegboard::sidebar.nav>
```

**Features:**
- Scrollable when content exceeds viewport
- Custom scrollbar styling (`scrollbar-thin`)
- Flex-grows to fill available space

### Sidebar Item

Individual navigation link or expandable section.

#### Simple Link

```blade
<x-pegboard::sidebar.item
    href="/dashboard"
    icon="home"
>
    Dashboard
</x-pegboard::sidebar.item>
```

#### With Badge

```blade
<x-pegboard::sidebar.item
    href="/notifications"
    icon="bell"
    badge="5"
>
    Notifications
</x-pegboard::sidebar.item>
```

#### Expandable with Nested Items

```blade
<x-pegboard::sidebar.item
    icon="document-text"
    expandable
>
    Reports

    <x-slot:nested>
        <x-pegboard::sidebar.item href="/reports/sales">
            Sales Report
        </x-pegboard::sidebar.item>

        <x-pegboard::sidebar.item href="/reports/analytics">
            Analytics
        </x-pegboard::sidebar.item>

        <x-pegboard::sidebar.item href="/reports/inventory">
            Inventory
        </x-pegboard::sidebar.item>
    </x-slot:nested>
</x-pegboard::sidebar.item>
```

**Features:**
- Auto-detects active state based on current URL
- Smooth hover and focus transitions
- Supports icons (Heroicons)
- Supports badges (counts, labels)
- Expandable sections with smooth CSS animations
- Focus ring for keyboard navigation

### Sidebar Section

Groups related navigation items with optional label.

```blade
<x-pegboard::sidebar.nav>
    <x-pegboard::sidebar.section label="Main">
        <x-pegboard::sidebar.item href="/" icon="home">
            Dashboard
        </x-pegboard::sidebar.item>

        <x-pegboard::sidebar.item href="/inbox" icon="inbox">
            Inbox
        </x-pegboard::sidebar.item>
    </x-pegboard::sidebar.section>

    <x-pegboard::sidebar.section label="Management">
        <x-pegboard::sidebar.item href="/users" icon="users">
            Users
        </x-pegboard::sidebar.item>

        <x-pegboard::sidebar.item href="/settings" icon="cog">
            Settings
        </x-pegboard::sidebar.item>
    </x-pegboard::sidebar.section>
</x-pegboard::sidebar.nav>
```

**Features:**
- Optional uppercase label heading
- Automatic divider after section (except last one)
- Proper spacing between sections

### Sidebar Search

Search input with keyboard shortcut and clear button.

```blade
<x-pegboard::sidebar>
    <x-slot:header>
        <h1>My App</h1>
    </x-slot:header>

    <x-pegboard::sidebar.search
        placeholder="Search navigation..."
        :shortcut="['⌘', 'K']"
    />

    <x-pegboard::sidebar.nav>
        {{-- Navigation items --}}
    </x-pegboard::sidebar.nav>
</x-pegboard::sidebar>
```

**Features:**
- Debounced search input (150ms delay)
- Clear button (appears when typing)
- Keyboard shortcut indicator
- "No results" message
- Filters sidebar items in real-time
- Auto-focus support via keyboard shortcut

### Sidebar Footer

Fixed footer area for user profile or additional actions.

```blade
<x-pegboard::sidebar>
    {{-- Header & Nav --}}

    <x-slot:footer>
        <div class="flex items-center gap-3">
            <img src="{{ auth()->user()->avatar }}" class="h-8 w-8 rounded-full" />
            <div class="overflow-hidden">
                <p class="truncate text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </x-slot:footer>
</x-pegboard::sidebar>
```

**Features:**
- Fixed at bottom, won't scroll
- Border top for visual separation
- Automatic padding and spacing

## Features

### Responsive Behavior

**Desktop (≥768px):**
- Always visible
- Fixed 256px width (w-64)
- Cannot be closed
- Pushes content to the right

**Mobile (<768px):**
- Hidden by default
- Slides in from left with overlay
- Closes on backdrop click
- Closes on Escape key
- Closes when resizing to desktop

```blade
{{-- Automatically responsive, no configuration needed --}}
<x-pegboard::sidebar>
    {{-- Your navigation --}}
</x-pegboard::sidebar>
```

### Mobile Overlay

Dark backdrop appears behind sidebar on mobile:

```blade
{{-- Toggle sidebar from anywhere in your app --}}
<button @click="document.querySelector('[data-sidebar]').dataset.open = 'true'">
    Menu
</button>

{{-- Sidebar with auto-generated backdrop --}}
<x-pegboard::sidebar>
    {{-- Navigation --}}
</x-pegboard::sidebar>
```

**Backdrop features:**
- Semi-transparent overlay (50% opacity)
- Click anywhere to close sidebar
- Smooth fade transitions
- Only visible on mobile (automatically hidden on desktop)
- Positioned below sidebar for proper layering

### Active State Detection

Sidebar items automatically detect and highlight the active route:

```blade
{{-- Automatically active when on /dashboard --}}
<x-pegboard::sidebar.item href="/dashboard">
    Dashboard
</x-pegboard::sidebar.item>

{{-- Explicitly set active state --}}
<x-pegboard::sidebar.item href="/users" :active="true">
    Users
</x-pegboard::sidebar.item>

{{-- Active based on condition --}}
<x-pegboard::sidebar.item
    href="/reports"
    :active="request()->is('reports/*')"
>
    Reports
</x-pegboard::sidebar.item>
```

**Active styling:**
- Primary background color (`bg-sidebar-primary`)
- Primary foreground color (`text-sidebar-primary-foreground`)
- `data-active="true"` attribute for custom styling

**Inactive styling:**
- Transparent background
- Sidebar foreground color
- Hover: accent background and foreground

### Expandable/Collapsible Items

Uses native HTML `<details>` element for accessibility and smooth animations:

```blade
<x-pegboard::sidebar.item icon="folder" expandable>
    Projects

    <x-slot:nested>
        <x-pegboard::sidebar.item href="/projects/active">
            Active Projects
        </x-pegboard::sidebar.item>

        <x-pegboard::sidebar.item href="/projects/archived">
            Archived Projects
        </x-pegboard::sidebar.item>

        {{-- Nested items can also be expandable --}}
        <x-pegboard::sidebar.item icon="star" expandable>
            Favorites

            <x-slot:nested>
                <x-pegboard::sidebar.item href="/projects/favorites/recent">
                    Recent
                </x-pegboard::sidebar.item>
            </x-slot:nested>
        </x-pegboard::sidebar.item>
    </x-slot:nested>
</x-pegboard::sidebar.item>
```

**Features:**
- Click summary to expand/collapse
- Smooth height and opacity transitions
- Rotating chevron indicator
- Nested items indented with left border
- Keyboard accessible (Space/Enter to toggle)

### Keyboard Navigation

**Global shortcuts:**
- `Escape` - Close sidebar (mobile only)
- `Tab` / `Shift+Tab` - Navigate between items
- `Space` / `Enter` - Activate focused item or toggle expandable

**Search shortcuts:**
- Custom keyboard shortcut (e.g., `⌘K` or `Ctrl+K`)
- Auto-focus search input

**Accessibility:**
- Visible focus rings on keyboard navigation
- Skip to content link support
- Proper ARIA attributes
- Screen reader announcements

## Examples

### Complete Sidebar Example

```blade
<x-pegboard::sidebar>
    {{-- Header with logo --}}
    <x-slot:header>
        <div class="flex items-center gap-2">
            <img src="/logo.svg" class="h-8 w-8" />
            <span class="font-bold">Dashboard</span>
        </div>
    </x-slot:header>

    {{-- Search --}}
    <x-pegboard::sidebar.search :shortcut="['⌘', 'K']" />

    {{-- Navigation --}}
    <x-pegboard::sidebar.nav>
        {{-- Main section --}}
        <x-pegboard::sidebar.section label="Main">
            <x-pegboard::sidebar.item href="/dashboard" icon="home">
                Dashboard
            </x-pegboard::sidebar.item>

            <x-pegboard::sidebar.item href="/inbox" icon="inbox" badge="12">
                Inbox
            </x-pegboard::sidebar.item>

            <x-pegboard::sidebar.item href="/calendar" icon="calendar">
                Calendar
            </x-pegboard::sidebar.item>
        </x-pegboard::sidebar.section>

        {{-- Projects section with expandable items --}}
        <x-pegboard::sidebar.section label="Projects">
            <x-pegboard::sidebar.item icon="folder-open" expandable>
                All Projects

                <x-slot:nested>
                    <x-pegboard::sidebar.item href="/projects/web">
                        Web Projects
                    </x-pegboard::sidebar.item>

                    <x-pegboard::sidebar.item href="/projects/mobile">
                        Mobile Apps
                    </x-pegboard::sidebar.item>
                </x-slot:nested>
            </x-pegboard::sidebar.item>

            <x-pegboard::sidebar.item href="/projects/favorites" icon="star" badge="3">
                Favorites
            </x-pegboard::sidebar.item>
        </x-pegboard::sidebar.section>

        {{-- Settings section --}}
        <x-pegboard::sidebar.section label="Settings">
            <x-pegboard::sidebar.item href="/settings" icon="cog-6-tooth">
                Settings
            </x-pegboard::sidebar.item>

            <x-pegboard::sidebar.item href="/help" icon="question-mark-circle">
                Help & Support
            </x-pegboard::sidebar.item>
        </x-pegboard::sidebar.section>
    </x-pegboard::sidebar.nav>

    {{-- User profile footer --}}
    <x-slot:footer>
        <div class="flex items-center gap-3">
            <img src="{{ auth()->user()->avatar }}" class="h-8 w-8 rounded-full" />
            <div class="overflow-hidden flex-1">
                <p class="truncate text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </x-slot:footer>
</x-pegboard::sidebar>
```

### Right-Positioned Sidebar

```blade
<x-pegboard::sidebar position="right">
    {{-- Navigation --}}
</x-pegboard::sidebar>
```

### With Livewire Integration

```blade
{{-- Toggle from Livewire component --}}
<button wire:click="toggleSidebar">
    Toggle Sidebar
</button>

<x-pegboard::sidebar :open="$sidebarOpen">
    {{-- Navigation --}}
</x-pegboard::sidebar>
```

```php
// In your Livewire component
public bool $sidebarOpen = false;

public function toggleSidebar()
{
    $this->sidebarOpen = !$this->sidebarOpen;
}
```

**Alternative: Direct DOM manipulation from Livewire**

```blade
<button @click="document.querySelector('[data-sidebar]').dataset.open = 'true'">
    Open Sidebar
</button>

<x-pegboard::sidebar>
    {{-- Navigation --}}
</x-pegboard::sidebar>
```

### Custom Icon and Badge

```blade
<x-pegboard::sidebar.item href="/notifications" icon="bell" badge="New">
    Notifications
</x-pegboard::sidebar.item>

<x-pegboard::sidebar.item href="/messages" icon="envelope" badge="99+">
    Messages
</x-pegboard::sidebar.item>
```

### Nested Multi-Level Navigation

```blade
<x-pegboard::sidebar.item icon="document-text" expandable>
    Documentation

    <x-slot:nested>
        <x-pegboard::sidebar.item icon="book-open" expandable>
            Getting Started

            <x-slot:nested>
                <x-pegboard::sidebar.item href="/docs/installation">
                    Installation
                </x-pegboard::sidebar.item>

                <x-pegboard::sidebar.item href="/docs/configuration">
                    Configuration
                </x-pegboard::sidebar.item>
            </x-slot:nested>
        </x-pegboard::sidebar.item>

        <x-pegboard::sidebar.item href="/docs/api">
            API Reference
        </x-pegboard::sidebar.item>
    </x-slot:nested>
</x-pegboard::sidebar.item>
```

### Complete App Layout with Sidebar

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Your head content --}}
</head>
<body>
    {{-- Sidebar --}}
    <x-pegboard::sidebar>
        <x-slot:header>
            <div class="flex items-center gap-2">
                <img src="/logo.svg" class="h-8 w-8" />
                <span class="font-bold text-lg">My App</span>
            </div>
        </x-slot:header>

        <x-pegboard::sidebar.search placeholder="Search..." :shortcut="['⌘', 'K']" />

        <x-pegboard::sidebar.nav>
            <x-pegboard::sidebar.section label="Main">
                <x-pegboard::sidebar.item href="/" icon="home">
                    Dashboard
                </x-pegboard::sidebar.item>
                <x-pegboard::sidebar.item href="/projects" icon="folder" badge="5">
                    Projects
                </x-pegboard::sidebar.item>
            </x-pegboard::sidebar.section>

            <x-pegboard::sidebar.section label="Settings">
                <x-pegboard::sidebar.item href="/settings" icon="cog-6-tooth">
                    Settings
                </x-pegboard::sidebar.item>
            </x-pegboard::sidebar.section>
        </x-pegboard::sidebar.nav>

        <x-slot:footer>
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->avatar }}" class="h-8 w-8 rounded-full" />
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-muted-foreground truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </x-slot:footer>
    </x-pegboard::sidebar>

    {{-- Main content with offset for sidebar --}}
    <div class="md:pl-64">
        {{-- Mobile menu button --}}
        <header class="md:hidden sticky top-0 bg-background border-b border-border p-4">
            <button
                @click="document.querySelector('[data-sidebar]').dataset.open = 'true'"
                class="p-2 rounded-lg hover:bg-accent"
            >
                <x-pegboard::icon name="bars-3" class="h-6 w-6" />
            </button>
        </header>

        {{-- Page content --}}
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
```

## Accessibility

The sidebar component follows WCAG 2.1 AA guidelines:

### ARIA Attributes

- Proper navigation landmark with `role="navigation"`
- Descriptive labels with `aria-label`
- Dynamic state management for mobile overlay
- Accessible buttons with clear labels
- Visible focus indicators for keyboard navigation

### Keyboard Support

| Key | Action |
|-----|--------|
| `Tab` | Move focus to next interactive element |
| `Shift+Tab` | Move focus to previous interactive element |
| `Enter` / `Space` | Activate focused link or toggle expandable |
| `Escape` | Close sidebar (mobile) |

### Screen Reader Support

```blade
{{-- Screen reader announces: --}}
{{-- "Main navigation landmark" --}}
{{-- "Dashboard, link, current page" (when active) --}}
{{-- "Projects, 3 items, collapsed, button" (expandable) --}}
<x-pegboard::sidebar>
    <x-pegboard::sidebar.nav>
        <x-pegboard::sidebar.item href="/dashboard" :active="true">
            Dashboard
        </x-pegboard::sidebar.item>

        <x-pegboard::sidebar.item icon="folder" expandable badge="3">
            Projects
            <x-slot:nested>
                {{-- Nested items --}}
            </x-slot:nested>
        </x-pegboard::sidebar.item>
    </x-pegboard::sidebar.nav>
</x-pegboard::sidebar>
```

### Focus Management

- Visible focus rings on all interactive elements
- Keyboard users can navigate all menu items
- Proper focus management when opening and closing
- Screen readers announce all navigation items and their states

## Best Practices

### 1. Always Include a Header

```blade
{{-- ✅ Good - Clear branding --}}
<x-pegboard::sidebar>
    <x-slot:header>
        <h1>My Application</h1>
    </x-slot:header>
</x-pegboard::sidebar>

{{-- ❌ Bad - No context --}}
<x-pegboard::sidebar>
    <x-pegboard::sidebar.nav>
        {{-- Items --}}
    </x-pegboard::sidebar.nav>
</x-pegboard::sidebar>
```

### 2. Use Sections for Grouping

```blade
{{-- ✅ Good - Organized with sections --}}
<x-pegboard::sidebar.nav>
    <x-pegboard::sidebar.section label="Main">
        {{-- Main items --}}
    </x-pegboard::sidebar.section>

    <x-pegboard::sidebar.section label="Admin">
        {{-- Admin items --}}
    </x-pegboard::sidebar.section>
</x-pegboard::sidebar.nav>

{{-- ❌ Bad - Flat list without organization --}}
<x-pegboard::sidebar.nav>
    <x-pegboard::sidebar.item>Dashboard</x-pegboard::sidebar.item>
    <x-pegboard::sidebar.item>Users</x-pegboard::sidebar.item>
    <x-pegboard::sidebar.item>Settings</x-pegboard::sidebar.item>
    <x-pegboard::sidebar.item>Admin Panel</x-pegboard::sidebar.item>
</x-pegboard::sidebar.nav>
```

### 3. Use Icons for Better Scannability

```blade
{{-- ✅ Good - Icons help users scan quickly --}}
<x-pegboard::sidebar.item href="/dashboard" icon="home">
    Dashboard
</x-pegboard::sidebar.item>

{{-- ❌ Bad - Text-only items harder to scan --}}
<x-pegboard::sidebar.item href="/dashboard">
    Dashboard
</x-pegboard::sidebar.item>
```

### 4. Limit Nesting Depth

```blade
{{-- ✅ Good - 1-2 levels of nesting --}}
<x-pegboard::sidebar.item expandable>
    Projects
    <x-slot:nested>
        <x-pegboard::sidebar.item>Active</x-pegboard::sidebar.item>
        <x-pegboard::sidebar.item>Archived</x-pegboard::sidebar.item>
    </x-slot:nested>
</x-pegboard::sidebar.item>

{{-- ❌ Bad - 3+ levels is confusing --}}
<x-pegboard::sidebar.item expandable>
    Projects
    <x-slot:nested>
        <x-pegboard::sidebar.item expandable>
            Active
            <x-slot:nested>
                <x-pegboard::sidebar.item expandable>
                    2024
                    {{-- Too deep! --}}
                </x-pegboard::sidebar.item>
            </x-slot:nested>
        </x-pegboard::sidebar.item>
    </x-slot:nested>
</x-pegboard::sidebar.item>
```

### 5. Keep Navigation Concise

```blade
{{-- ✅ Good - 5-10 top-level items --}}
<x-pegboard::sidebar.nav>
    {{-- 7 main navigation items --}}
</x-pegboard::sidebar.nav>

{{-- ❌ Bad - 20+ items is overwhelming --}}
<x-pegboard::sidebar.nav>
    {{-- Too many items, use sections or nested items instead --}}
</x-pegboard::sidebar.nav>
```

### 6. Use Badges Sparingly

```blade
{{-- ✅ Good - Badges for important notifications --}}
<x-pegboard::sidebar.item href="/inbox" badge="5">
    Inbox
</x-pegboard::sidebar.item>

{{-- ❌ Bad - Badges on everything --}}
<x-pegboard::sidebar.item href="/dashboard" badge="12">Dashboard</x-pegboard::sidebar.item>
<x-pegboard::sidebar.item href="/users" badge="45">Users</x-pegboard::sidebar.item>
<x-pegboard::sidebar.item href="/settings" badge="3">Settings</x-pegboard::sidebar.item>
```

### 7. Provide Mobile Toggle Button

```blade
{{-- ✅ Good - Clear mobile menu button --}}
<header>
    <button @click="$refs.sidebar.dataset.open = 'true'" class="md:hidden">
        <x-pegboard::icon name="bars-3" />
        <span class="sr-only">Open menu</span>
    </button>
</header>

<x-pegboard::sidebar x-ref="sidebar">
    {{-- Navigation --}}
</x-pegboard::sidebar>
```

## Theming

The sidebar uses semantic color tokens defined in your theme:

```css
/* Sidebar theming in pegboard.css or your theme */
@theme inline {
    --color-sidebar: theme('colors.card');
    --color-sidebar-foreground: theme('colors.card-foreground');
    --color-sidebar-primary: theme('colors.primary');
    --color-sidebar-primary-foreground: theme('colors.primary-foreground');
    --color-sidebar-accent: theme('colors.accent');
    --color-sidebar-accent-foreground: theme('colors.accent-foreground');
    --color-sidebar-border: theme('colors.border');
}
```

### Custom Styling

```blade
{{-- Override background --}}
<x-pegboard::sidebar class="!bg-slate-900">
    {{-- Navigation --}}
</x-pegboard::sidebar>

{{-- Custom width --}}
<x-pegboard::sidebar class="!w-80">
    {{-- Navigation --}}
</x-pegboard::sidebar>
```

---

## Performance

The sidebar is built for optimal performance:

- Smooth CSS transitions without JavaScript overhead
- Native HTML elements for expandable sections
- Fixed positioning that doesn't cause page reflow
- Efficient search with debouncing
- Minimal JavaScript for essential interactions only

## Browser Support

- Chrome/Edge: Full support
- Firefox: Full support
- Safari: Full support (iOS 12+)
- Mobile browsers: Full touch and gesture support

## Additional Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev)
- [MDN: `<details>` Element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details)
- [WCAG 2.1 Navigation Guidelines](https://www.w3.org/WAI/WCAG21/quickref/?showtechniques=241#navigation-mechanisms)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
