# Rating Component

Display and collect user ratings with star-based rating components. Pegboard provides two rating components: **Rating** (read-only display) and **Rating Input** (interactive form input).

## Features

- Read-only display component (`<x-pegboard::rating>`)
- Interactive input component (`<x-pegboard::rating-input>`)
- Half-star support (display only)
- 3 sizes (sm, md, lg)
- Multiple color variants (warning, primary, danger, success, pink)
- Customizable icons (star, heart, etc.)
- Hover preview states (input only)
- Reset functionality (input only)
- Alpine.js + Livewire compatible (no x-model conflicts)
- Accessible keyboard navigation

## Rating (Display Only)

Use `<x-pegboard::rating>` to display a read-only rating value, perfect for showing product ratings, reviews, or scores.

### Basic Usage

```blade
{{-- Simple rating display --}}
<x-pegboard::rating :value="4.5" />

{{-- Show numeric value --}}
<x-pegboard::rating :value="4.5" :show-value="true" />

{{-- Different maximum rating --}}
<x-pegboard::rating :value="8" :max="10" />

{{-- Custom icon --}}
<x-pegboard::rating :value="4" icon="heart" variant="pink" />
```

### Half-Star Support

The Rating component automatically displays half-stars for decimal values:

```blade
{{-- 4.5 stars → Shows 4 full stars + 1 half star --}}
<x-pegboard::rating :value="4.5" />

{{-- 3.7 stars → Shows 3 full stars + 1 half star (rounds to 0.5) --}}
<x-pegboard::rating :value="3.7" />

{{-- 4.2 stars → Shows 4 full stars (no half, < 0.5) --}}
<x-pegboard::rating :value="4.2" />
```

**Half-star logic:**
- Values with decimal ≥ 0.5 show a half-filled star
- Values with decimal < 0.5 don't show a half star
- Half stars use a CSS gradient overlay for visual effect

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | float\|null | `0` | Current rating value (supports decimals) |
| `max` | int | `5` | Maximum rating (number of stars) |
| `size` | string | `'md'` | Size: `sm`, `md`, `lg` |
| `icon` | string | `'star'` | Icon name (any Heroicon name) |
| `variant` | string | `'warning'` | Color variant: `warning`, `primary`, `danger`, `success`, `pink` |
| `showValue` | bool | `false` | Show numeric rating text above stars |

### Size Examples

```blade
<x-pegboard::rating :value="4" size="sm" />   {{-- w-4 h-4 --}}
<x-pegboard::rating :value="4" size="md" />   {{-- w-6 h-6 (default) --}}
<x-pegboard::rating :value="4" size="lg" />   {{-- w-8 h-8 --}}
```

### Variant Colors

```blade
{{-- Default: Yellow/amber color --}}
<x-pegboard::rating :value="4" variant="warning" />

{{-- Primary brand color --}}
<x-pegboard::rating :value="4" variant="primary" />

{{-- Red for critical ratings --}}
<x-pegboard::rating :value="4" variant="danger" />

{{-- Green for positive feedback --}}
<x-pegboard::rating :value="4" variant="success" />

{{-- Pink for hearts --}}
<x-pegboard::rating :value="4" icon="heart" variant="pink" />
```

### Custom Icons

Use any Heroicon name:

```blade
{{-- Star (default) --}}
<x-pegboard::rating :value="4" icon="star" />

{{-- Heart --}}
<x-pegboard::rating :value="4" icon="heart" variant="pink" />

{{-- Thumbs up --}}
<x-pegboard::rating :value="3" :max="5" icon="hand-thumb-up" />

{{-- Fire --}}
<x-pegboard::rating :value="4" icon="fire" variant="danger" />
```

### Complete Example

```blade
{{-- Product rating display --}}
<div class="space-y-2">
    <h3 class="font-semibold">Customer Reviews</h3>
    <x-pegboard::rating :value="4.5" :show-value="true" />
    <p class="text-sm text-muted-foreground">Based on 127 reviews</p>
</div>
```

## Rating Input (Interactive)

Use `<x-pegboard::rating-input>` to collect user ratings in forms. Fully compatible with Livewire `wire:model`.

### Basic Usage

```blade
{{-- Simple rating input --}}
<x-pegboard::rating-input name="rating" />

{{-- With Livewire --}}
<x-pegboard::rating-input wire:model="userRating" />

{{-- Different sizes and icons --}}
<x-pegboard::rating-input name="rating" size="lg" icon="heart" variant="pink" />

{{-- Without reset button --}}
<x-pegboard::rating-input name="rating" :show-reset="false" />

{{-- Without value display --}}
<x-pegboard::rating-input name="rating" :show-value="false" />

{{-- Disabled state --}}
<x-pegboard::rating-input name="rating" :disabled="true" />
```

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `max` | int | `5` | Maximum rating (number of stars) |
| `size` | string | `'md'` | Size: `sm`, `md`, `lg` |
| `icon` | string | `'star'` | Icon name (any Heroicon name) |
| `variant` | string | `'warning'` | Color variant: `warning`, `primary`, `danger`, `success`, `pink` |
| `disabled` | bool | `false` | Disable all interactions |
| `showReset` | bool | `true` | Show reset button when rating is selected |
| `showValue` | bool | `true` | Show "Rated X" text when rating is selected |

