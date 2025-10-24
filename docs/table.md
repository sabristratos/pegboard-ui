# Table Component

A comprehensive, feature-rich table component for displaying tabular data with support for variants, sizes, sticky headers, sticky columns, and responsive layouts. Built with **pure Tailwind CSS** - no custom CSS required.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Structure](#component-structure)
- [Props Reference](#props-reference)
- [Variants](#variants)
- [Sizes](#sizes)
- [Features](#features)
  - [Hover Effects](#hover-effects)
  - [Responsive Tables](#responsive-tables)
  - [Sticky Headers](#sticky-headers)
  - [Sticky Columns](#sticky-columns)
- [Sub-Components](#sub-components)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)
- [Styling](#styling)

## Overview

The Pegboard table component provides a semantic, accessible, and highly customizable way to display tabular data. Built entirely with **Tailwind CSS v4** utilities for maximum flexibility and minimal bundle size.

**Key Features:**
- **Pure Tailwind CSS** - All styling via utility classes, no custom CSS
- Multiple visual variants (default, striped, bordered)
- Four size options (xs, sm, md, lg)
- **Automatic hover effects** on body rows (uses `hover:bg-primary/8`)
- Sticky headers for long scrollable tables
- Sticky columns (left or right) for wide tables
- Responsive wrapper with thin, discreet scrollbars
- Footer support for totals and summaries
- Flexible text alignment (left, center, right)
- Built-in accessibility features
- **Distinct header styling** with `table-header` theme token

## Basic Usage

The simplest table requires only the basic structure:

```blade
<x-pegboard::table>
    <x-pegboard::table.head>
        <x-pegboard::table.row>
            <x-pegboard::table.header>Name</x-pegboard::table.header>
            <x-pegboard::table.header>Email</x-pegboard::table.header>
            <x-pegboard::table.header>Role</x-pegboard::table.header>
        </x-pegboard::table.row>
    </x-pegboard::table.head>
    <x-pegboard::table.body>
        <x-pegboard::table.row>
            <x-pegboard::table.cell>John Doe</x-pegboard::table.cell>
            <x-pegboard::table.cell>john@example.com</x-pegboard::table.cell>
            <x-pegboard::table.cell>Admin</x-pegboard::table.cell>
        </x-pegboard::table.row>
    </x-pegboard::table.body>
</x-pegboard::table>
```

## Component Structure

The table component follows semantic HTML structure with dedicated sub-components:

```
<x-pegboard::table>                     <!-- Root table element -->
    <x-pegboard::table.head>            <!-- Table header wrapper (thead) -->
        <x-pegboard::table.row>         <!-- Table row (tr) -->
            <x-pegboard::table.header>  <!-- Header cell (th) -->
            ...
        </x-pegboard::table.row>
    </x-pegboard::table.head>

    <x-pegboard::table.body>            <!-- Table body wrapper (tbody) -->
        <x-pegboard::table.row>         <!-- Table row (tr) -->
            <x-pegboard::table.cell>    <!-- Data cell (td) -->
            ...
        </x-pegboard::table.row>
    </x-pegboard::table.body>

    <x-pegboard::table.foot>            <!-- Table footer wrapper (tfoot) -->
        <x-pegboard::table.row>         <!-- Table row (tr) -->
            <x-pegboard::table.header>  <!-- Footer cell (th) -->
            ...
        </x-pegboard::table.row>
    </x-pegboard::table.foot>
</x-pegboard::table>
```

## Props Reference

### Table (Root Component)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `'default'` | Visual style: `default`, `striped`, `bordered` |
| `size` | string | `'md'` | Cell padding size: `xs`, `sm`, `md`, `lg` |
| `responsive` | boolean | `true` | Wrap table in horizontal scroll container |
| `stickyHeader` | boolean | `false` | Enable sticky table headers |

**Note:** The `hoverable` prop has been removed. Hover effects are now **always enabled** using pure CSS (`hover:bg-primary/8`). This follows Pegboard's principle of "Modern HTML/CSS First."

### Table.Header / Table.Cell

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `align` | string | `'left'` | Text alignment: `left`, `center`, `right` |
| `sticky` | string | `null` | Sticky position: `left`, `right` |
| `colspan` | int | `null` | Number of columns to span |
| `rowspan` | int | `null` | Number of rows to span |
| `sortable` | bool | `false` | **[Header only]** Enable sortable cursor |

### Table.Row

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| - | - | - | Accepts standard HTML attributes via `$attributes` |

### Table.Head / Table.Body / Table.Foot

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| - | - | - | Accepts standard HTML attributes via `$attributes` |

## Variants

### Default

Clean, minimal styling with simple borders between rows.

```blade
<x-pegboard::table variant="default">
    <!-- table content -->
</x-pegboard::table>
```

### Striped

Alternating row background colors for improved readability. Uses Tailwind's `[&_tbody_tr:nth-child(odd)]:bg-muted/30` for striping.

```blade
<x-pegboard::table variant="striped">
    <!-- table content -->
</x-pegboard::table>
```

**Note:** Hover effects use `hover:bg-primary/8` which overrides the stripe background, providing clear visual feedback.

### Bordered

Add borders around the entire table for clear cell separation.

```blade
<x-pegboard::table variant="bordered">
    <!-- table content -->
</x-pegboard::table>
```

## Sizes

Control cell padding across the entire table:

| Size | Padding | Use Case |
|------|---------|----------|
| `xs` | Extra small | Dense data displays, dashboards |
| `sm` | Small | Compact tables with moderate data |
| `md` | Medium (default) | Standard tables, most use cases |
| `lg` | Large | Spacious tables, emphasis on content |

```blade
<x-pegboard::table size="xs">
    <!-- Compact table -->
</x-pegboard::table>

<x-pegboard::table size="lg">
    <!-- Spacious table -->
</x-pegboard::table>
```

## Features

### Hover Effects

**Hover effects are automatically enabled** on all table body rows using pure CSS. No prop needed!

```blade
<x-pegboard::table>
    <!-- Body rows automatically have hover:bg-primary/8 -->
</x-pegboard::table>
```

The hover effect:
- Uses `hover:bg-primary/8` - 8% primary color tint
- Applied via `@media (hover: hover)` - respects user preferences
- Only affects `tbody` rows - **headers are not hoverable**
- Works perfectly with striped variant (overrides stripe background)
- Pure Tailwind CSS - no JavaScript

### Responsive Tables

By default, tables are wrapped in a horizontal scroll container with a **thin, discreet scrollbar** (4px width, 40% transparent).

```blade
{{-- Responsive (default) --}}
<x-pegboard::table>
    <!-- Automatically wraps in overflow-x-auto container with scrollbar-thin -->
</x-pegboard::table>

{{-- Disable responsive wrapper --}}
<x-pegboard::table :responsive="false">
    <!-- No wrapper, you handle responsiveness -->
</x-pegboard::table>
```

**Scrollbar Features:**
- 4px width (50% thinner than default)
- 40% transparent by default, fully opaque on hover
- No visible track (transparent background)
- Applied via the `scrollbar-thin` utility class

**Note:** When `stickyHeader` is enabled, `responsive` is automatically set to `false` to prevent nested scroll containers that break sticky positioning.

### Sticky Headers

Keep column headers visible when scrolling through long tables. Uses pure CSS `position: sticky`.

```blade
<div class="max-h-96 overflow-y-auto scrollbar-thin">
    <x-pegboard::table :stickyHeader="true">
        <x-pegboard::table.head>
            <!-- Headers stay visible when scrolling -->
        </x-pegboard::table.head>
        <x-pegboard::table.body>
            <!-- Long list of rows -->
        </x-pegboard::table.body>
    </x-pegboard::table>
</div>
```

**How it works:**
1. Set `:stickyHeader="true"` on the root `<x-pegboard::table>` component
2. Wrap the table in a scrollable container (e.g., `max-h-96 overflow-y-auto`)
3. Add `scrollbar-thin` for a discreet scrollbar
4. The component automatically applies Tailwind classes:
   - `[&_thead]:sticky [&_thead]:top-0 [&_thead]:z-20`
5. The `<thead>` has `bg-table-header` for a solid background

**Theme Token:** Headers use the `--color-table-header` theme token:
- Light mode: `neutral-100` (solid light gray)
- Dark mode: `neutral-900` (solid dark gray)

**Important:** The scrollable container must be the **direct parent** of the table (no intermediate wrappers with overflow).

### Sticky Columns

Keep specific columns visible when scrolling horizontally through wide tables. Uses pure CSS `position: sticky`.

#### Sticky First Column

```blade
<x-pegboard::table>
    <x-pegboard::table.head>
        <x-pegboard::table.row>
            <x-pegboard::table.header sticky="left">Employee</x-pegboard::table.header>
            <x-pegboard::table.header>Department</x-pegboard::table.header>
            <!-- More columns -->
        </x-pegboard::table.row>
    </x-pegboard::table.head>
    <x-pegboard::table.body>
        <x-pegboard::table.row>
            <x-pegboard::table.cell sticky="left">John Doe</x-pegboard::table.cell>
            <x-pegboard::table.cell>Engineering</x-pegboard::table.cell>
            <!-- More cells -->
        </x-pegboard::table.row>
    </x-pegboard::table.body>
</x-pegboard::table>
```

#### Sticky Actions Column (Right)

```blade
<x-pegboard::table>
    <x-pegboard::table.head>
        <x-pegboard::table.row>
            <x-pegboard::table.header>Order ID</x-pegboard::table.header>
            <!-- More columns -->
            <x-pegboard::table.header sticky="right">Actions</x-pegboard::table.header>
        </x-pegboard::table.row>
    </x-pegboard::table.head>
    <x-pegboard::table.body>
        <x-pegboard::table.row>
            <x-pegboard::table.cell>#12345</x-pegboard::table.cell>
            <!-- More cells -->
            <x-pegboard::table.cell sticky="right">
                <button>Edit</button>
                <button>Delete</button>
            </x-pegboard::table.cell>
        </x-pegboard::table.row>
    </x-pegboard::table.body>
</x-pegboard::table>
```

## Sub-Components

### Table.Head

Wraps header rows in a `<thead>` element with `bg-table-header` background.

```blade
<x-pegboard::table.head>
    <x-pegboard::table.row>
        <!-- Header cells -->
    </x-pegboard::table.row>
</x-pegboard::table.head>
```

### Table.Body

Wraps data rows in a `<tbody>` element.

```blade
<x-pegboard::table.body>
    @foreach($users as $user)
        <x-pegboard::table.row>
            <!-- Data cells -->
        </x-pegboard::table.row>
    @endforeach
</x-pegboard::table.body>
```

### Table.Foot

Wraps footer rows in a `<tfoot>` element. Useful for totals and summaries.

```blade
<x-pegboard::table.foot>
    <x-pegboard::table.row>
        <x-pegboard::table.header colspan="3">Total</x-pegboard::table.header>
        <x-pegboard::table.header align="right">$3,028.21</x-pegboard::table.header>
    </x-pegboard::table.row>
</x-pegboard::table.foot>
```

### Table.Row

Renders a `<tr>` element. Hover effects are controlled by the parent table component.

```blade
<x-pegboard::table.row>
    <!-- Cells -->
</x-pegboard::table.row>
```

### Table.Header

Renders a `<th>` element with optional text alignment, sticky positioning, and column spanning.

```blade
{{-- Basic header --}}
<x-pegboard::table.header>Name</x-pegboard::table.header>

{{-- Right-aligned --}}
<x-pegboard::table.header align="right">Price</x-pegboard::table.header>

{{-- Sticky left --}}
<x-pegboard::table.header sticky="left">Product</x-pegboard::table.header>

{{-- Sortable --}}
<x-pegboard::table.header sortable>Created At</x-pegboard::table.header>

{{-- Spanning multiple columns --}}
<x-pegboard::table.header colspan="3">Totals</x-pegboard::table.header>
```

### Table.Cell

Renders a `<td>` element with optional text alignment, sticky positioning, and column spanning.

```blade
{{-- Basic cell --}}
<x-pegboard::table.cell>John Doe</x-pegboard::table.cell>

{{-- Center-aligned --}}
<x-pegboard::table.cell align="center">Active</x-pegboard::table.cell>

{{-- Sticky right --}}
<x-pegboard::table.cell sticky="right">
    <button>Edit</button>
</x-pegboard::table.cell>

{{-- Spanning multiple columns --}}
<x-pegboard::table.cell colspan="2">No data available</x-pegboard::table.cell>
```

## Examples

### Simple Data Table

```blade
<x-pegboard::table>
    <x-pegboard::table.head>
        <x-pegboard::table.row>
            <x-pegboard::table.header>Name</x-pegboard::table.header>
            <x-pegboard::table.header>Email</x-pegboard::table.header>
            <x-pegboard::table.header>Role</x-pegboard::table.header>
        </x-pegboard::table.row>
    </x-pegboard::table.head>
    <x-pegboard::table.body>
        @foreach($users as $user)
            <x-pegboard::table.row>
                <x-pegboard::table.cell>{{ $user->name }}</x-pegboard::table.cell>
                <x-pegboard::table.cell>{{ $user->email }}</x-pegboard::table.cell>
                <x-pegboard::table.cell>{{ $user->role }}</x-pegboard::table.cell>
            </x-pegboard::table.row>
        @endforeach
    </x-pegboard::table.body>
</x-pegboard::table>
```

### Striped Table (Hover Included)

```blade
<x-pegboard::table variant="striped">
    <x-pegboard::table.head>
        <x-pegboard::table.row>
            <x-pegboard::table.header>Product</x-pegboard::table.header>
            <x-pegboard::table.header align="right">Price</x-pegboard::table.header>
            <x-pegboard::table.header align="center">Stock</x-pegboard::table.header>
        </x-pegboard::table.row>
    </x-pegboard::table.head>
    <x-pegboard::table.body>
        @foreach($products as $product)
            <x-pegboard::table.row>
                <x-pegboard::table.cell>{{ $product->name }}</x-pegboard::table.cell>
                <x-pegboard::table.cell align="right">${{ number_format($product->price, 2) }}</x-pegboard::table.cell>
                <x-pegboard::table.cell align="center">{{ $product->stock }}</x-pegboard::table.cell>
            </x-pegboard::table.row>
        @endforeach
    </x-pegboard::table.body>
</x-pegboard::table>
```

### Table with Footer Totals

```blade
<x-pegboard::table>
    <x-pegboard::table.head>
        <x-pegboard::table.row>
            <x-pegboard::table.header>Item</x-pegboard::table.header>
            <x-pegboard::table.header align="center">Quantity</x-pegboard::table.header>
            <x-pegboard::table.header align="right">Price</x-pegboard::table.header>
            <x-pegboard::table.header align="right">Total</x-pegboard::table.header>
        </x-pegboard::table.row>
    </x-pegboard::table.head>
    <x-pegboard::table.body>
        @foreach($items as $item)
            <x-pegboard::table.row>
                <x-pegboard::table.cell>{{ $item->name }}</x-pegboard::table.cell>
                <x-pegboard::table.cell align="center">{{ $item->quantity }}</x-pegboard::table.cell>
                <x-pegboard::table.cell align="right">${{ number_format($item->price, 2) }}</x-pegboard::table.cell>
                <x-pegboard::table.cell align="right">${{ number_format($item->total, 2) }}</x-pegboard::table.cell>
            </x-pegboard::table.row>
        @endforeach
    </x-pegboard::table.body>
    <x-pegboard::table.foot>
        <x-pegboard::table.row>
            <x-pegboard::table.header colspan="3">Subtotal</x-pegboard::table.header>
            <x-pegboard::table.header align="right">${{ number_format($subtotal, 2) }}</x-pegboard::table.header>
        </x-pegboard::table.row>
        <x-pegboard::table.row>
            <x-pegboard::table.header colspan="3">Tax (10%)</x-pegboard::table.header>
            <x-pegboard::table.header align="right">${{ number_format($tax, 2) }}</x-pegboard::table.header>
        </x-pegboard::table.row>
        <x-pegboard::table.row>
            <x-pegboard::table.header colspan="3">Total</x-pegboard::table.header>
            <x-pegboard::table.header align="right">${{ number_format($total, 2) }}</x-pegboard::table.header>
        </x-pegboard::table.row>
    </x-pegboard::table.foot>
</x-pegboard::table>
```

### Long Scrollable Table with Sticky Header

```blade
<div class="max-h-96 overflow-y-auto scrollbar-thin border border-border rounded-lg">
    <x-pegboard::table variant="striped" :stickyHeader="true">
        <x-pegboard::table.head>
            <x-pegboard::table.row>
                <x-pegboard::table.header>#</x-pegboard::table.header>
                <x-pegboard::table.header>Customer</x-pegboard::table.header>
                <x-pegboard::table.header>Product</x-pegboard::table.header>
                <x-pegboard::table.header align="right">Amount</x-pegboard::table.header>
                <x-pegboard::table.header align="center">Status</x-pegboard::table.header>
            </x-pegboard::table.row>
        </x-pegboard::table.head>
        <x-pegboard::table.body>
            @foreach($orders as $order)
                <x-pegboard::table.row>
                    <x-pegboard::table.cell>#{{ $order->id }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell>{{ $order->customer }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell>{{ $order->product }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell align="right">${{ number_format($order->amount, 2) }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell align="center">
                        <x-pegboard::badge :variant="$order->status_color">{{ $order->status }}</x-pegboard::badge>
                    </x-pegboard::table.cell>
                </x-pegboard::table.row>
            @endforeach
        </x-pegboard::table.body>
    </x-pegboard::table>
</div>
```

### Complex Table: Sticky Header + Sticky Column + Actions

```blade
<div class="max-h-96 overflow-y-auto scrollbar-thin">
    <x-pegboard::table variant="striped" :stickyHeader="true">
        <x-pegboard::table.head>
            <x-pegboard::table.row>
                <x-pegboard::table.header sticky="left">Product</x-pegboard::table.header>
                <x-pegboard::table.header>Category</x-pegboard::table.header>
                <x-pegboard::table.header>SKU</x-pegboard::table.header>
                <x-pegboard::table.header align="right">Price</x-pegboard::table.header>
                <x-pegboard::table.header align="center">Stock</x-pegboard::table.header>
                <x-pegboard::table.header>Supplier</x-pegboard::table.header>
                <x-pegboard::table.header sticky="right" align="right">Actions</x-pegboard::table.header>
            </x-pegboard::table.row>
        </x-pegboard::table.head>
        <x-pegboard::table.body>
            @foreach($products as $product)
                <x-pegboard::table.row>
                    <x-pegboard::table.cell sticky="left">{{ $product->name }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell>{{ $product->category }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell>{{ $product->sku }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell align="right">${{ number_format($product->price, 2) }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell align="center">{{ $product->stock }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell>{{ $product->supplier }}</x-pegboard::table.cell>
                    <x-pegboard::table.cell sticky="right" align="right">
                        <div class="flex gap-1 justify-end">
                            <button>Edit</button>
                            <button>Delete</button>
                        </div>
                    </x-pegboard::table.cell>
                </x-pegboard::table.row>
            @endforeach
        </x-pegboard::table.body>
    </x-pegboard::table>
</div>
```

## Best Practices

### 1. Choose the Right Variant

- **Default**: Clean, minimal tables for simple data
- **Striped**: Better readability for tables with many rows
- **Bordered**: Clear cell boundaries for complex data relationships

### 2. Use Appropriate Sizes

- **xs**: Dense dashboards, data-heavy interfaces
- **sm**: Compact tables with moderate content
- **md**: Default for most use cases
- **lg**: Emphasis on content, fewer rows, spacious layouts

### 3. Sticky Headers for Long Lists

Always use sticky headers when displaying more than 10-15 rows:

```blade
<div class="max-h-96 overflow-y-auto scrollbar-thin">
    <x-pegboard::table :stickyHeader="true">
        <!-- Long list -->
    </x-pegboard::table>
</div>
```

### 4. Sticky Columns for Wide Tables

Use sticky first column for identifying information (names, IDs):

```blade
<x-pegboard::table.header sticky="left">Employee Name</x-pegboard::table.header>
```

Use sticky last column for actions:

```blade
<x-pegboard::table.header sticky="right">Actions</x-pegboard::table.header>
```

### 5. Align Numeric Data

Always right-align numeric data for easier scanning:

```blade
<x-pegboard::table.cell align="right">${{ number_format($price, 2) }}</x-pegboard::table.cell>
```

### 6. Use Thin Scrollbars

Add `scrollbar-thin` to scrollable containers for a better UX:

```blade
<div class="max-h-96 overflow-y-auto scrollbar-thin">
    <!-- table -->
</div>
```

### 7. Footer for Totals

Use table footer for totals and summaries:

```blade
<x-pegboard::table.foot>
    <x-pegboard::table.row>
        <x-pegboard::table.header colspan="3">Total</x-pegboard::table.header>
        <x-pegboard::table.header align="right">{{ $total }}</x-pegboard::table.header>
    </x-pegboard::table.row>
</x-pegboard::table.foot>
```

### 8. Responsive Considerations

For mobile-first designs, consider hiding less important columns using responsive utilities:

```blade
<x-pegboard::table.header class="hidden md:table-cell">Department</x-pegboard::table.header>
```

### 9. Empty States

Handle empty data gracefully:

```blade
<x-pegboard::table.body>
    @forelse($users as $user)
        <x-pegboard::table.row>
            <!-- User data -->
        </x-pegboard::table.row>
    @empty
        <x-pegboard::table.row>
            <x-pegboard::table.cell colspan="4" class="text-center py-8 text-muted-foreground">
                No users found
            </x-pegboard::table.cell>
        </x-pegboard::table.row>
    @endforelse
</x-pegboard::table.body>
```

### 10. Loading States

Show loading state while fetching data:

```blade
<x-pegboard::table.body>
    @if($loading)
        <x-pegboard::table.row>
            <x-pegboard::table.cell colspan="4" class="text-center py-8">
                <x-pegboard::spinner />
                Loading...
            </x-pegboard::table.cell>
        </x-pegboard::table.row>
    @else
        @foreach($data as $item)
            <!-- Data rows -->
        @endforeach
    @endif
</x-pegboard::table.body>
```

## Accessibility

The table component is built with accessibility in mind:

### Semantic HTML

- Uses proper `<table>`, `<thead>`, `<tbody>`, `<tfoot>`, `<tr>`, `<th>`, `<td>` elements
- Headers use `<th>` with proper scope attributes
- Maintains logical document structure

### Screen Readers

- Table headers are properly associated with data cells
- Use `scope="col"` for column headers (automatically applied)
- Use `scope="row"` for row headers when appropriate

### Keyboard Navigation

- All interactive elements (buttons, links) within cells are keyboard accessible
- Scrollable containers are keyboard navigable

### Visual Considerations

- Sufficient color contrast in all variants
- Hover effects use primary color for clear visibility
- Distinct header background (`table-header` token) for clear hierarchy
- Sticky headers maintain z-index layering for proper stacking

### Best Practices for Accessibility

1. **Add captions for complex tables:**

```blade
<x-pegboard::table>
    <caption class="sr-only">Employee salary information</caption>
    <!-- Table content -->
</x-pegboard::table>
```

2. **Use descriptive headers:**

```blade
{{-- Good --}}
<x-pegboard::table.header>Employee Name</x-pegboard::table.header>

{{-- Avoid --}}
<x-pegboard::table.header>Name</x-pegboard::table.header>
```

3. **Provide context for icon-only actions:**

```blade
<button aria-label="Edit user John Doe">
    <x-pegboard::icon name="pencil" />
</button>
```

4. **Announce dynamic updates:**

```blade
<div role="status" aria-live="polite" class="sr-only">
    {{ $updateMessage }}
</div>
```

## Styling

### Pure Tailwind Approach

The table component is built **entirely with Tailwind CSS** utilities. All styling is controlled via Tailwind classes applied in the Blade components.

**Key Styling Classes:**

| Feature | Tailwind Classes |
|---------|------------------|
| Hover | `[&_tbody_tr]:hover:bg-primary/8` |
| Striped | `[&_tbody_tr:nth-child(odd)]:bg-muted/30` |
| Sticky Header | `[&_thead]:sticky [&_thead]:top-0 [&_thead]:z-20` |
| Header Background | `bg-table-header` |
| Scrollbar | `scrollbar-thin` (custom utility) |

### Theme Tokens

The table uses semantic theme tokens:

| Token | Light Mode | Dark Mode | Usage |
|-------|------------|-----------|-------|
| `--color-table-header` | `neutral-100` | `neutral-900` | Header background |
| `--color-primary` | `brand-600` | `brand-600` | Hover effect (8% opacity) |
| `--color-muted` | `neutral-200` | `neutral-600` | Striped rows (30% opacity) |

### Customizing Styles

Override styles using Tailwind's `class` attribute:

```blade
{{-- Custom header background --}}
<x-pegboard::table.head class="bg-accent">
    <!-- headers -->
</x-pegboard::table.head>

{{-- Custom hover color --}}
<x-pegboard::table class="[&_tbody_tr]:hover:bg-accent/10">
    <!-- table content -->
</x-pegboard::table>

{{-- Custom row styling --}}
<x-pegboard::table.row class="bg-warning/10">
    <!-- highlighted row -->
</x-pegboard::table.row>
```

---

## Additional Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [Pegboard Design Principles](../CLAUDE.md#pegboard-design-principles-critical)
- [MDN: HTML Table Element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/table)
- [WCAG 2.1 Table Guidelines](https://www.w3.org/WAI/tutorials/tables/)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
