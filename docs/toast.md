# Toast Component

A powerful, accessible toast notification system with smart stacking, hover expansion, auto-dismiss, and support for multiple variants and positions.

## Table of Contents

- [Overview](#overview)
- [Basic Usage](#basic-usage)
- [Component Structure](#component-structure)
- [Props Reference](#props-reference)
- [Positions](#positions)
- [Variants](#variants)
- [Features](#features)
  - [Auto-Dismiss](#auto-dismiss)
  - [Smart Stacking](#smart-stacking)
  - [Hover Expansion](#hover-expansion)
  - [Manual Dismissal](#manual-dismissal)
  - [Icons](#icons)
  - [Headings](#headings)
  - [Progress Bar](#progress-bar)
  - [Action Buttons](#action-buttons)
  - [Keyboard Shortcuts](#keyboard-shortcuts)
- [API Reference](#api-reference)
  - [JavaScript API](#javascript-api)
  - [Livewire Integration](#livewire-integration)
  - [Alpine.js Magic](#alpinejs-magic)
  - [Session Flash](#session-flash)
- [Examples](#examples)
- [Best Practices](#best-practices)
- [Accessibility](#accessibility)

## Overview

The Pegboard toast component provides an elegant, non-intrusive way to display temporary notifications to users. Built with Alpine.js and Tailwind CSS v4, it features intelligent stacking, smooth animations, and comprehensive functionality for modern web applications.

**Key Features:**
- Four visual variants (default, success, warning, danger)
- Six position options (corners and centers)
- Smart stacking with scaling and offset
- Hover expansion for easy interaction with pause on hover
- Auto-dismiss with configurable duration
- **Visual progress bar showing remaining time**
- **Shorthand methods for quick toasts** (`Pegboard.toast.success()`, etc.)
- **Action buttons for interactive toasts** (Undo, View, Retry, etc.)
- **Keyboard shortcuts** (Escape to dismiss all)
- Manual close buttons
- Maximum toast limit (4 by default)
- Icon indicators per variant
- Optional heading support
- Smooth GPU-accelerated animations
- Livewire event integration
- Session flash support
- Global JavaScript API
- Full keyboard accessibility

## Basic Usage

### Setup

Include the toast component in your layout (usually in your main layout file):

```blade
{{-- resources/views/components/layouts/app.blade.php --}}
<body>
    <!-- Your content -->

    {{-- Toast container (bottom-right by default) --}}
    <x-pegboard::toast />
</body>
```

### Triggering Toasts

**From JavaScript (Recommended - Framework Agnostic):**

```javascript
// Simple text toast
Pegboard.toast('Changes saved successfully');

// Shorthand methods (NEW!)
Pegboard.toast.success('Profile updated');
Pegboard.toast.error('Failed to save changes');
Pegboard.toast.warning('Session expiring soon');
Pegboard.toast.danger('Critical error occurred');

// Toast with full options
Pegboard.toast({
    text: 'Profile updated',
    variant: 'success',
    heading: 'Success!',
    duration: 4000,
});

// Toast with action button (NEW!)
Pegboard.toast({
    text: 'Item deleted',
    variant: 'success',
    action: {
        label: 'Undo',
        onClick: () => {
            // Restore the item
            restoreItem();
        }
    }
});
```

**Using Plain HTML onclick (No Alpine Context Required):**

```blade
{{-- Works anywhere, no Alpine needed --}}
<button onclick="Pegboard.toast.success('Saved!')">
    Save
</button>

<button onclick="Pegboard.toast({
    text: 'Are you sure?',
    variant: 'warning',
    duration: 0
})">
    Delete
</button>
```

**From Livewire:**

```php
// In your Livewire component
$this->dispatch('pegboard:toast', [
    'text' => 'User created successfully',
    'variant' => 'success',
]);
```

**From Alpine.js:**

```blade
<button @click="$pegboard.toast('Item added to cart')">
    Add to Cart
</button>
```

## Component Structure

The toast system uses a centralized container with Alpine.js store for state management:

```
<x-pegboard::toast>                    <!-- Fixed container -->
    <div x-ref="toastStack">           <!-- Hover-sensitive wrapper -->
        <div x-for="...">              <!-- Individual toast -->
            <icon>                      <!-- Variant icon -->
            <content>                   <!-- Heading + text -->
            <button>                    <!-- Close button -->
        </div>
    </div>
</x-pegboard::toast>
```

**Important:** Only one toast container should exist per page. Multiple containers will create separate, isolated toast systems.


## Props Reference

### Toast Container

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `position` | string | `'bottom end'` | Toast position: `top start`, `top center`, `top end`, `bottom start`, `bottom center`, `bottom end` |

### Toast Options (JavaScript/Livewire)

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `text` | string | **required** | Main message text to display |
| `heading` | string\|null | `null` | Optional heading text (displayed above message) |
| `variant` | string | `'default'` | Visual style: `default`, `success`, `warning`, `danger` |
| `duration` | number | `4000` | Auto-dismiss duration in milliseconds (0 = no auto-dismiss) |
| `action` | object\|null | `null` | Optional action button with `label` (string) and `onClick` (function) |

**Action Button Structure:**
```typescript
{
    label: string;    // Button text (e.g., "Undo", "View", "Retry")
    onClick: () => void;  // Callback function executed when clicked
}
```


## Positions

Control where toasts appear on screen using the `position` prop:

### Top Positions

```blade
{{-- Top-left corner --}}
<x-pegboard::toast position="top start" />

{{-- Top-center (horizontally centered) --}}
<x-pegboard::toast position="top center" />

{{-- Top-right corner --}}
<x-pegboard::toast position="top end" />
```

**Visual characteristics:**
- New toasts slide in from above
- Stack grows downward
- Positioned with `top-4 sm:top-6` spacing

### Bottom Positions (Default)

```blade
{{-- Bottom-left corner --}}
<x-pegboard::toast position="bottom start" />

{{-- Bottom-center (horizontally centered) --}}
<x-pegboard::toast position="bottom center" />

{{-- Bottom-right corner (default) --}}
<x-pegboard::toast position="bottom end" />
```

**Visual characteristics:**
- New toasts slide in from below
- Stack grows upward
- Positioned with `bottom-4 sm:bottom-6` spacing

### Responsive Spacing

All positions use responsive spacing:
- Mobile: `16px` from edge (`4` in Tailwind)
- Desktop (`sm` breakpoint): `24px` from edge (`6` in Tailwind)

### Position Matching

**Do:** Choose positions that don't conflict with other UI elements:

```blade
{{-- ✅ Good - Bottom-right for most applications --}}
<x-pegboard::toast position="bottom end" />

{{-- ✅ Good - Top-right if you have bottom navigation --}}
<x-pegboard::toast position="top end" />

{{-- ✅ Good - Top-center for important announcements --}}
<x-pegboard::toast position="top center" />
```

**Avoid:** Positions that overlap with navigation or action buttons.

## Variants

### Default (Neutral)

Standard toast for general messages without semantic meaning:

```javascript
Pegboard.toast({
    text: 'Settings have been updated',
    variant: 'default',
});
```

**Visual characteristics:**
- `bg-card` background with `border-border` border
- No icon displayed
- Neutral appearance

**Use cases:**
- General informational messages
- Confirmation of actions
- Status updates

### Success (Green)

Indicates successful operations:

```javascript
Pegboard.toast({
    text: 'Profile saved successfully',
    variant: 'success',
    heading: 'Success',
});
```

**Visual characteristics:**
- `bg-success-subtle` background with `border-success/30` border
- Green checkmark circle icon
- Positive, encouraging appearance

**Use cases:**
- Successful form submissions
- Completed operations
- Items created/updated

### Warning (Yellow/Orange)

Alerts users to potential issues or important information:

```javascript
Pegboard.toast({
    text: 'Your session will expire in 5 minutes',
    variant: 'warning',
    heading: 'Warning',
});
```

**Visual characteristics:**
- `bg-warning-subtle` background with `border-warning/30` border
- Yellow warning triangle icon
- Attention-grabbing appearance

**Use cases:**
- Expiring sessions
- Validation warnings
- Non-critical errors
- Important reminders

### Danger (Red)

Indicates errors or destructive actions:

```javascript
Pegboard.toast({
    text: 'Failed to save changes. Please try again.',
    variant: 'danger',
    heading: 'Error',
});
```

**Visual characteristics:**
- `bg-danger-subtle` background with `border-destructive/30` border
- Red alert circle icon
- Critical, urgent appearance

**Use cases:**
- Failed operations
- Server errors
- Validation errors
- Destructive action confirmations

## Features

### Auto-Dismiss

Toasts automatically dismiss after a configurable duration:

**Default behavior (4 seconds):**

```javascript
Pegboard.toast('This will dismiss after 4 seconds');
```

**Custom duration:**

```javascript
// 2 seconds
Pegboard.toast({
    text: 'Quick notification',
    duration: 2000,
});

// 10 seconds
Pegboard.toast({
    text: 'Important message - read carefully',
    duration: 10000,
});
```

**Persistent toast (no auto-dismiss):**

```javascript
Pegboard.toast({
    text: 'Manual dismissal required',
    duration: 0, // Will not auto-dismiss
});
```

**Best practice:** Use longer durations for error messages and shorter durations for success confirmations.

### Smart Stacking

When multiple toasts are displayed simultaneously, they stack intelligently:

**Stacked state (default):**
- Toasts overlap with scaling effect
- Each toast scaled down by 6% (100%, 94%, 88%, 82%)
- Each toast offset by 16px
- Maximum 4 visible toasts
- Oldest toasts fade out when limit exceeded

**Example:**
```javascript
// Add multiple toasts
Pegboard.toast('First notification');
Pegboard.toast('Second notification');
Pegboard.toast('Third notification');
// They stack with scale and offset
```

**Automatic management:**
- When a 5th toast is added, the oldest is automatically dismissed
- Smooth transitions between positions
- GPU-accelerated animations for performance

### Hover Expansion

When multiple toasts are stacked, hovering over the toast area expands all toasts with spacing, making it easy to interact with them. The expansion persists while moving between toasts for a smooth experience.

### Manual Dismissal

Users can manually close toasts before auto-dismiss:

**Close button visibility:**
- Always visible on the topmost toast
- Visible on all toasts during hover expansion
- Smooth fade-in/fade-out animation

**Programmatic dismissal:**

```javascript
// Get toast ID when creating
const toastId = Pegboard.toast('Persistent message');

// Dismiss later
Alpine.store('toasts').burn(toastId);

// Or clear all toasts
Alpine.store('toasts').clear();
```

**From Livewire:**

```blade
<button wire:click="clearToasts">Clear All Notifications</button>
```

```php
// In your Livewire component
public function clearToasts()
{
    $this->dispatch('pegboard:toast:clear');
}
```

### Icons

Each variant displays an appropriate icon automatically:

**Success icon:**
- Checkmark circle (Heroicon: `check-circle`)
- Color: `text-success`

**Warning icon:**
- Warning triangle (Heroicon: `exclamation-triangle`)
- Color: `text-warning`

**Danger icon:**
- Alert circle (Heroicon: `exclamation-circle`)
- Color: `text-destructive`

**Default:**
- No icon displayed

**Icons are not customizable** to maintain consistency across the application. Use the appropriate variant for semantic meaning.

### Headings

Add optional headings to provide context:

```javascript
// Without heading
Pegboard.toast({
    text: 'Profile updated successfully',
    variant: 'success',
});

// With heading
Pegboard.toast({
    text: 'Your profile has been updated and saved to the server',
    heading: 'Success!',
    variant: 'success',
});
```

**Visual characteristics:**
- Displayed above main text
- `font-semibold` weight
- `text-foreground` color
- Slightly larger than body text
- 4px bottom margin

**Best practices:**
- Keep headings short (1-3 words)
- Use for categorization ("Error", "Success", "Update")
- Optional for simple messages
- Helpful for complex notifications

### Progress Bar

Toasts with a duration greater than 0 automatically display a visual progress bar showing the remaining time:

**How it works:**

```javascript
// Default 4 second toast - progress bar fills automatically
Pegboard.toast.success('Changes saved');

// Custom duration - progress bar adjusts accordingly
Pegboard.toast({
    text: 'Processing your request',
    variant: 'default',
    duration: 10000, // 10 second progress bar
});

// No progress bar for persistent toasts
Pegboard.toast({
    text: 'Manual dismissal required',
    duration: 0, // No progress bar
});
```

**Visual characteristics:**
- Thin 4px bar at the bottom of the toast
- Color-coordinated with toast variant:
  - Success: `bg-success`
  - Warning: `bg-warning`
  - Danger: `bg-destructive`
  - Default: `bg-primary`
- Smooth CSS transition from 100% to 0%
- Rounded bottom corners matching toast

**Pause on hover:**
The progress bar automatically pauses when you hover over any toast in the stack:

```javascript
// Add a toast
Pegboard.toast({
    text: 'Session expiring soon',
    variant: 'warning',
    duration: 8000,
});

// When user hovers:
// - Progress bar freezes at current position
// - All toasts expand for easy interaction
// - Auto-dismiss timer pauses

// When user moves cursor away:
// - Progress bar resumes from paused position
// - Remaining time continues countdown
// - Toasts collapse back to stacked state
```

**Implementation details:**
- Uses CSS transitions for smooth animation
- Tracks remaining duration when paused
- Resumes with exact remaining time
- No visual jump when pausing/resuming
- GPU-accelerated for performance

**Best practices:**
- Progress bars work best with 3-8 second durations
- Very short durations (<2s) may make the bar hard to see
- Very long durations (>10s) should use manual dismiss (duration: 0)
- Users can always manually close toasts regardless of progress

### Action Buttons

Add interactive action buttons to toasts for common workflows like undo, view, or retry:

**Basic usage:**

```javascript
// Undo delete action
Pegboard.toast({
    text: 'Item deleted',
    variant: 'success',
    action: {
        label: 'Undo',
        onClick: () => {
            restoreItem();
            Pegboard.toast.success('Item restored!');
        }
    }
});

// View details action
Pegboard.toast({
    text: 'New message received',
    variant: 'default',
    action: {
        label: 'View',
        onClick: () => {
            window.location.href = '/messages';
        }
    }
});

// Retry failed action
Pegboard.toast({
    text: 'Upload failed',
    variant: 'danger',
    action: {
        label: 'Retry',
        onClick: () => {
            retryUpload();
        }
    }
});
```

**Visual characteristics:**
- Underlined text link below the toast message
- Color-coordinated with variant:
  - Success: `text-success`
  - Warning: `text-warning`
  - Danger: `text-destructive`
  - Default: `text-primary`
- Hover state removes underline for clear interaction
- Smooth transitions on hover

**Behavior:**
- Clicking the action button automatically dismisses the toast
- The `onClick` callback executes before dismissal
- Action buttons work with all toast variants
- Compatible with progress bars and auto-dismiss

**Common use cases:**

```javascript
// 1. Undo destructive actions
Pegboard.toast({
    text: '5 items deleted',
    variant: 'success',
    action: {
        label: 'Undo',
        onClick: () => restoreBulkItems()
    }
});

// 2. Navigate to related content
Pegboard.toast({
    text: 'Report generated successfully',
    variant: 'success',
    action: {
        label: 'View Report',
        onClick: () => window.open('/reports/latest', '_blank')
    }
});

// 3. Retry failed operations
Pegboard.toast({
    text: 'Connection failed',
    variant: 'danger',
    duration: 0, // Persistent until user acts
    action: {
        label: 'Retry',
        onClick: async () => {
            await retryConnection();
        }
    }
});

// 4. Open settings or configuration
Pegboard.toast({
    text: 'Notifications are disabled',
    variant: 'warning',
    action: {
        label: 'Enable',
        onClick: () => {
            openNotificationSettings();
        }
    }
});

// 5. Dismiss with confirmation
Pegboard.toast({
    text: 'Unsaved changes detected',
    variant: 'warning',
    duration: 0,
    action: {
        label: 'Save Now',
        onClick: () => {
            saveChanges();
        }
    }
});
```

**Best practices:**
- Keep action labels short (1-2 words): "Undo", "View", "Retry", "Enable"
- Action buttons should perform immediate, clear actions
- For persistent toasts (duration: 0), actions become primary user interaction
- Avoid multiple actions per toast - keep it simple
- Don't use action buttons for navigation-only tasks unless contextually relevant

### Keyboard Shortcuts

The toast component includes keyboard shortcuts for efficient toast management:

**Escape key - Dismiss all toasts:**

```javascript
// User presses Escape → All toasts dismissed instantly
```

**Behavior:**
- Pressing `Escape` dismisses all visible toasts at once
- Only works when no modal/dialog is currently open
- Respects the modal/dialog priority hierarchy
- Smooth exit animations for all toasts
- Clears the entire toast queue

**Use cases:**
- Quickly clearing multiple stacked toasts
- Dismissing persistent toasts (duration: 0)
- Clearing toast clutter during workflow
- Keyboard-first users

**Example scenarios:**

```javascript
// Scenario 1: Multiple toasts stacked
Pegboard.toast.success('File 1 uploaded');
Pegboard.toast.success('File 2 uploaded');
Pegboard.toast.success('File 3 uploaded');
Pegboard.toast.success('File 4 uploaded');
// User presses Escape → All 4 toasts dismissed

// Scenario 2: Persistent warning
Pegboard.toast({
    text: 'Critical error occurred',
    variant: 'danger',
    duration: 0, // Won't auto-dismiss
});
// User presses Escape → Toast dismissed

// Scenario 3: Modal is open
// User presses Escape → Modal closes (toasts remain)
// User presses Escape again → Toasts dismissed
```

**Implementation details:**
- Event listener attached at toast component initialization
- Checks for `dialog[open]` selector before dismissing
- Only one toast container should listen to prevent conflicts
- Cleanup on component destruction

**Accessibility:**
- Standard keyboard shortcut pattern (Escape = dismiss/cancel)
- Announced to screen readers via ARIA live region
- Works with keyboard-only navigation
- No conflict with form inputs or textareas

**Limitations:**
- Does not work when a modal/dialog is open (by design)
- Dismisses ALL toasts, not individual toasts
- Cannot be customized to other keys (standardized UX)

**Best practices:**
- Inform power users about the Escape shortcut
- Use for clearing toast clutter during demos
- Helpful for testing toast behavior
- Don't rely on it for critical user flows

## API Reference

### JavaScript API

**Add a toast:**

```javascript
// Simple text toast
Pegboard.toast('Message text');

// Toast with options
Pegboard.toast({
    text: 'Message text',
    heading: 'Optional Heading',
    variant: 'success', // default | success | warning | danger
    duration: 4000,     // milliseconds (0 = no auto-dismiss)
    action: {           // optional action button
        label: 'Undo',
        onClick: () => { /* callback */ }
    }
});

// Returns toast ID for later reference
const toastId = Pegboard.toast('My message');
```

**Shorthand methods (NEW!):**

```javascript
// Success toast
Pegboard.toast.success('Profile updated');
Pegboard.toast.success('Changes saved', 'Success'); // with heading

// Error toast
Pegboard.toast.error('Failed to save changes');
Pegboard.toast.error('Network error occurred', 'Error'); // with heading

// Warning toast
Pegboard.toast.warning('Session expiring soon');
Pegboard.toast.warning('Unsaved changes', 'Warning'); // with heading

// Danger toast (alias for error)
Pegboard.toast.danger('Critical error occurred');
Pegboard.toast.danger('Payment failed', 'Error'); // with heading
```

**Method signatures:**
```typescript
// Main method
Pegboard.toast(options: string | ToastOptions): number

// Shorthand methods
Pegboard.toast.success(text: string, heading?: string): number
Pegboard.toast.error(text: string, heading?: string): number
Pegboard.toast.warning(text: string, heading?: string): number
Pegboard.toast.danger(text: string, heading?: string): number

// ToastOptions interface
interface ToastOptions {
    text?: string;
    heading?: string;
    variant?: 'default' | 'success' | 'warning' | 'danger';
    duration?: number;
    action?: {
        label: string;
        onClick: () => void;
    };
}
```

**Remove a specific toast:**

```javascript
const toastId = Pegboard.toast('Message');

// Dismiss this toast
Alpine.store('toasts').burn(toastId);
// or
Alpine.store('toasts').remove(toastId); // alias
```

**Clear all toasts:**

```javascript
Alpine.store('toasts').clear();
```

**Access toast store:**

```javascript
// Get all active toasts
const toasts = Alpine.store('toasts').items;

// Get next ID
const nextId = Alpine.store('toasts').nextId;

// Get max toast limit
const maxToasts = Alpine.store('toasts').maxToasts;
```

### Livewire Integration

**Dispatch from Livewire component:**

```php
// Simple text toast
$this->dispatch('pegboard:toast', ['text' => 'Changes saved']);

// Toast with options
$this->dispatch('pegboard:toast', [
    'text' => 'User created successfully',
    'heading' => 'Success',
    'variant' => 'success',
    'duration' => 3000,
]);
```

**In Livewire class methods:**

```php
namespace App\Livewire;

use Livewire\Component;

class UserForm extends Component
{
    public function save()
    {
        // Validation, saving logic...

        $this->dispatch('pegboard:toast', [
            'text' => 'User has been saved',
            'variant' => 'success',
        ]);
    }

    public function delete()
    {
        // Deletion logic...

        $this->dispatch('pegboard:toast', [
            'text' => 'User has been deleted',
            'variant' => 'danger',
            'heading' => 'Deleted',
        ]);
    }
}
```

### Alpine.js Magic

**Use the `$pegboard` magic helper:**

```blade
{{-- Simple toast --}}
<button @click="$pegboard.toast('Item added to cart')">
    Add to Cart
</button>

{{-- Toast with options --}}
<button @click="$pegboard.toast({
    text: 'Product saved to wishlist',
    variant: 'success',
    heading: 'Saved'
})">
    Add to Wishlist
</button>

{{-- Dynamic content --}}
<div x-data="{ count: 0 }">
    <button @click="count++; $pegboard.toast(`Count is now ${count}`)">
        Increment
    </button>
</div>
```

### Session Flash

**From Laravel controllers (server-side):**

```php
namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        // Validation and update logic...

        session()->flash('pegboard:toast', [
            'text' => 'Profile updated successfully',
            'variant' => 'success',
        ]);

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('pegboard:toast', [
            'text' => 'User has been deleted',
            'variant' => 'danger',
            'heading' => 'Deleted',
            'duration' => 5000,
        ]);

        return redirect()->route('users.index');
    }
}
```

**Multiple toasts via session:**

```php
session()->flash('pegboard:toast', [
    [
        'text' => 'Profile updated',
        'variant' => 'success',
    ],
    [
        'text' => 'Email verification sent',
        'variant' => 'success',
    ],
]);
```

**The toast container automatically displays flashed toasts on page load.**

## Examples

### Basic Success Toast

```javascript
Pegboard.toast({
    text: 'Settings saved successfully',
    variant: 'success',
});
```

### Error Toast with Heading

```javascript
Pegboard.toast({
    text: 'Unable to connect to server. Please check your connection.',
    heading: 'Connection Error',
    variant: 'danger',
    duration: 6000, // Longer duration for errors
});
```

### Warning Toast

```javascript
Pegboard.toast({
    text: 'Your trial expires in 3 days',
    heading: 'Trial Expiring',
    variant: 'warning',
    duration: 8000,
});
```

### Persistent Toast (Manual Dismiss Only)

```javascript
Pegboard.toast({
    text: 'Please review these important changes',
    heading: 'Action Required',
    variant: 'warning',
    duration: 0, // No auto-dismiss
});
```

### Form Submission (Livewire)

```php
// app/Livewire/ContactForm.php
namespace App\Livewire;

use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $message;

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Send email logic...

        $this->dispatch('pegboard:toast', [
            'text' => 'Your message has been sent. We\'ll get back to you soon!',
            'heading' => 'Message Sent',
            'variant' => 'success',
        ]);

        $this->reset();
    }
}
```

### Cart Operations (Alpine.js)

```blade
<div x-data="{
    items: [],

    addToCart(product) {
        this.items.push(product);
        this.$pegboard.toast({
            text: product.name + ' added to cart',
            variant: 'success',
        });
    },

    removeFromCart(index) {
        const product = this.items[index];
        this.items.splice(index, 1);
        this.$pegboard.toast({
            text: product.name + ' removed from cart',
            variant: 'default',
        });
    },

    checkout() {
        if (this.items.length === 0) {
            this.$pegboard.toast({
                text: 'Your cart is empty',
                variant: 'warning',
            });
            return;
        }
        // Checkout logic...
    }
}">
    <!-- Cart UI -->
</div>
```

### Multiple Toast Positions

```blade
{{-- Different positions for different contexts --}}
<x-pegboard::toast position="top end" />

{{-- In a modal context --}}
<div class="modal">
    {{-- Use top center for modal-specific notifications --}}
    <x-pegboard::toast position="top center" />
</div>
```

### Auto-Save Feedback

```blade
<div x-data="{
    content: '',
    saving: false,

    async autoSave() {
        this.saving = true;

        try {
            await fetch('/api/save', {
                method: 'POST',
                body: JSON.stringify({ content: this.content }),
            });

            this.$pegboard.toast({
                text: 'Changes saved',
                variant: 'success',
                duration: 2000, // Quick feedback
            });
        } catch (error) {
            this.$pegboard.toast({
                text: 'Failed to save changes',
                variant: 'danger',
                duration: 5000, // Longer for errors
            });
        } finally {
            this.saving = false;
        }
    }
}" x-effect="autoSave()">
    <textarea x-model.debounce.1000ms="content"></textarea>
</div>
```

### Progressive Loading

```blade
<button @click="
    $pegboard.toast('Loading data...');

    fetch('/api/data')
        .then(response => response.json())
        .then(data => {
            $pegboard.toast({
                text: 'Data loaded successfully',
                variant: 'success',
            });
        })
        .catch(error => {
            $pegboard.toast({
                text: 'Failed to load data',
                variant: 'danger',
            });
        });
">
    Load Data
</button>
```

### Session Flash (Laravel Controller)

```php
namespace App\Http\Controllers;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validation and order creation...

        session()->flash('pegboard:toast', [
            'text' => 'Order #' . $order->id . ' has been placed successfully',
            'heading' => 'Order Placed',
            'variant' => 'success',
            'duration' => 5000,
        ]);

        return redirect()->route('orders.show', $order);
    }
}
```

### Bulk Operations

```javascript
// Delete multiple items
async function deleteBulk(ids) {
    const toastId = Pegboard.toast({
        text: `Deleting ${ids.length} items...`,
        duration: 0, // Persistent during operation
    });

    try {
        await fetch('/api/bulk-delete', {
            method: 'DELETE',
            body: JSON.stringify({ ids }),
        });

        // Remove loading toast
        Alpine.store('toasts').burn(toastId);

        // Show success
        Pegboard.toast({
            text: `${ids.length} items deleted successfully`,
            variant: 'success',
        });
    } catch (error) {
        // Remove loading toast
        Alpine.store('toasts').burn(toastId);

        // Show error
        Pegboard.toast({
            text: 'Failed to delete items',
            variant: 'danger',
        });
    }
}
```

### Undo Delete with Action Button

```javascript
// Enhanced delete with undo functionality
function deleteItem(item) {
    // Store the item for potential restoration
    const deletedItem = { ...item };

    // Perform deletion
    removeFromDatabase(item.id);

    // Show success toast with undo action
    Pegboard.toast({
        text: `"${item.name}" has been deleted`,
        variant: 'success',
        duration: 8000, // Give user 8 seconds to undo
        action: {
            label: 'Undo',
            onClick: () => {
                // Restore the item
                restoreToDatabase(deletedItem);
                Pegboard.toast.success('Item restored successfully');
            }
        }
    });
}
```

### Upload with Progress and Retry

```javascript
// File upload with progress bar and retry on failure
async function uploadFile(file) {
    try {
        const formData = new FormData();
        formData.append('file', file);

        const response = await fetch('/api/upload', {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) throw new Error('Upload failed');

        // Success with progress bar (auto-dismiss in 4 seconds)
        Pegboard.toast.success(`${file.name} uploaded successfully`);

    } catch (error) {
        // Error with retry action (persistent until user acts)
        Pegboard.toast({
            text: `Failed to upload ${file.name}`,
            variant: 'danger',
            duration: 0, // Persistent
            action: {
                label: 'Retry',
                onClick: () => uploadFile(file) // Retry the upload
            }
        });
    }
}
```

### Shorthand Methods for Quick Feedback

```javascript
// Using shorthand methods for cleaner code
function saveUserProfile(data) {
    if (!data.email) {
        Pegboard.toast.warning('Email is required');
        return;
    }

    try {
        // Save logic...
        Pegboard.toast.success('Profile saved');
    } catch (error) {
        Pegboard.toast.error('Failed to save profile');
    }
}

// Form validation feedback
function validateForm(formData) {
    const errors = [];

    if (!formData.name) errors.push('Name is required');
    if (!formData.email) errors.push('Email is required');

    if (errors.length > 0) {
        errors.forEach(error => {
            Pegboard.toast.warning(error);
        });
        return false;
    }

    return true;
}
```

### Keyboard Shortcut Demo

```javascript
// Test keyboard shortcuts with multiple toasts
function testKeyboardShortcuts() {
    // Add multiple toasts
    Pegboard.toast.success('File 1 uploaded');
    Pegboard.toast.success('File 2 uploaded');
    Pegboard.toast.success('File 3 uploaded');
    Pegboard.toast({
        text: 'Press Escape to dismiss all toasts',
        variant: 'default',
        duration: 0,
    });

    // User can press Escape to clear all toasts instantly
}
```

## Best Practices

### 1. Choose the Right Variant

**Use semantic variants appropriately:**

```javascript
// ✅ Good - Success for completed actions
Pegboard.toast({
    text: 'Changes saved',
    variant: 'success',
});

// ✅ Good - Warning for potential issues
Pegboard.toast({
    text: 'Session expires in 5 minutes',
    variant: 'warning',
});

// ✅ Good - Danger for errors
Pegboard.toast({
    text: 'Failed to save',
    variant: 'danger',
});

// ❌ Bad - Wrong semantic meaning
Pegboard.toast({
    text: 'Server error occurred',
    variant: 'success', // Should be 'danger'
});
```

### 2. Keep Messages Concise

```javascript
// ✅ Good - Clear and brief
Pegboard.toast('Profile updated successfully');

// ❌ Bad - Too verbose
Pegboard.toast('Your user profile has been successfully updated and all changes have been saved to the database and you will now see the updated information reflected across the entire application');

// ✅ Better - Use heading for context
Pegboard.toast({
    heading: 'Profile Updated',
    text: 'Changes saved and synced across all devices',
    variant: 'success',
});
```

### 3. Match Duration to Importance

```javascript
// ✅ Quick confirmation (2s)
Pegboard.toast({
    text: 'Copied to clipboard',
    duration: 2000,
});

// ✅ Standard feedback (4s default)
Pegboard.toast('Settings saved');

// ✅ Important warning (8s)
Pegboard.toast({
    text: 'Your session will expire soon',
    variant: 'warning',
    duration: 8000,
});

// ✅ Error requiring attention (no auto-dismiss)
Pegboard.toast({
    text: 'Payment failed. Please update your payment method.',
    variant: 'danger',
    duration: 0, // User must dismiss
});
```

### 4. Don't Overuse Toasts

```javascript
// ❌ Bad - Toast spam
function saveSettings() {
    Pegboard.toast('Validating...');
    Pegboard.toast('Saving...');
    Pegboard.toast('Updating cache...');
    Pegboard.toast('Done!');
}

// ✅ Good - Single meaningful toast
function saveSettings() {
    // Show loading indicator in UI
    // On success:
    Pegboard.toast({
        text: 'Settings saved successfully',
        variant: 'success',
    });
}

// ✅ Better - Use loading toast, then replace
async function saveSettings() {
    const loadingId = Pegboard.toast({
        text: 'Saving settings...',
        duration: 0,
    });

    try {
        await save();
        Alpine.store('toasts').burn(loadingId);
        Pegboard.toast({
            text: 'Settings saved',
            variant: 'success',
        });
    } catch (error) {
        Alpine.store('toasts').burn(loadingId);
        Pegboard.toast({
            text: 'Failed to save',
            variant: 'danger',
        });
    }
}
```

### 5. Position Thoughtfully

```blade
{{-- ✅ Good - Bottom-right for most apps --}}
<x-pegboard::toast position="bottom end" />

{{-- ✅ Good - Top-right if bottom has navigation --}}
<x-pegboard::toast position="top end" />

{{-- ✅ Good - Top-center for announcements --}}
<x-pegboard::toast position="top center" />

{{-- ❌ Avoid - Multiple toast containers --}}
<x-pegboard::toast position="bottom end" />
<x-pegboard::toast position="top end" />
{{-- Creates confusing dual notification systems --}}
```

### 6. Provide Context with Headings

```javascript
// ✅ Good - Heading provides category
Pegboard.toast({
    heading: 'Upload Complete',
    text: '3 files uploaded successfully',
    variant: 'success',
});

// ✅ Good - Heading clarifies action
Pegboard.toast({
    heading: 'Connection Lost',
    text: 'Attempting to reconnect...',
    variant: 'warning',
});

// ❌ Bad - Redundant heading
Pegboard.toast({
    heading: 'Success',
    text: 'Success! Your changes were saved.',
    variant: 'success',
});
```

### 7. Handle Async Operations

```javascript
// ✅ Good - Show loading, then result
async function performAction() {
    const loadingId = Pegboard.toast({
        text: 'Processing...',
        duration: 0,
    });

    try {
        await apiCall();
        Alpine.store('toasts').burn(loadingId);
        Pegboard.toast({
            text: 'Action completed',
            variant: 'success',
        });
    } catch (error) {
        Alpine.store('toasts').burn(loadingId);
        Pegboard.toast({
            text: error.message,
            variant: 'danger',
        });
    }
}
```

### 8. Use Appropriate Variants

| Situation | Variant | Example |
|-----------|---------|---------|
| Success confirmation | `success` | "Changes saved", "User created" |
| General information | `default` | "Settings updated", "Task completed" |
| Potential issue | `warning` | "Session expiring", "Unsaved changes" |
| Error occurred | `danger` | "Save failed", "Network error" |

### 9. Test Stacking Behavior

```javascript
// Test how multiple toasts appear
Pegboard.toast('First message');
setTimeout(() => Pegboard.toast('Second message'), 500);
setTimeout(() => Pegboard.toast('Third message'), 1000);
setTimeout(() => Pegboard.toast('Fourth message'), 1500);
setTimeout(() => Pegboard.toast('Fifth message'), 2000);

// Ensure:
// - Stacking looks good
// - Hover expansion works smoothly
// - Oldest toast dismisses when 5th appears
// - Close buttons are accessible
```

## Accessibility

The toast component follows WCAG 2.1 guidelines and ARIA best practices:

### ARIA Attributes

Toasts automatically include proper ARIA attributes:

```html
<div role="alert">
    <!-- Toast content -->
</div>
```

**Why `role="alert"`?**
- Screen readers announce toasts immediately when they appear
- Users don't need to navigate to toasts manually
- Important for time-sensitive notifications

### Screen Reader Behavior

**Announcements:**
- Toasts are announced immediately when displayed
- Heading is read first, then text
- Variant icons have semantic meaning via surrounding text

**Example announcements:**
```javascript
// "Changes saved successfully"
Pegboard.toast('Changes saved successfully');

// "Success: Profile updated"
Pegboard.toast({
    heading: 'Success',
    text: 'Profile updated',
    variant: 'success',
});
```

### Keyboard Accessibility

**Close button:**
- Fully keyboard accessible
- Focus visible ring on keyboard focus
- `Escape` key closes focused toast (standard browser behavior)

**Focus management:**
- Toasts do not steal focus when appearing
- Users can continue their current task
- Close buttons can be reached via `Tab` navigation

### Visual Accessibility

**Color contrast:**
- All variants meet WCAG AA standards (4.5:1 minimum)
- Text on backgrounds: 7:1 contrast ratio
- Icons: Sufficient contrast against backgrounds
- Border colors: 3:1 contrast for non-text contrast

**Focus indicators:**
- Close button has visible focus ring
- Ring meets 3:1 contrast requirement
- Clear visual indication of keyboard focus

### Reduced Motion

Toasts respect `prefers-reduced-motion` settings:

```css
@media (prefers-reduced-motion: reduce) {
    .toast {
        transition: none;
    }
}
```

Users who prefer reduced motion will see:
- No sliding animations
- No scaling animations
- Instant appear/disappear
- Maintains full functionality

### Best Practices for Accessibility

**1. Don't rely solely on color:**

```javascript
// ✅ Good - Text clarifies meaning
Pegboard.toast({
    heading: 'Error',
    text: 'Failed to save changes',
    variant: 'danger',
});

// ❌ Bad - Color alone conveys meaning
Pegboard.toast({
    text: 'Failed', // Not clear what failed
    variant: 'danger',
});
```

**2. Provide meaningful text:**

```javascript
// ✅ Good - Descriptive message
Pegboard.toast('Profile photo uploaded successfully');

// ❌ Bad - Vague message
Pegboard.toast('Done');
```

**3. Use appropriate durations:**

```javascript
// ✅ Good - Important errors stay longer
Pegboard.toast({
    text: 'Payment failed. Please contact support.',
    variant: 'danger',
    duration: 0, // User must acknowledge
});

// ❌ Bad - Error disappears too quickly
Pegboard.toast({
    text: 'Critical error: Data may be lost',
    variant: 'danger',
    duration: 2000, // Gone before user can read
});
```

**4. Ensure close buttons are accessible:**

```blade
{{-- Close buttons automatically have: --}}
{{-- - aria-label="Dismiss" --}}
{{-- - Keyboard accessible --}}
{{-- - Visible focus indicator --}}
{{-- - Sufficient click target size (minimum 24x24px) --}}
```

**5. Test with screen readers:**

- NVDA (Windows)
- JAWS (Windows)
- VoiceOver (macOS/iOS)
- TalkBack (Android)

Verify:
- Toasts are announced immediately
- Content is clear and understandable
- Users can dismiss toasts
- Multiple toasts are announced in order

---

## Additional Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev)
- [ARIA: alert role](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/alert_role)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Inclusive Components: Notifications](https://inclusive-components.design/notifications/)

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