### Interactive Features

**Hover Preview:**
```blade
{{-- Stars highlight on hover to preview rating --}}
<x-pegboard::rating-input name="rating" />
```

**Behavior:**
- Hovering over a star highlights that star and all previous stars
- Moving mouse away resets to current selected value
- Provides clear visual feedback before clicking

**Reset Button:**
```blade
{{-- Reset button appears when a rating is selected --}}
<x-pegboard::rating-input name="rating" />
```

**Behavior:**
- Reset button (X icon) appears when `value > 0`
- Clicking reset clears the rating to 0
- Button respects `disabled` state
- Can be hidden with `:show-reset="false"`

**Value Display:**
```blade
{{-- Shows "Rated 4" text when rating is selected --}}
<x-pegboard::rating-input name="rating" />
```

**Behavior:**
- Text shows "Rated X" where X is the selected rating
- Only appears when `value > 0`
- Can be hidden with `:show-value="false"`

### Livewire Integration

Works seamlessly with Livewire's `wire:model`:

```blade
{{-- In your Blade view --}}
<x-pegboard::rating-input wire:model="productRating" />

{{-- In your Livewire component --}}
class ProductReview extends Component
{
    public int $productRating = 0;

    public function submit()
    {
        $this->validate([
            'productRating' => 'required|integer|min:1|max:5',
        ]);

        // Save rating...
    }
}
```

**Livewire features:**
- Real-time updates with `wire:model.live`
- Form validation support
- Works with `wire:loading` states
- Dispatches native `input` and `change` events

### Form Submission

Works with standard HTML forms:

```blade
<form action="/submit-review" method="POST">
    @csrf

    <label for="rating">Rate this product:</label>
    <x-pegboard::rating-input name="rating" id="rating" />

    <button type="submit">Submit Review</button>
</form>
```

**How it works:**
- Component includes a hidden `<input type="hidden">` element
- Hidden input value is updated when user clicks stars
- Form submission sends the rating value as a normal form field

### States

**Disabled State:**
```blade
<x-pegboard::rating-input :disabled="true" />
```

**Features:**
- All interactions disabled (hover, click, reset)
- Reduced opacity (50%)
- Cursor changes to `not-allowed`
- Maintains visual consistency

### Alpine.js + Livewire Compatibility

**CRITICAL: The component avoids x-model to prevent conflicts with Livewire wire:model.**

The rating input uses Alpine.js but reads/writes values directly from the DOM:

```typescript
// Alpine.js component definition (simplified)
Alpine.data('pegboardRating', () => ({
    value: 0,  // Current selected rating
    stars: 0,  // Currently highlighted stars (for hover)

    rate(star: number) {
        this.value = star;
        this.stars = star;

        // Update hidden input directly
        const input = this.$refs.input;
        input.value = star.toString();

        // Dispatch events for Livewire compatibility
        input.dispatchEvent(new Event('input', { bubbles: true }));
        input.dispatchEvent(new Event('change', { bubbles: true }));
    }
}));
```

**Why this works:**
- **Without `wire:model`:** Input works as normal HTML form field
- **With `wire:model`:** Livewire binds to the hidden input, Alpine dispatches native events
- **Actions always work:** Alpine methods update DOM directly and trigger events
- **Events propagate:** Native `input`/`change` events ensure Livewire picks up changes

**Usage examples:**

```blade
{{-- Works perfectly with Livewire wire:model --}}
<x-pegboard::rating-input wire:model.live="rating" />

{{-- Works without Livewire too --}}
<x-pegboard::rating-input name="rating" />
```

## Sizing System

Rating sizing uses PHP match expressions:

```php
// Icon sizes
$sizeClasses = match($size) {
    'sm' => 'w-4 h-4',
    'lg' => 'w-8 h-8',
    default => 'w-6 h-6',  // md
};
```

**Size guide:**
- `sm` - 16px (w-4 h-4) - Compact UI, inline ratings
- `md` - 24px (w-6 h-6) - Default, balanced size
- `lg` - 32px (w-8 h-8) - Prominent ratings, large forms

## Color Variants

Variants use theme tokens for consistent theming:

```php
$variantClasses = match($variant) {
    'primary' => 'text-primary',
    'danger' => 'text-destructive',
    'success' => 'text-success',
    'pink' => 'text-pink-600',
    default => 'text-warning',  // Yellow/amber
};
```

**Variant usage:**
- `warning` (default) - Traditional yellow/amber rating stars
- `primary` - Brand color ratings
- `danger` - Negative feedback, critical ratings
- `success` - Positive feedback, achievement ratings
- `pink` - Hearts, love-based ratings

