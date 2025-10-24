# Avatar Component

A versatile avatar component for displaying user profile pictures with automatic fallback to initials, perfect for user interfaces, comment threads, and team displays.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Props Reference](#props-reference)
- [Sizes](#sizes)
- [Colors](#colors)
- [Border Radius](#border-radius)
- [Bordered Avatars](#bordered-avatars)
- [Image Handling](#image-handling)
- [Avatar Groups](#avatar-groups)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard Avatar component provides elegant user representation with automatic initials generation and image fallback support. Built with native HTML/CSS, it requires zero JavaScript for core functionality.

**Key Features:**
- Automatic initials from names (first 2 words)
- 5 size variants (xs to 2xl)
- 6 semantic color themes
- 5 border radius options (square to circle)
- Optional ring borders with color matching
- Native image error handling (no Alpine.js required)
- Avatar group component for overlapping displays
- Dark mode support
- Fully accessible

## Basic Usage

### Simple Avatar with Initials

```blade
{{-- Generates initials "JD" --}}
<x-pegboard::avatar name="John Doe" />
```

### Avatar with Image

```blade
{{-- Shows image, falls back to initials if image fails --}}
<x-pegboard::avatar
    name="John Doe"
    src="/images/profiles/john-doe.jpg"
/>
```

### Colored Avatar

```blade
{{-- Primary color theme --}}
<x-pegboard::avatar
    name="Jane Smith"
    color="primary"
/>
```

### Sized Avatar

```blade
{{-- Large avatar --}}
<x-pegboard::avatar
    name="Bob Johnson"
    size="lg"
/>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string\|null | `null` | Full name for initials (extracts first letter of first 2 words) |
| `src` | string\|null | `null` | Image URL (automatically falls back to initials on error) |
| `color` | string | `'default'` | Theme: `default`, `primary`, `secondary`, `success`, `warning`, `danger` |
| `size` | string | `'md'` | Size: `xs`, `sm`, `md`, `lg`, `2xl` |
| `radius` | string | `'full'` | Border radius: `none`, `sm`, `md`, `lg`, `full` |
| `isBordered` | bool | `false` | Add ring-2 border with offset and color matching |

## Sizes

Avatars scale proportionally with text size adjustments:

### Extra Small (xs)

```blade
{{-- 24×24px with text-xs --}}
<x-pegboard::avatar size="xs" name="John Doe" />
```

**Use cases:**
- Inline with small text
- Compact lists
- Mobile UI elements
- Table cells

### Small (sm)

```blade
{{-- 32×32px with text-xs --}}
<x-pegboard::avatar size="sm" name="Jane Smith" />
```

**Use cases:**
- Comment threads
- Chat messages
- Small cards
- Dropdown menus

### Medium (md) - Default

```blade
{{-- 40×40px with text-sm --}}
<x-pegboard::avatar size="md" name="Bob Johnson" />
```

**Use cases:**
- Default profile displays
- User lists
- Navigation bars
- General UI elements

### Large (lg)

```blade
{{-- 48×48px with text-base --}}
<x-pegboard::avatar size="lg" name="Alice Williams" />
```

**Use cases:**
- User profile cards
- Modal headers
- Featured users
- Dashboard widgets

### Extra Large (2xl)

```blade
{{-- 64×64px with text-lg --}}
<x-pegboard::avatar size="2xl" name="Charlie Brown" />
```

**Use cases:**
- Profile page headers
- User settings
- About pages
- Hero sections

## Colors

All color variants use semantic theme tokens for consistent theming:

### Default (Muted)

```blade
<x-pegboard::avatar name="Default User" color="default" />
```

Neutral gray background - best for general use.

### Primary

```blade
<x-pegboard::avatar name="Primary User" color="primary" />
```

Brand color - for important users or highlighted profiles.

### Secondary

```blade
<x-pegboard::avatar name="Secondary User" color="secondary" />
```

Alternative neutral - for secondary emphasis.

### Success

```blade
<x-pegboard::avatar name="Active User" color="success" />
```

Green theme - for active/online users or positive status.

### Warning

```blade
<x-pegboard::avatar name="Busy User" color="warning" />
```

Yellow/orange theme - for away/busy status or warnings.

### Danger

```blade
<x-pegboard::avatar name="Offline User" color="danger" />
```

Red theme - for offline users, errors, or destructive actions.

## Border Radius

Control avatar shape from square to circle:

### None (Square)

```blade
<x-pegboard::avatar name="Square Avatar" radius="none" />
```

Sharp corners - modern, geometric aesthetic.

### Small Radius (sm)

```blade
<x-pegboard::avatar name="Soft Square" radius="sm" />
```

Subtle rounding - balanced between square and rounded.

### Medium Radius (md)

```blade
<x-pegboard::avatar name="Rounded" radius="md" />
```

Noticeably rounded corners - friendly appearance.

### Large Radius (lg)

```blade
<x-pegboard::avatar name="Very Rounded" radius="lg" />
```

Heavily rounded - approaching circular.

### Full Circle (full) - Default

```blade
<x-pegboard::avatar name="Circle Avatar" radius="full" />
```

Perfect circle - classic profile picture style.

## Bordered Avatars

Add ring borders for visual emphasis:

### Basic Border

```blade
<x-pegboard::avatar
    name="John Doe"
    :is-bordered="true"
/>
```

### Colored Border

```blade
{{-- Border color matches avatar color --}}
<x-pegboard::avatar
    name="Jane Smith"
    color="primary"
    :is-bordered="true"
/>
```

**Border features:**
- 2px ring thickness
- 2px offset from avatar edge
- Background color offset for proper contrast
- Color matches avatar theme

**When to use borders:**
- Overlapping avatar groups
- Avatars on colored backgrounds
- Emphasizing active/selected users
- Profile highlights

## Image Handling

### Automatic Fallback

Images automatically fall back to initials if they fail to load:

```blade
{{-- Valid image shows normally --}}
<x-pegboard::avatar
    name="Sarah Johnson"
    src="https://example.com/avatars/sarah.jpg"
/>

{{-- Broken URL shows initials "JS" instead --}}
<x-pegboard::avatar
    name="Jane Smith"
    src="https://broken-url.test/missing.jpg"
    color="primary"
/>
```

**How it works:**
- Uses native HTML `onerror` event
- No Alpine.js or JavaScript frameworks required
- Instant fallback when image fails
- Zero performance overhead

### Initials Generation

Initials are extracted automatically from the `name` prop:

```blade
{{-- "JD" from first and last name --}}
<x-pegboard::avatar name="John Doe" />

{{-- "JS" --}}
<x-pegboard::avatar name="Jane Smith" />

{{-- "AW" (only first 2 words) --}}
<x-pegboard::avatar name="Alice Williams Brown" />

{{-- "MC" --}}
<x-pegboard::avatar name="María González" />
{{-- Works with Unicode/international names --}}
```

**Rules:**
- Extracts first letter from first 2 words
- Converts to uppercase
- Unicode-safe (supports international characters)
- Empty avatar if no name provided

## Avatar Groups

Display overlapping avatars for teams or groups:

### Basic Group

```blade
<x-pegboard::avatar.group>
    <x-pegboard::avatar name="Alex Brown" :is-bordered="true" />
    <x-pegboard::avatar name="Sam Taylor" :is-bordered="true" />
    <x-pegboard::avatar name="Jordan Lee" :is-bordered="true" />
</x-pegboard::avatar.group>
```

**Important:** Always use `:is-bordered="true"` on avatars within groups to prevent overlapping edges from blending together.

### Group with Colors

```blade
<x-pegboard::avatar.group>
    <x-pegboard::avatar name="Alex Brown" color="primary" :is-bordered="true" />
    <x-pegboard::avatar name="Sam Taylor" color="secondary" :is-bordered="true" />
    <x-pegboard::avatar name="Jordan Lee" color="success" :is-bordered="true" />
    <x-pegboard::avatar name="Casey Morgan" color="warning" :is-bordered="true" />
</x-pegboard::avatar.group>
```

### Group with Count Indicator

```blade
<x-pegboard::avatar.group>
    <x-pegboard::avatar name="User 1" :is-bordered="true" />
    <x-pegboard::avatar name="User 2" :is-bordered="true" />
    <x-pegboard::avatar name="User 3" :is-bordered="true" />

    {{-- Count indicator for remaining users --}}
    <div class="relative inline-flex items-center justify-center h-10 w-10 rounded-full bg-muted text-muted-foreground ring-4 ring-background font-semibold text-sm">
        +12
    </div>
</x-pegboard::avatar.group>
```

## Examples

### User Profile Card

```blade
<div class="bg-card border border-border rounded-lg p-6">
    <div class="flex items-center gap-4">
        <x-pegboard::avatar
            name="Sarah Johnson"
            src="/images/profiles/sarah.jpg"
            size="2xl"
            :is-bordered="true"
            color="primary"
        />
        <div>
            <h3 class="font-bold text-lg">Sarah Johnson</h3>
            <p class="text-sm text-muted-foreground">Product Designer</p>
            <p class="text-xs text-muted-foreground">sarah.johnson@company.com</p>
        </div>
    </div>
</div>
```

### Comment Thread

```blade
<div class="space-y-4">
    {{-- Comment 1 --}}
    <div class="flex gap-3">
        <x-pegboard::avatar
            name="Mike Chen"
            src="/avatars/mike.jpg"
            size="sm"
            color="secondary"
        />
        <div class="flex-1">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-sm">Mike Chen</span>
                <span class="text-xs text-muted-foreground">2 hours ago</span>
            </div>
            <p class="text-sm mt-1">This looks great! When can we ship it?</p>
        </div>
    </div>

    {{-- Comment 2 --}}
    <div class="flex gap-3">
        <x-pegboard::avatar
            name="Emma Wilson"
            size="sm"
            color="success"
        />
        <div class="flex-1">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-sm">Emma Wilson</span>
                <span class="text-xs text-muted-foreground">1 hour ago</span>
            </div>
            <p class="text-sm mt-1">Ready for QA testing now!</p>
        </div>
    </div>
</div>
```

### Team Members List

```blade
<div class="space-y-3">
    @foreach($team as $member)
        <div class="flex items-center justify-between p-3 bg-muted/50 rounded-lg">
            <div class="flex items-center gap-3">
                <x-pegboard::avatar
                    :name="$member->name"
                    :src="$member->avatar_url"
                    size="md"
                    color="primary"
                />
                <div>
                    <p class="font-semibold text-sm">{{ $member->name }}</p>
                    <p class="text-xs text-muted-foreground">{{ $member->role }}</p>
                </div>
            </div>
            <x-pegboard::badge color="success">Active</x-pegboard::badge>
        </div>
    @endforeach
</div>
```

### Overlapping Avatar Stack

```blade
{{-- Team preview with hover effect --}}
<div class="flex items-center gap-3">
    <x-pegboard::avatar.group>
        <x-pegboard::avatar
            name="Alex Brown"
            color="primary"
            :is-bordered="true"
            class="transition-transform hover:scale-110 hover:z-10"
        />
        <x-pegboard::avatar
            name="Sam Taylor"
            color="secondary"
            :is-bordered="true"
            class="transition-transform hover:scale-110 hover:z-10"
        />
        <x-pegboard::avatar
            name="Jordan Lee"
            color="success"
            :is-bordered="true"
            class="transition-transform hover:scale-110 hover:z-10"
        />
        <div class="relative inline-flex items-center justify-center h-10 w-10 rounded-full bg-muted text-muted-foreground ring-4 ring-background font-semibold text-sm">
            +5
        </div>
    </x-pegboard::avatar.group>

    <span class="text-sm text-muted-foreground">8 team members</span>
</div>
```

### Status Indicators

```blade
{{-- Online status --}}
<div class="relative inline-flex">
    <x-pegboard::avatar
        name="John Doe"
        src="/avatars/john.jpg"
        size="lg"
    />
    <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-success ring-2 ring-background"></span>
</div>

{{-- Away status --}}
<div class="relative inline-flex">
    <x-pegboard::avatar
        name="Jane Smith"
        size="lg"
        color="warning"
    />
    <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-warning ring-2 ring-background"></span>
</div>

{{-- Offline status --}}
<div class="relative inline-flex">
    <x-pegboard::avatar
        name="Bob Wilson"
        size="lg"
    />
    <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-muted ring-2 ring-background"></span>
</div>
```

### Dropdown Menu Header

```blade
<x-pegboard::dropdown>
    <x-slot:trigger>
        <button class="flex items-center gap-2">
            <x-pegboard::avatar
                name="{{ auth()->user()->name }}"
                src="{{ auth()->user()->avatar }}"
                size="sm"
            />
            <x-pegboard::icon name="chevron-down" variant="mini" class="h-4 w-4" />
        </button>
    </x-slot:trigger>

    <div class="p-3 border-b border-border">
        <div class="flex items-center gap-3">
            <x-pegboard::avatar
                name="{{ auth()->user()->name }}"
                src="{{ auth()->user()->avatar }}"
                size="md"
            />
            <div>
                <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                <p class="text-xs text-muted-foreground">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    {{-- Menu items --}}
</x-pegboard::dropdown>
```

### Table with Avatars

```blade
<x-pegboard::table>
    <x-pegboard::table.head>
        <x-pegboard::table.row>
            <x-pegboard::table.header>User</x-pegboard::table.header>
            <x-pegboard::table.header>Email</x-pegboard::table.header>
            <x-pegboard::table.header>Role</x-pegboard::table.header>
            <x-pegboard::table.header>Status</x-pegboard::table.header>
        </x-pegboard::table.row>
    </x-pegboard::table.head>
    <x-pegboard::table.body>
        @foreach($users as $user)
            <x-pegboard::table.row>
                <x-pegboard::table.cell>
                    <div class="flex items-center gap-3">
                        <x-pegboard::avatar
                            :name="$user->name"
                            :src="$user->avatar"
                            size="sm"
                        />
                        <span class="font-medium">{{ $user->name }}</span>
                    </div>
                </x-pegboard::table.cell>
                <x-pegboard::table.cell>{{ $user->email }}</x-pegboard::table.cell>
                <x-pegboard::table.cell>{{ $user->role }}</x-pegboard::table.cell>
                <x-pegboard::table.cell>
                    <x-pegboard::badge :color="$user->is_active ? 'success' : 'default'">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </x-pegboard::badge>
                </x-pegboard::table.cell>
            </x-pegboard::table.row>
        @endforeach
    </x-pegboard::table.body>
</x-pegboard::table>
```

## Best Practices

### 1. Always Provide Names

```blade
{{-- ✅ Good - Name for accessibility and fallback --}}
<x-pegboard::avatar
    name="John Doe"
    src="/avatars/john.jpg"
/>

{{-- ❌ Bad - No fallback if image fails --}}
<x-pegboard::avatar src="/avatars/john.jpg" />
```

### 2. Use Appropriate Sizes

```blade
{{-- ✅ Good - Size matches context --}}
<div class="text-sm">
    <x-pegboard::avatar name="User" size="sm" />
</div>

<div class="profile-header">
    <x-pegboard::avatar name="User" size="2xl" />
</div>

{{-- ❌ Bad - Size mismatch --}}
<p class="text-xs">
    <x-pegboard::avatar name="User" size="2xl" />
    {{-- Too large for small text --}}
</p>
```

### 3. Use Borders in Groups

```blade
{{-- ✅ Good - Borders prevent overlap blending --}}
<x-pegboard::avatar.group>
    <x-pegboard::avatar name="User 1" :is-bordered="true" />
    <x-pegboard::avatar name="User 2" :is-bordered="true" />
</x-pegboard::avatar.group>

{{-- ❌ Bad - No borders, edges blend --}}
<x-pegboard::avatar.group>
    <x-pegboard::avatar name="User 1" />
    <x-pegboard::avatar name="User 2" />
</x-pegboard::avatar.group>
```

### 4. Match Colors to Context

```blade
{{-- ✅ Good - Color indicates status --}}
<x-pegboard::avatar
    name="Active User"
    color="success"
/>

{{-- ✅ Good - Color matches brand --}}
<x-pegboard::avatar
    name="Admin"
    color="primary"
/>

{{-- ❌ Confusing - Red doesn't match context --}}
<x-pegboard::avatar
    name="Successful User"
    color="danger"
/>
```

### 5. Provide Alt Text via Name

```blade
{{-- ✅ Good - Name becomes alt text --}}
<x-pegboard::avatar
    name="John Doe, Senior Developer"
    src="/avatars/john.jpg"
/>
{{-- Screen readers announce: "John Doe, Senior Developer" --}}

{{-- ❌ Bad - Generic name --}}
<x-pegboard::avatar
    name="User"
    src="/avatars/john.jpg"
/>
```

### 6. Consistent Sizing in Lists

```blade
{{-- ✅ Good - All avatars same size --}}
@foreach($users as $user)
    <div class="flex items-center gap-2">
        <x-pegboard::avatar :name="$user->name" size="sm" />
        <span>{{ $user->name }}</span>
    </div>
@endforeach

{{-- ❌ Bad - Inconsistent sizes --}}
@foreach($users as $user)
    <div class="flex items-center gap-2">
        <x-pegboard::avatar :name="$user->name" :size="$user->isAdmin ? 'md' : 'sm'" />
        {{-- Creates visual inconsistency --}}
    </div>
@endforeach
```

## Accessibility

The Avatar component follows WCAG 2.1 guidelines:

### Image Alt Text

Avatar images automatically use the `name` prop as alt text:

```blade
<x-pegboard::avatar name="Sarah Johnson" src="/avatars/sarah.jpg" />
{{-- Renders: <img alt="Sarah Johnson" src="/avatars/sarah.jpg" /> --}}
```

**Screen reader output:** "Sarah Johnson"

### Color Contrast

All color variants meet WCAG AA standards (4.5:1 minimum):
- Default: Muted gray with dark text
- Primary/Secondary/Success/Warning/Danger: High contrast foreground colors
- Dark mode: Automatically adjusts for proper contrast

### Non-Interactive Elements

Avatars are purely presentational:
- Not focusable
- No keyboard interaction
- `select-none` prevents text selection

### Meaningful Names

Use descriptive names for better accessibility:

```blade
{{-- ✅ Good - Descriptive --}}
<x-pegboard::avatar name="Dr. Sarah Johnson, Chief Medical Officer" />

{{-- ❌ Bad - Not descriptive --}}
<x-pegboard::avatar name="User" />
```

### Status Indicators

When adding status badges, use ARIA labels:

```blade
<div class="relative inline-flex">
    <x-pegboard::avatar name="John Doe" size="lg" />
    <span
        class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-success ring-2 ring-background"
        aria-label="Online"
        role="status"
    ></span>
</div>
```

---

## Additional Resources

- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Avatar Design Patterns](https://ui-patterns.com/patterns/avatar)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository
