# Tabs Component

A comprehensive, accessible tabs component for organizing content into switchable views with support for multiple variants, sizes, icons, badges, and advanced features.

> **⚠️ Component Structure Update**
> The tab components have been reorganized into a subfolder structure. Use:
> - `<x-pegboard::tab>` - Visual container (was `<x-pegboard::tabs>`)
> - `<x-pegboard::tab.group>` - Alpine context (was `<x-pegboard::tab-group>`)
> - `<x-pegboard::tab.button>` - Individual tab (was `<x-pegboard::tab>`)
> - `<x-pegboard::tab.panel>` - Content panel (was `<x-pegboard::tab-panel>`)
>
> Examples throughout this doc reflect the new structure. The old component names are no longer available.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Structure](#component-structure)
- [Props Reference](#props-reference)
- [Variants](#variants)
- [Sizes](#sizes)
- [Features](#features)
  - [Icons](#icons)
  - [Badges](#badges)
  - [Loading State](#loading-state)
  - [Disabled Tabs](#disabled-tabs)
  - [Scrollable Tabs](#scrollable-tabs)
  - [Icon-Only Tabs](#icon-only-tabs)
- [Sub-Components](#sub-components)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard tabs component provides a fully accessible, keyboard-navigable way to organize content into switchable panels. Built with Alpine.js and Tailwind CSS v4, it features smooth animations, multiple visual styles, and comprehensive functionality.

**Key Features:**
- Three visual variants (default, segmented, pills)
- Three size options (sm, base, lg)
- Vertical and horizontal orientation support
- Icon support with multiple positions
- Badge notifications with color variants
- Loading state indicators
- Disabled tab states
- Scrolling with fade effects (horizontal and vertical)
- Icon-only tabs for compact UIs
- Pure Tailwind CSS styling (no custom CSS)
- Full keyboard navigation (arrows, Home, End)
- ARIA-compliant for screen readers

## Basic Usage

The simplest tabs implementation requires a tab group wrapping tabs and panels:

```blade
<x-pegboard::tab.group>
    <x-pegboard::tab>
        <x-pegboard::tab.button name="profile">Profile</x-pegboard::tab.button>
        <x-pegboard::tab.button name="account">Account</x-pegboard::tab.button>
        <x-pegboard::tab.button name="billing">Billing</x-pegboard::tab.button>
    </x-pegboard::tab>

    <div class="mt-6">
        <x-pegboard::tab.panel name="profile">
            <p>Profile content...</p>
        </x-pegboard::tab.panel>
        <x-pegboard::tab.panel name="account">
            <p>Account settings...</p>
        </x-pegboard::tab.panel>
        <x-pegboard::tab.panel name="billing">
            <p>Billing information...</p>
        </x-pegboard::tab.panel>
    </div>
</x-pegboard::tab.group>
```

**How it works:**
- Each `<x-pegboard::tab.button>` has a `name` attribute
- Each `<x-pegboard::tab.panel>` has a matching `name` attribute
- Clicking a tab button shows the panel with the same `name`
- The `<x-pegboard::tab.group>` provides Alpine.js context for both buttons and panels
- The `<x-pegboard::tab>` provides the visual container

## Component Structure

The tabs component uses a hierarchical structure with Alpine.js for state management:

```
<x-pegboard::tab.group>                  <!-- Alpine.js context (x-data) -->
    <x-pegboard::tab>                    <!-- Visual container for tab buttons -->
        <x-pegboard::tab.button name="...">  <!-- Individual tab button -->
    </x-pegboard::tab>

    <div>                                <!-- Optional wrapper -->
        <x-pegboard::tab.panel name="...">   <!-- Content panel -->
    </div>
</x-pegboard::tab.group>
```

**Important:** The `tab.group` component provides the Alpine.js scope. Both tab buttons and panels must be descendants of the same `tab.group` to function properly.

## Props Reference

### TabGroup (Root Component)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | `null` | Optional unique identifier for the tab group |
| `variant` | string | `'default'` | Visual style: `default`, `segmented`, `pills` |
| `size` | string | `'base'` | Tab size: `sm`, `base`, `lg` |
| `orientation` | string | `'horizontal'` | Tab orientation: `horizontal`, `vertical` |
| `scrollable` | boolean | `false` | Enable scrolling (horizontal or vertical based on orientation) |
| `scrollable-fade` | string | `null` | Show fade overlays when scrollable: `'true'` |
| `scrollable-scrollbar` | string | `null` | Scrollbar visibility: `'hide'` or default |
| `padded` | boolean | `false` | Add padding to tabs (horizontal for horizontal, vertical for vertical) |

**Alpine.js State (internal):**
- `activeTab` - Currently selected tab name
- `variant` - Current variant
- `size` - Current size
- `orientation` - Current orientation
- `tabButtons` - Array of registered tab elements
- `showLeftFade` / `showRightFade` - Scroll fade visibility (top/bottom for vertical)

### Tabs (Visual Container)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Visual style (inherited from tab-group if not set) |
| `size` | string | `'base'` | Tab size (inherited from tab-group if not set) |
| `orientation` | string | `'horizontal'` | Tab orientation: `horizontal`, `vertical` |
| `scrollable` | boolean | `false` | Enable scrolling (direction based on orientation) |
| `scrollable-fade` | string | `null` | Show fade overlays: `'true'` |
| `scrollable-scrollbar` | string | `null` | Scrollbar visibility: `'hide'` |
| `padded` | boolean | `false` | Add padding (direction based on orientation) |

### Tab (Individual Tab Button)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | **required** | Unique identifier matching a tab-panel |
| `icon` | string | `null` | Heroicon name to display |
| `icon-trailing` | string | `null` | Heroicon name to display after text |
| `icon-variant` | string | `'mini'` | Icon variant: `mini`, `outline`, `solid` |
| `badge` | string\|int | `null` | Badge content (number or text) |
| `badge-variant` | string | `'default'` | Badge color: `default`, `primary`, `success`, `warning`, `danger` |
| `loading` | boolean | `false` | Show loading spinner |
| `disabled` | boolean | `false` | Disable tab interaction |
| `action` | boolean | `false` | Style as an action tab (no active state) |
| `accent` | boolean | `false` | Use accent color when active |

### TabPanel (Content Panel)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | **required** | Unique identifier matching a tab |

## Variants

### Default (Underlined)

Classic underlined tabs with a bottom border indicator. Perfect for full-page navigation.

```blade
<x-pegboard::tab-group variant="default">
    <x-pegboard::tabs>
        <x-pegboard::tab name="home">Home</x-pegboard::tab>
        <x-pegboard::tab name="about">About</x-pegboard::tab>
    </x-pegboard::tabs>
    <!-- panels -->
</x-pegboard::tab-group>
```

**Visual characteristics:**
- Colored border on active tab (bottom for horizontal, left for vertical)
- Text color changes from muted to foreground when active
- Minimal background styling
- Horizontal layout with border-bottom separator on container

### Segmented (Button Group)

Button-style tabs in a segmented control. Ideal for view switchers in constrained spaces.

```blade
<x-pegboard::tab-group variant="segmented">
    <x-pegboard::tabs variant="segmented">
        <x-pegboard::tab name="list" icon="list-bullet">List</x-pegboard::tab>
        <x-pegboard::tab name="grid" icon="squares-2x2">Grid</x-pegboard::tab>
    </x-pegboard::tabs>
    <!-- panels -->
</x-pegboard::tab-group>
```

**Visual characteristics:**
- Card background container with border and rounded corners
- Active tab gets subtle muted background (`bg-muted/30`)
- Text color changes from muted to foreground when active
- Flex layout with equal-width buttons

### Pills (Rounded)

Rounded pill-style tabs with a softer appearance. Great for filter or category selection.

```blade
<x-pegboard::tab-group variant="pills">
    <x-pegboard::tabs variant="pills">
        <x-pegboard::tab name="all">All</x-pegboard::tab>
        <x-pegboard::tab name="active">Active</x-pegboard::tab>
        <x-pegboard::tab name="archived">Archived</x-pegboard::tab>
    </x-pegboard::tabs>
    <!-- panels -->
</x-pegboard::tab-group>
```

**Visual characteristics:**
- Fully rounded corners (`rounded-full`)
- Active tab gets card background with shadow and subtle border
- Text color changes from muted to foreground when active
- Gap spacing between pills
- Hover state shows muted background on inactive pills

## Sizes

Control tab padding and text size across all variants:

| Size | Padding | Font Size | Use Case |
|------|---------|-----------|----------|
| `sm` | Compact | Small (`text-sm`) | Tight layouts, toolbars, dense interfaces |
| `base` | Standard | Default | Most use cases, standard navigation |
| `lg` | Spacious | Large (`text-lg`) | Prominent navigation, landing pages |

```blade
{{-- Small tabs --}}
<x-pegboard::tab-group size="sm">
    <x-pegboard::tabs size="sm">
        <!-- Compact tabs -->
    </x-pegboard::tabs>
</x-pegboard::tab-group>

{{-- Large tabs --}}
<x-pegboard::tab-group size="lg">
    <x-pegboard::tabs variant="pills" size="lg">
        <!-- Spacious pills -->
    </x-pegboard::tabs>
</x-pegboard::tab-group>
```

**Size applies to:**
- Tab padding (horizontal and vertical)
- Font size
- Icon size (proportional)
- Badge size (proportional)

## Orientation

Control the layout direction of tabs - horizontal (default) or vertical for sidebar-style navigation.

### Horizontal (Default)

Standard horizontal tab layout with tabs arranged left-to-right:

```blade
<x-pegboard::tab.group orientation="horizontal">
    <x-pegboard::tab orientation="horizontal">
        <x-pegboard::tab.button name="home">Home</x-pegboard::tab.button>
        <x-pegboard::tab.button name="about">About</x-pegboard::tab.button>
        <x-pegboard::tab.button name="contact">Contact</x-pegboard::tab.button>
    </x-pegboard::tab>
</x-pegboard::tab.group>
```

**Visual characteristics:**
- Tabs flow left-to-right in a row
- Default variant: Active tab shows colored bottom border (`border-b-primary`)
- Scrolls horizontally when `scrollable` is enabled
- Left/right fade overlays when `scrollable-fade` is enabled

### Vertical

Vertical tab layout perfect for sidebar navigation or settings panels:

```blade
<x-pegboard::tab.group orientation="vertical" class="flex gap-6">
    <x-pegboard::tab orientation="vertical">
        <x-pegboard::tab.button name="dashboard" icon="home">Dashboard</x-pegboard::tab.button>
        <x-pegboard::tab.button name="analytics" icon="chart-bar">Analytics</x-pegboard::tab.button>
        <x-pegboard::tab.button name="settings" icon="cog-6-tooth">Settings</x-pegboard::tab.button>
    </x-pegboard::tab>

    <div class="p-4 bg-muted/50 rounded-lg flex-1">
        <x-pegboard::tab.panel name="dashboard">
            <h3 class="text-lg font-semibold mb-2">Dashboard</h3>
            <p>Your dashboard overview...</p>
        </x-pegboard::tab.panel>
        <x-pegboard::tab.panel name="analytics">
            <h3 class="text-lg font-semibold mb-2">Analytics</h3>
            <p>View your analytics...</p>
        </x-pegboard::tab.panel>
        <x-pegboard::tab.panel name="settings">
            <h3 class="text-lg font-semibold mb-2">Settings</h3>
            <p>Configure your settings...</p>
        </x-pegboard::tab.panel>
    </div>
</x-pegboard::tab.group>
```

**Visual characteristics:**
- Tabs stack vertically in a column
- Automatic width (`min-w-48`) - no custom styling needed
- Full-width buttons with left-aligned text
- Default variant: Active tab shows colored left border (`border-l-primary`)
- Scrolls vertically when `scrollable` is enabled
- Top/bottom fade overlays when `scrollable-fade` is enabled

**Layout tip:** Use `flex gap-6` on the `tab.group` to create a side-by-side layout with tabs on the left and panels on the right.

### Keyboard Navigation

Keyboard navigation automatically adapts to orientation:

| Orientation | Next Tab | Previous Tab |
|-------------|----------|--------------|
| Horizontal | `→` (Right Arrow) | `←` (Left Arrow) |
| Vertical | `↓` (Down Arrow) | `↑` (Up Arrow) |

Both orientations support:
- `Home` - Jump to first tab
- `End` - Jump to last tab
- `Space` / `Enter` - Activate focused tab

## Features

### Icons

Add icons before or after tab text using Heroicons:

```blade
{{-- Icon before text --}}
<x-pegboard::tab name="user" icon="user">Profile</x-pegboard::tab>

{{-- Icon after text --}}
<x-pegboard::tab name="settings" icon-trailing="arrow-right">Next</x-pegboard::tab>

{{-- Both icons --}}
<x-pegboard::tab name="help" icon="question-mark-circle" icon-trailing="arrow-top-right-on-square">
    Help Docs
</x-pegboard::tab>

{{-- Custom icon variant --}}
<x-pegboard::tab name="star" icon="star" icon-variant="solid">Favorites</x-pegboard::tab>
```

**Icon variants:**
- `mini` (default) - 20x20px mini icons
- `outline` - 24x24px outline icons
- `solid` - 24x24px solid icons

### Badges

Display notifications, counts, or status indicators:

```blade
<x-pegboard::tabs>
    {{-- Numeric badge --}}
    <x-pegboard::tab name="inbox" badge="12">Inbox</x-pegboard::tab>

    {{-- Text badge --}}
    <x-pegboard::tab name="new" badge="New" badge-variant="primary">New Items</x-pegboard::tab>

    {{-- Badge variants --}}
    <x-pegboard::tab name="drafts" badge="3" badge-variant="warning">Drafts</x-pegboard::tab>
    <x-pegboard::tab name="errors" badge="5" badge-variant="danger">Errors</x-pegboard::tab>
    <x-pegboard::tab name="done" badge="✓" badge-variant="success">Complete</x-pegboard::tab>
</x-pegboard::tabs>
```

**Badge variants:**
- `default` - Muted background
- `primary` - Primary accent color
- `success` - Green success color
- `warning` - Yellow/orange warning color
- `danger` - Red destructive color

### Loading State

Show a loading spinner when fetching async content:

```blade
<x-pegboard::tabs variant="segmented">
    <x-pegboard::tab name="dashboard">Dashboard</x-pegboard::tab>
    <x-pegboard::tab name="analytics" :loading="true">Analytics</x-pegboard::tab>
    <x-pegboard::tab name="reports">Reports</x-pegboard::tab>
</x-pegboard::tabs>
```

**Behavior:**
- Loading spinner replaces the icon
- Tab remains interactive (can be disabled separately)
- Spinner centers automatically for icon-only tabs

**With Livewire:**

```blade
<x-pegboard::tab name="data" :loading="$loadingData" wire:click="loadData">
    Load Data
</x-pegboard::tab>
```

### Disabled Tabs

Prevent interaction with specific tabs:

```blade
<x-pegboard::tabs variant="segmented">
    <x-pegboard::tab name="available">Available</x-pegboard::tab>
    <x-pegboard::tab name="locked" :disabled="true">Locked</x-pegboard::tab>
    <x-pegboard::tab name="enabled">Enabled</x-pegboard::tab>
</x-pegboard::tabs>
```

**Behavior:**
- Reduced opacity (50%)
- Cursor not-allowed
- Cannot be selected via click or keyboard
- Keyboard navigation skips disabled tabs

**Conditional disabling:**

```blade
<x-pegboard::tab name="admin" :disabled="!auth()->user()->isAdmin()">
    Admin Panel
</x-pegboard::tab>
```

### Scrollable Tabs

Enable horizontal scrolling for many tabs with optional fade effects:

```blade
<x-pegboard::tab-group variant="default" :scrollable="true" scrollable-fade="true">
    <x-pegboard::tabs scrollable scrollable-fade="true">
        <x-pegboard::tab name="tab1">Tab 1</x-pegboard::tab>
        <x-pegboard::tab name="tab2">Tab 2</x-pegboard::tab>
        <x-pegboard::tab name="tab3">Tab 3</x-pegboard::tab>
        <!-- Many more tabs... -->
    </x-pegboard::tabs>
</x-pegboard::tab-group>
```

**Options:**
- `scrollable` - Enable horizontal overflow scrolling
- `scrollable-fade="true"` - Show gradient fade overlays on left/right
- `scrollable-scrollbar="hide"` - Hide the scrollbar (use with fade)

**Fade behavior:**
- Left fade appears when scrolled right (scrollLeft > 10px)
- Right fade appears when not at the end
- Fades use pointer-events-none to avoid blocking clicks
- Automatically updates on scroll

### Icon-Only Tabs

Create compact tabs with just icons (no text):

```blade
<x-pegboard::tab-group variant="segmented">
    <x-pegboard::tabs variant="segmented">
        <x-pegboard::tab name="list" icon="list-bullet"></x-pegboard::tab>
        <x-pegboard::tab name="grid" icon="squares-2x2"></x-pegboard::tab>
        <x-pegboard::tab name="calendar" icon="calendar-days"></x-pegboard::tab>
    </x-pegboard::tabs>
</x-pegboard::tab-group>
```

**Automatic behavior:**
- Icons center automatically when no text content
- No margin added to icon
- Perfect square buttons
- Works with all variants

**Accessibility tip:** Add `aria-label` for screen readers:

```blade
<x-pegboard::tab name="list" icon="list-bullet" aria-label="List view"></x-pegboard::tab>
```

## Sub-Components

### TabGroup

The root component that provides Alpine.js context. Must wrap both tabs and panels.

```blade
<x-pegboard::tab-group variant="segmented" size="base">
    <!-- All tabs and panels go here -->
</x-pegboard::tab-group>
```

**Responsibilities:**
- Initializes Alpine.js `pegboardTabs` component
- Manages active tab state (`activeTab`)
- Handles keyboard navigation (arrow keys, Home, End)
- Provides context to buttons and panels (variant, size, orientation)
- Tracks scroll position for fade overlays

### Tabs

Visual container for tab buttons. Provides styling based on variant.

```blade
<x-pegboard::tabs variant="segmented">
    <!-- Tab buttons -->
</x-pegboard::tabs>
```

**Renders:**
- Container div with variant-specific Tailwind classes
- Scroll fade overlays (when `scrollable-fade` is enabled)
- All styling is pure Tailwind CSS using `data-*` attribute variants

### Tab

Individual tab button that triggers panel switching.

```blade
<x-pegboard::tab
    name="profile"
    icon="user"
    badge="3"
    :disabled="false"
>
    Profile
</x-pegboard::tab>
```

**Renders:**
- `<button>` element with ARIA attributes
- Icon (optional, before text)
- Text content
- Badge (optional, after text)
- Trailing icon (optional, after badge)

### TabPanel

Content panel that shows when its matching tab is active.

```blade
<x-pegboard::tab-panel name="profile">
    <p>Profile content goes here...</p>
</x-pegboard::tab-panel>
```

**Renders:**
- `<div>` with `x-show` directive
- Native CSS fade-in animation
- ARIA tabpanel role
- Proper aria-hidden state

## Examples

### Basic Tabs with Icons

```blade
<x-pegboard::tab-group>
    <x-pegboard::tabs>
        <x-pegboard::tab name="user" icon="user">Profile</x-pegboard::tab>
        <x-pegboard::tab name="settings" icon="cog-6-tooth">Settings</x-pegboard::tab>
        <x-pegboard::tab name="billing" icon="credit-card">Billing</x-pegboard::tab>
    </x-pegboard::tabs>

    <div class="mt-6">
        <x-pegboard::tab-panel name="user">
            <h3>User Profile</h3>
            <p>Manage your profile settings...</p>
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="settings">
            <h3>Application Settings</h3>
            <p>Configure your preferences...</p>
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="billing">
            <h3>Billing Information</h3>
            <p>Manage payment methods...</p>
        </x-pegboard::tab-panel>
    </div>
</x-pegboard::tab-group>
```

### Segmented Tabs with Loading State

```blade
<x-pegboard::tab-group variant="segmented">
    <x-pegboard::tabs variant="segmented">
        <x-pegboard::tab name="overview" icon="chart-bar">Overview</x-pegboard::tab>
        <x-pegboard::tab name="analytics" icon="chart-pie" :loading="$isLoading">
            Analytics
        </x-pegboard::tab>
        <x-pegboard::tab name="reports" icon="document-text">Reports</x-pegboard::tab>
    </x-pegboard::tabs>

    <div class="mt-6">
        <x-pegboard::tab-panel name="overview">
            <!-- Dashboard overview -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="analytics">
            @if($isLoading)
                <p>Loading analytics...</p>
            @else
                <!-- Analytics content -->
            @endif
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="reports">
            <!-- Reports content -->
        </x-pegboard::tab-panel>
    </div>
</x-pegboard::tab-group>
```

### Pills Tabs with Badges

```blade
<x-pegboard::tab-group variant="pills">
    <x-pegboard::tabs variant="pills">
        <x-pegboard::tab name="inbox" icon="inbox" badge="12" badge-variant="primary">
            Inbox
        </x-pegboard::tab>
        <x-pegboard::tab name="drafts" icon="pencil" badge="3" badge-variant="warning">
            Drafts
        </x-pegboard::tab>
        <x-pegboard::tab name="sent" icon="paper-airplane">
            Sent
        </x-pegboard::tab>
        <x-pegboard::tab name="archive" icon="archive-box" badge="New" badge-variant="success">
            Archive
        </x-pegboard::tab>
    </x-pegboard::tabs>

    <div class="mt-6">
        <x-pegboard::tab-panel name="inbox">
            <!-- 12 unread messages -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="drafts">
            <!-- 3 draft messages -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="sent">
            <!-- Sent messages -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="archive">
            <!-- Archived messages -->
        </x-pegboard::tab-panel>
    </div>
</x-pegboard::tab-group>
```

### Scrollable Tabs with Fade

```blade
<x-pegboard::tab-group variant="default" :scrollable="true" scrollable-fade="true">
    <x-pegboard::tabs scrollable scrollable-fade="true" scrollable-scrollbar="hide">
        <x-pegboard::tab name="profile">Profile</x-pegboard::tab>
        <x-pegboard::tab name="account">Account</x-pegboard::tab>
        <x-pegboard::tab name="billing">Billing</x-pegboard::tab>
        <x-pegboard::tab name="security">Security</x-pegboard::tab>
        <x-pegboard::tab name="notifications">Notifications</x-pegboard::tab>
        <x-pegboard::tab name="integrations">Integrations</x-pegboard::tab>
        <x-pegboard::tab name="api">API Keys</x-pegboard::tab>
        <x-pegboard::tab name="advanced">Advanced</x-pegboard::tab>
    </x-pegboard::tabs>

    <div class="mt-6">
        <!-- Panels -->
    </div>
</x-pegboard::tab-group>
```

### Icon-Only View Switcher

```blade
<x-pegboard::tab-group variant="segmented">
    <x-pegboard::tabs variant="segmented">
        <x-pegboard::tab name="list" icon="list-bullet" aria-label="List view"></x-pegboard::tab>
        <x-pegboard::tab name="grid" icon="squares-2x2" aria-label="Grid view"></x-pegboard::tab>
        <x-pegboard::tab name="calendar" icon="calendar-days" aria-label="Calendar view"></x-pegboard::tab>
        <x-pegboard::tab name="map" icon="map" aria-label="Map view"></x-pegboard::tab>
    </x-pegboard::tabs>

    <div class="mt-6">
        <x-pegboard::tab-panel name="list">
            <!-- List layout -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="grid">
            <!-- Grid layout -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="calendar">
            <!-- Calendar layout -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="map">
            <!-- Map layout -->
        </x-pegboard::tab-panel>
    </div>
</x-pegboard::tab-group>
```

### Small Tabs for Compact Spaces

```blade
<x-pegboard::tab-group variant="segmented" size="sm">
    <x-pegboard::tabs variant="segmented" size="sm">
        <x-pegboard::tab name="code">Code</x-pegboard::tab>
        <x-pegboard::tab name="preview">Preview</x-pegboard::tab>
        <x-pegboard::tab name="docs">Docs</x-pegboard::tab>
    </x-pegboard::tabs>

    <div class="mt-4">
        <x-pegboard::tab-panel name="code">
            <!-- Code editor -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="preview">
            <!-- Live preview -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="docs">
            <!-- Documentation -->
        </x-pegboard::tab-panel>
    </div>
</x-pegboard::tab-group>
```

### Vertical Sidebar Navigation

```blade
<x-pegboard::tab.group orientation="vertical" class="flex gap-6">
    {{-- Vertical tabs sidebar --}}
    <x-pegboard::tab orientation="vertical">
        <x-pegboard::tab.button name="dashboard" icon="home">
            Dashboard
        </x-pegboard::tab.button>
        <x-pegboard::tab.button name="analytics" icon="chart-bar">
            Analytics
        </x-pegboard::tab.button>
        <x-pegboard::tab.button name="users" icon="users">
            Users
        </x-pegboard::tab.button>
        <x-pegboard::tab.button name="settings" icon="cog-6-tooth">
            Settings
        </x-pegboard::tab.button>
        <x-pegboard::tab.button name="billing" icon="credit-card">
            Billing
        </x-pegboard::tab.button>
    </x-pegboard::tab>

    {{-- Content area --}}
    <div class="flex-1 p-6 bg-card border border-border rounded-lg">
        <x-pegboard::tab.panel name="dashboard">
            <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
            <p class="text-muted-foreground">Welcome to your dashboard overview.</p>
            <!-- Dashboard widgets -->
        </x-pegboard::tab.panel>

        <x-pegboard::tab.panel name="analytics">
            <h2 class="text-2xl font-bold mb-4">Analytics</h2>
            <p class="text-muted-foreground">View your analytics and insights.</p>
            <!-- Charts and graphs -->
        </x-pegboard::tab.panel>

        <x-pegboard::tab.panel name="users">
            <h2 class="text-2xl font-bold mb-4">User Management</h2>
            <p class="text-muted-foreground">Manage users and permissions.</p>
            <!-- User table -->
        </x-pegboard::tab.panel>

        <x-pegboard::tab.panel name="settings">
            <h2 class="text-2xl font-bold mb-4">Settings</h2>
            <p class="text-muted-foreground">Configure application settings.</p>
            <!-- Settings form -->
        </x-pegboard::tab.panel>

        <x-pegboard::tab.panel name="billing">
            <h2 class="text-2xl font-bold mb-4">Billing</h2>
            <p class="text-muted-foreground">Manage billing and subscriptions.</p>
            <!-- Billing information -->
        </x-pegboard::tab.panel>
    </div>
</x-pegboard::tab.group>
```

### Conditional Tabs with Livewire

```blade
<x-pegboard::tab-group>
    <x-pegboard::tabs>
        <x-pegboard::tab name="public">Public</x-pegboard::tab>
        <x-pegboard::tab name="private">Private</x-pegboard::tab>
        @if(auth()->user()->isAdmin())
            <x-pegboard::tab name="admin" icon="shield-check">Admin</x-pegboard::tab>
        @endif
    </x-pegboard::tabs>

    <div class="mt-6">
        <x-pegboard::tab-panel name="public">
            <!-- Public content -->
        </x-pegboard::tab-panel>
        <x-pegboard::tab-panel name="private">
            <!-- Private content -->
        </x-pegboard::tab-panel>
        @if(auth()->user()->isAdmin())
            <x-pegboard::tab-panel name="admin">
                <!-- Admin panel -->
            </x-pegboard::tab-panel>
        @endif
    </div>
</x-pegboard::tab-group>
```

## Best Practices

### 1. Choose the Right Variant

- **Default**: Full-page navigation, main content areas
- **Segmented**: View switchers, filter toggles, tool selectors
- **Pills**: Category filters, status filters, tag selection

### 2. Match Tab and Panel Names

Always ensure tab `name` attributes match their corresponding panel `name`:

```blade
{{-- ✅ Good - Names match --}}
<x-pegboard::tab name="profile">Profile</x-pegboard::tab>
<x-pegboard::tab-panel name="profile">...</x-pegboard::tab-panel>

{{-- ❌ Bad - Names don't match --}}
<x-pegboard::tab name="user">Profile</x-pegboard::tab>
<x-pegboard::tab-panel name="profile">...</x-pegboard::tab-panel>
```

### 3. Use Consistent Sizing

Set size on the tab-group to apply it consistently:

```blade
{{-- ✅ Good - Size set once on tab-group --}}
<x-pegboard::tab-group size="sm">
    <x-pegboard::tabs size="sm">...</x-pegboard::tabs>
</x-pegboard::tab-group>

{{-- ❌ Avoid - Inconsistent sizes --}}
<x-pegboard::tab-group size="sm">
    <x-pegboard::tabs size="lg">...</x-pegboard::tabs>
</x-pegboard::tab-group>
```

### 4. Add Icons for Clarity

Icons improve scannability and recognition:

```blade
<x-pegboard::tab name="settings" icon="cog-6-tooth">Settings</x-pegboard::tab>
<x-pegboard::tab name="notifications" icon="bell">Notifications</x-pegboard::tab>
```

### 5. Use Badges Sparingly

Only show badges for important notifications:

```blade
{{-- ✅ Good - Important counts --}}
<x-pegboard::tab name="inbox" badge="12">Inbox</x-pegboard::tab>
<x-pegboard::tab name="errors" badge="3" badge-variant="danger">Errors</x-pegboard::tab>

{{-- ❌ Avoid - Badge on everything --}}
<x-pegboard::tab name="settings" badge="0">Settings</x-pegboard::tab>
```

### 6. Handle Loading States

Show loading indicators during async operations:

```blade
<x-pegboard::tab
    name="data"
    :loading="$loadingData"
    wire:click="loadData"
>
    Load Data
</x-pegboard::tab>
```

### 7. Disable Unavailable Tabs

Use disabled state for locked or unavailable content:

```blade
<x-pegboard::tab name="premium" :disabled="!auth()->user()->isPremium()">
    Premium Features
</x-pegboard::tab>
```

### 8. Scrollable for Many Tabs

Enable scrolling when you have more than 5-6 tabs:

```blade
<x-pegboard::tab-group :scrollable="true" scrollable-fade="true">
    <!-- 8+ tabs -->
</x-pegboard::tab-group>
```

### 9. Provide Context in Panels

Don't rely solely on tab labels for context:

```blade
<x-pegboard::tab-panel name="billing">
    <h3>Billing Information</h3>
    <p>Manage your payment methods and billing history.</p>
    <!-- Content -->
</x-pegboard::tab-panel>
```

### 10. Test Keyboard Navigation

Ensure all tabs are keyboard accessible:
- Arrow keys navigate between tabs
- Home/End keys jump to first/last tab
- Space/Enter activates focused tab
- Disabled tabs are skipped

## Accessibility

The tabs component follows WCAG 2.1 guidelines and ARIA best practices:

### ARIA Attributes

Automatically applied ARIA attributes:

```html
<!-- Tab Group -->
<div role="tablist" aria-orientation="horizontal">
    <!-- Tab -->
    <button
        role="tab"
        aria-selected="true"
        tabindex="0"
        data-tab-name="profile"
    >
        Profile
    </button>

    <!-- Panel -->
    <div
        role="tabpanel"
        aria-hidden="false"
    >
        Content
    </div>
</div>
```

**Note:** The `aria-orientation` attribute automatically reflects the `orientation` prop (`horizontal` or `vertical`).

### Keyboard Navigation

Full keyboard support built-in with **orientation-aware navigation**:

**Horizontal Tabs:**

| Key | Action |
|-----|--------|
| `→` (Right Arrow) | Next tab (wraps to first) |
| `←` (Left Arrow) | Previous tab (wraps to last) |
| `Home` | First tab |
| `End` | Last tab |
| `Space` / `Enter` | Activate focused tab |

**Vertical Tabs:**

| Key | Action |
|-----|--------|
| `↓` (Down Arrow) | Next tab (wraps to first) |
| `↑` (Up Arrow) | Previous tab (wraps to last) |
| `Home` | First tab |
| `End` | Last tab |
| `Space` / `Enter` | Activate focused tab |

**Disabled tabs are automatically skipped** during keyboard navigation.

### Screen Readers

- Tab buttons announce their selected state
- Panels announce when they become visible
- Icons should have accompanying text or `aria-label`
- Loading state is announced via spinner presence

### Focus Management

- Active tab receives `tabindex="0"`
- Inactive tabs receive `tabindex="-1"`
- Focus visible ring on keyboard focus
- Focus stays within tab group during navigation

### Best Practices for Accessibility

**1. Always provide text labels:**

```blade
{{-- ✅ Good - Icon with text --}}
<x-pegboard::tab name="settings" icon="cog-6-tooth">Settings</x-pegboard::tab>

{{-- ⚠️ Acceptable - Icon only with aria-label --}}
<x-pegboard::tab name="settings" icon="cog-6-tooth" aria-label="Settings"></x-pegboard::tab>

{{-- ❌ Bad - Icon only without label --}}
<x-pegboard::tab name="settings" icon="cog-6-tooth"></x-pegboard::tab>
```

**2. Use semantic panel structure:**

```blade
<x-pegboard::tab-panel name="settings">
    <h3>Settings</h3>  {{-- Heading for context --}}
    <p>Configure your preferences...</p>
    <!-- Content -->
</x-pegboard::tab-panel>
```

**3. Announce dynamic updates:**

```blade
<x-pegboard::tab-panel name="inbox">
    @if($newMessages)
        <div role="status" aria-live="polite" class="sr-only">
            {{ $newMessages }} new messages
        </div>
    @endif
    <!-- Inbox content -->
</x-pegboard::tab-panel>
```

**4. Provide loading feedback:**

```blade
<x-pegboard::tab name="analytics" :loading="$isLoading">
    <span class="sr-only">{{ $isLoading ? 'Loading' : '' }}</span>
    Analytics
</x-pegboard::tab>
```

**5. Disabled tabs should explain why:**

```blade
<x-pegboard::tab
    name="premium"
    :disabled="!$isPremium"
    aria-describedby="premium-info"
>
    Premium
</x-pegboard::tab>
<span id="premium-info" class="sr-only">
    Upgrade to premium to access this feature
</span>
```

### Color Contrast

All variants meet WCAG AA standards:
- Active tab text: 7:1 contrast ratio
- Inactive tab text: 4.5:1 contrast ratio
- Focus ring: 3:1 contrast ratio
- Badge text: 7:1 contrast ratio

### Reduced Motion

Animations respect `prefers-reduced-motion`:

```css
/* Animations disabled for users who prefer reduced motion */
@media (prefers-reduced-motion: reduce) {
    .tab-marker {
        transition: none;
    }
}
```

---


## Additional Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev)
- [Heroicons](https://heroicons.com)
- [ARIA: tab role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/tab_role)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