## Complete Examples

### Product Review Form

```blade
<form wire:submit="submitReview">
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium mb-2">
                Overall Rating
            </label>
            <x-pegboard::rating-input
                wire:model="reviewRating"
                size="lg"
            />
            @error('reviewRating')
                <p class="text-sm text-destructive mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">
                Would you recommend this?
            </label>
            <x-pegboard::rating-input
                wire:model="recommendRating"
                icon="hand-thumb-up"
                variant="success"
            />
        </div>

        <button type="submit">Submit Review</button>
    </div>
</form>
```

### Multi-Criteria Rating

```blade
<div class="space-y-4">
    <div>
        <label class="text-sm font-medium">Quality</label>
        <x-pegboard::rating-input wire:model="ratings.quality" />
    </div>

    <div>
        <label class="text-sm font-medium">Service</label>
        <x-pegboard::rating-input wire:model="ratings.service" />
    </div>

    <div>
        <label class="text-sm font-medium">Value</label>
        <x-pegboard::rating-input wire:model="ratings.value" />
    </div>

    <div class="pt-4 border-t">
        <label class="text-sm font-medium">Average Rating</label>
        <x-pegboard::rating
            :value="$averageRating"
            :show-value="true"
            size="lg"
        />
    </div>
</div>
```

### Display with Breakdown

```blade
<div class="space-y-4">
    <div class="flex items-center gap-4">
        <x-pegboard::rating :value="4.5" size="lg" />
        <div>
            <div class="text-2xl font-bold">4.5</div>
            <div class="text-sm text-muted-foreground">out of 5</div>
        </div>
    </div>

    <div class="space-y-2">
        @foreach([5, 4, 3, 2, 1] as $rating)
            <div class="flex items-center gap-2">
                <span class="text-sm w-8">{{ $rating }} star</span>
                <div class="flex-1 bg-muted rounded-full h-2">
                    <div
                        class="bg-warning h-2 rounded-full"
                        style="width: {{ $ratingPercentages[$rating] }}%"
                    ></div>
                </div>
                <span class="text-sm text-muted-foreground w-12 text-right">
                    {{ $ratingCounts[$rating] }}
                </span>
            </div>
        @endforeach
    </div>
</div>
```

## Customization

Pass custom classes to wrapper:

```blade
{{-- Custom width and spacing --}}
<x-pegboard::rating :value="4" class="w-full justify-center my-4" />

{{-- Custom alignment --}}
<x-pegboard::rating-input class="justify-end" />
```

## Accessibility

**Rating (Display):**
- Uses semantic markup with proper ARIA attributes
- Decorative icons don't interfere with screen readers
- Numeric value provides context when `show-value="true"`

**Rating Input:**
- Each star is a focusable `<button>` element
- Keyboard navigation support (Tab/Shift+Tab)
- Focus visible ring for keyboard users
- `disabled` attribute properly prevents interaction
- Reset button has descriptive purpose
- Value updates announced to screen readers via form input changes

**Keyboard Support:**
- **Tab** - Navigate between stars and reset button
- **Enter/Space** - Select rating star or activate reset
- **Escape** - Blur focused element

## Theme Integration

Rating components use Pegboard theme tokens:

```css
/* From pegboard.css @theme block */
--duration-fast: 150ms;
--ease-out: cubic-bezier(0, 0, 0.2, 1);
```

**Animations:**
- Hover scale: `hover:scale-110` (input only)
- Click scale: `active:scale-95` (input only)
- Color transitions: `transition-colors duration-fast`
- Transform transitions: `transition-transform duration-fast`

**Color tokens:**
- `text-warning` - Default star color (yellow/amber)
- `text-primary` - Brand color
- `text-destructive` - Danger/critical
- `text-success` - Success/positive
- `text-muted-foreground` - Empty/outline stars

## Best Practices

1. **Use appropriate component:**
   - `<x-pegboard::rating>` for display/read-only
   - `<x-pegboard::rating-input>` for user input

2. **Match icon to context:**
   - Stars for traditional ratings
   - Hearts for favorites/love
   - Thumbs up for recommendations
   - Custom icons for brand-specific ratings

3. **Provide validation feedback:**
   ```blade
   <x-pegboard::rating-input wire:model="rating" />
   @error('rating')
       <p class="text-sm text-destructive">{{ $message }}</p>
   @enderror
   ```

4. **Consider context for variants:**
   - Use `warning` (yellow) for neutral ratings
   - Use `success` (green) for positive feedback
   - Use `danger` (red) sparingly for critical ratings

5. **Show numeric values for clarity:**
   ```blade
   {{-- Good: Clear what the rating represents --}}
   <x-pegboard::rating :value="4.5" :show-value="true" />
   ```

6. **Disable when not editable:**
   ```blade
   <x-pegboard::rating-input
       wire:model="rating"
       :disabled="!$canEdit"
   />
   ```
