# Carousel Component

A modern, accessible carousel component with auto-play, navigation controls, and touch/swipe gesture support. Built with CSS scroll snapping for smooth, performant scrolling and minimal JavaScript enhancement.

## Features

- **CSS Scroll Snapping** - Native browser behavior using scroll-snap-type utilities
- **Hybrid Auto-play Mode** - Auto-play with manual controls and pause on hover
- **Touch/Swipe Gestures** - Pointer events for smooth dragging on mobile and desktop
- **Peek Mode** - Shows partial next/previous slides for visual affordance
- **Multiple Navigation Methods** - Previous/Next buttons, dot indicators, thumbnail navigation, keyboard arrows
- **Fully Accessible** - ARIA attributes, keyboard navigation, screen reader support
- **Respects User Preferences** - Auto-disables auto-play when `prefers-reduced-motion` is set
- **Batteries-Included-But-Swappable** - Pre-styled sub-components with slot-based customization
- **Zero Page Scroll Hijacking** - Container-scoped scrolling only

## Basic Usage

### Simple Carousel

```blade
{{-- Basic carousel with auto-play and peek mode --}}
<x-pegboard::carousel>
    <x-pegboard::carousel-item>
        <div class="bg-blue-500 text-white p-12 rounded-lg text-center">
            Slide 1
        </div>
    </x-pegboard::carousel-item>
    <x-pegboard::carousel-item>
        <div class="bg-purple-500 text-white p-12 rounded-lg text-center">
            Slide 2
        </div>
    </x-pegboard::carousel-item>
    <x-pegboard::carousel-item>
        <div class="bg-pink-500 text-white p-12 rounded-lg text-center">
            Slide 3
        </div>
    </x-pegboard::carousel-item>
</x-pegboard::carousel>
```

**Default behavior:**
- Auto-play enabled (5-second interval)
- Peek mode showing partial next/prev slides
- Pause on hover
- Infinite looping
- Previous/Next buttons and dot indicators

### Manual Navigation Only

```blade
{{-- Disable auto-play for user-controlled navigation --}}
<x-pegboard::carousel :auto-play="false">
    <x-pegboard::carousel-item>Slide 1</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Slide 2</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Slide 3</x-pegboard::carousel-item>
</x-pegboard::carousel>
```

## Props

### Carousel (Main Component)

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `autoPlay` | bool | `true` | Enable auto-play carousel rotation |
| `interval` | int | `5000` | Auto-play interval in milliseconds |
| `pauseOnHover` | bool | `true` | Pause auto-play when user hovers |
| `loop` | bool | `true` | Enable infinite looping |
| `peek` | bool | `true` | Show partial next/prev slides |
| `peekAmount` | string | `'5rem'` | Amount of next/prev slide to show |
| `showControls` | bool | `true` | Show previous/next navigation buttons |
| `showIndicators` | bool | `true` | Show dot pagination indicators |
| `showThumbnails` | bool | `false` | Show thumbnail navigation |
| `align` | string | `'center'` | Slide alignment: `start`, `center`, `end` |

### CarouselItem

The individual slide wrapper. No props - just wraps your content with snap-center behavior.

```blade
<x-pegboard::carousel-item>
    {{-- Your slide content --}}
</x-pegboard::carousel-item>
```

## Carousel Modes

### Auto-play Mode (Default)

Automatically cycles through slides with configurable interval:

```blade
{{-- 3-second auto-play interval --}}
<x-pegboard::carousel interval="3000">
    <x-pegboard::carousel-item>Slide 1</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Slide 2</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Slide 3</x-pegboard::carousel-item>
</x-pegboard::carousel>
```

**Behavior:**
- Automatically advances every `interval` milliseconds
- Pauses on hover (if `pauseOnHover` is true)
- Resets timer when user manually navigates
- Respects `prefers-reduced-motion` (auto-disables if user prefers reduced motion)

### Manual Navigation

User controls all navigation via buttons, dots, or swipe:

```blade
{{-- User-controlled only --}}
<x-pegboard::carousel :auto-play="false">
    <x-pegboard::carousel-item>Slide 1</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Slide 2</x-pegboard::carousel-item>
</x-pegboard::carousel>
```

**Navigation methods available:**
- Previous/Next buttons
- Dot indicators (click to jump to slide)
- Thumbnail navigation (when enabled)
- Touch/swipe gestures
- Keyboard arrow keys

### Peek Mode

Shows partial next/previous slides to indicate more content:

```blade
{{-- Default peek mode (5rem on each side) --}}
<x-pegboard::carousel>
    ...
</x-pegboard::carousel>

{{-- Custom peek amount --}}
<x-pegboard::carousel peek-amount="8rem">
    ...
</x-pegboard::carousel>

{{-- Disable peek mode (full width slides) --}}
<x-pegboard::carousel :peek="false">
    ...
</x-pegboard::carousel>
```

**When to use peek mode:**
- ✅ Image galleries, product carousels
- ✅ Testimonials, feature highlights
- ✅ When you want visual indication of more content
- ❌ Hero sections (use full width)
- ❌ Single large content items

## Navigation Options

### Previous/Next Buttons

Pre-styled navigation buttons with chevron icons:

```blade
{{-- Default buttons --}}
<x-pegboard::carousel>
    ...
</x-pegboard::carousel>

{{-- Hide buttons --}}
<x-pegboard::carousel :show-controls="false">
    ...
</x-pegboard::carousel>

{{-- Custom buttons via slot --}}
<x-pegboard::carousel>
    <x-pegboard::carousel-item>Slide 1</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Slide 2</x-pegboard::carousel-item>

    <x-slot:controls>
        <x-pegboard::carousel.controls variant="ghost" />
    </x-slot:controls>
</x-pegboard::carousel>
```

**Button features:**
- Positioned absolutely over carousel edges
- Disabled states when not looping and at first/last slide
- Keyboard accessible
- Hover and focus states
- Uses theme tokens for consistent styling

### Dot Indicators

Pagination dots showing current slide:

```blade
{{-- Default dot indicators --}}
<x-pegboard::carousel>
    ...
</x-pegboard::carousel>

{{-- Hide indicators --}}
<x-pegboard::carousel :show-indicators="false">
    ...
</x-pegboard::carousel>

{{-- Custom indicators via slot --}}
<x-pegboard::carousel>
    <x-pegboard::carousel-item>Slide 1</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Slide 2</x-pegboard::carousel-item>

    <x-slot:indicators>
        <div class="flex gap-2 justify-center mt-4">
            {{-- Custom indicator design --}}
        </div>
    </x-slot:indicators>
</x-pegboard::carousel>
```

**Indicator features:**
- Click to navigate to specific slide
- Active state highlighting with primary color
- ARIA current attribute for accessibility
- Smooth size/color transitions

### Thumbnail Navigation

Optional thumbnail previews for navigation:

```blade
{{-- Enable thumbnail navigation --}}
<x-pegboard::carousel :show-thumbnails="true">
    <x-pegboard::carousel-item>Product 1</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Product 2</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Product 3</x-pegboard::carousel-item>
</x-pegboard::carousel>

{{-- Custom thumbnails via slot --}}
<x-pegboard::carousel :show-thumbnails="true">
    @foreach($products as $product)
        <x-pegboard::carousel-item>
            <x-product-card :product="$product" />
        </x-pegboard::carousel-item>
    @endforeach

    <x-slot:thumbnails>
        <div class="flex gap-2 mt-4 overflow-x-auto">
            @foreach($products as $index => $product)
                <button
                    x-on:click="goTo({{ $index }})"
                    class="w-20 h-20 rounded-lg overflow-hidden"
                >
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" />
                </button>
            @endforeach
        </div>
    </x-slot:thumbnails>
</x-pegboard::carousel>
```

**Thumbnail features:**
- Horizontal scrollable layout
- Active state with ring highlight
- Click to navigate
- Automatically numbered placeholders if no custom thumbnails provided

## Real-World Examples

### Hero Carousel

```blade
{{-- Full-width hero with faster interval --}}
<x-pegboard::carousel :peek="false" interval="4000">
    <x-pegboard::carousel-item>
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg aspect-video flex items-center justify-center text-white">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Welcome to Our Platform</h1>
                <p class="text-xl">Build amazing things with our tools</p>
            </div>
        </div>
    </x-pegboard::carousel-item>
    <x-pegboard::carousel-item>
        <div class="bg-gradient-to-r from-cyan-500 to-blue-500 rounded-lg aspect-video flex items-center justify-center text-white">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Trusted by Thousands</h1>
                <p class="text-xl">Join our growing community</p>
            </div>
        </div>
    </x-pegboard::carousel-item>
</x-pegboard::carousel>
```

### Product Showcase

```blade
{{-- Product carousel with thumbnails --}}
<x-pegboard::carousel :auto-play="false" :show-thumbnails="true">
    @foreach($products as $product)
        <x-pegboard::carousel-item>
            <div class="bg-card border border-border rounded-xl p-8 text-center">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-48 w-auto mx-auto mb-4" />
                <h3 class="text-xl font-bold mb-2">{{ $product->name }}</h3>
                <p class="text-muted-foreground mb-4">{{ $product->description }}</p>
                <p class="text-2xl font-bold text-primary">${{ $product->price }}</p>
            </div>
        </x-pegboard::carousel-item>
    @endforeach
</x-pegboard::carousel>
```

### Testimonials

```blade
{{-- Auto-rotating testimonials with no peek --}}
<x-pegboard::carousel interval="6000" :peek="false">
    @foreach($testimonials as $testimonial)
        <x-pegboard::carousel-item>
            <div class="bg-muted/50 rounded-xl p-8 text-center max-w-2xl mx-auto">
                <x-pegboard::icon name="chat-bubble-oval-left" class="h-12 w-12 mx-auto mb-4 text-primary" />
                <blockquote class="text-lg mb-6">{{ $testimonial->quote }}</blockquote>
                <div class="flex items-center justify-center gap-3">
                    <x-pegboard::avatar :name="$testimonial->name" size="md" />
                    <div class="text-left">
                        <p class="font-semibold">{{ $testimonial->name }}</p>
                        <p class="text-sm text-muted-foreground">{{ $testimonial->role }}</p>
                    </div>
                </div>
            </div>
        </x-pegboard::carousel-item>
    @endforeach
</x-pegboard::carousel>
```

### Image Gallery

```blade
{{-- Manual navigation with peek mode --}}
<x-pegboard::carousel :auto-play="false" peek-amount="3rem">
    @foreach($images as $image)
        <x-pegboard::carousel-item>
            <img
                src="{{ $image->url }}"
                alt="{{ $image->caption }}"
                class="rounded-lg w-full h-96 object-cover"
            />
        </x-pegboard::carousel-item>
    @endforeach
</x-pegboard::carousel>
```

### Feature Highlights

```blade
{{-- Slower auto-play for reading content --}}
<x-pegboard::carousel interval="8000">
    <x-pegboard::carousel-item>
        <div class="bg-card border border-border rounded-lg p-12 text-center">
            <x-pegboard::icon name="rocket-launch" class="h-16 w-16 mx-auto mb-4 text-primary" />
            <h3 class="text-2xl font-bold mb-4">Fast Performance</h3>
            <p class="text-muted-foreground">Lightning-fast load times and smooth interactions</p>
        </div>
    </x-pegboard::carousel-item>
    <x-pegboard::carousel-item>
        <div class="bg-card border border-border rounded-lg p-12 text-center">
            <x-pegboard::icon name="shield-check" class="h-16 w-16 mx-auto mb-4 text-primary" />
            <h3 class="text-2xl font-bold mb-4">Secure by Default</h3>
            <p class="text-muted-foreground">Enterprise-grade security built into every feature</p>
        </div>
    </x-pegboard::carousel-item>
    <x-pegboard::carousel-item>
        <div class="bg-card border border-border rounded-lg p-12 text-center">
            <x-pegboard::icon name="users" class="h-16 w-16 mx-auto mb-4 text-primary" />
            <h3 class="text-2xl font-bold mb-4">Team Collaboration</h3>
            <p class="text-muted-foreground">Work together seamlessly with real-time updates</p>
        </div>
    </x-pegboard::carousel-item>
</x-pegboard::carousel>
```

### Promotional Banners

```blade
{{-- Fast auto-play with no loop (plays through once) --}}
<x-pegboard::carousel interval="2000" :loop="false" :peek="false">
    <x-pegboard::carousel-item>
        <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white p-6 rounded-lg text-center">
            <p class="text-2xl font-bold">🎉 50% OFF - Limited Time!</p>
        </div>
    </x-pegboard::carousel-item>
    <x-pegboard::carousel-item>
        <div class="bg-gradient-to-r from-green-500 to-teal-500 text-white p-6 rounded-lg text-center">
            <p class="text-2xl font-bold">✨ Free Shipping on All Orders</p>
        </div>
    </x-pegboard::carousel-item>
    <x-pegboard::carousel-item>
        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white p-6 rounded-lg text-center">
            <p class="text-2xl font-bold">🚀 New Features Released!</p>
        </div>
    </x-pegboard::carousel-item>
</x-pegboard::carousel>
```

## Customization

### Custom Slide Spacing

```blade
{{-- Custom gap between slides in peek mode --}}
<x-pegboard::carousel class="[&_[x-ref='scrollContainer']]:gap-8">
    ...
</x-pegboard::carousel>
```

### Custom Control Styling

```blade
<x-pegboard::carousel>
    <x-pegboard::carousel-item>Slide 1</x-pegboard::carousel-item>
    <x-pegboard::carousel-item>Slide 2</x-pegboard::carousel-item>

    {{-- Custom button positioning and styling --}}
    <x-slot:controls>
        <div class="flex gap-4 justify-center mt-4">
            <button x-on:click="prev()" class="px-6 py-3 bg-primary text-primary-foreground rounded-full">
                Previous
            </button>
            <button x-on:click="next()" class="px-6 py-3 bg-primary text-primary-foreground rounded-full">
                Next
            </button>
        </div>
    </x-slot:controls>
</x-pegboard::carousel>
```

### Dynamic Content with Livewire

```blade
{{-- Carousel with dynamic slides from Livewire --}}
<x-pegboard::carousel :auto-play="false">
    @foreach($this->slides as $slide)
        <x-pegboard::carousel-item wire:key="slide-{{ $slide->id }}">
            <div class="bg-card border border-border rounded-lg p-8">
                <h3 class="text-xl font-bold mb-4">{{ $slide->title }}</h3>
                <p class="text-muted-foreground">{{ $slide->content }}</p>

                <x-pegboard::button
                    wire:click="deleteSlide({{ $slide->id }})"
                    variant="destructive"
                    size="sm"
                    class="mt-4"
                >
                    Delete
                </x-pegboard::button>
            </div>
        </x-pegboard::carousel-item>
    @endforeach
</x-pegboard::carousel>
```

## Accessibility

The carousel component is fully accessible and follows WCAG 2.1 guidelines:

### Keyboard Navigation

| Key | Action |
|-----|--------|
| `←` Left Arrow | Navigate to previous slide |
| `→` Right Arrow | Navigate to next slide |
| `Tab` | Navigate to control buttons/indicators |
| `Enter` / `Space` | Activate focused button/indicator |

**Note:** Arrow key navigation requires the carousel container to have focus. Users can tab to the container and then use arrow keys.

### ARIA Attributes

The carousel uses proper ARIA attributes for screen reader support:

```html
<div role="region" aria-roledescription="carousel" aria-live="polite">
    <!-- Carousel content -->
</div>

<button aria-label="Previous slide">...</button>
<button aria-label="Next slide">...</button>
<button aria-label="Go to slide 2" aria-current="false">...</button>
```

**ARIA features:**
- `role="region"` with `aria-roledescription="carousel"` identifies the carousel
- `aria-live="polite"` announces changes when auto-playing
- Descriptive `aria-label` on all navigation controls
- `aria-current` indicates the active slide in dot indicators
- Disabled buttons have `disabled` attribute and visual indicators

### Reduced Motion Support

The carousel automatically respects user motion preferences:

```css
/* Auto-disabled when user prefers reduced motion */
@media (prefers-reduced-motion: reduce) {
    /* Auto-play is disabled */
    /* Scroll behavior changes from smooth to auto */
}
```

**Behavior with reduced motion:**
- Auto-play is automatically disabled
- Smooth scrolling becomes instant
- All transitions honor the user's preference
- Manual navigation still works normally

### Screen Reader Announcements

- Current slide number is announced to screen readers
- Navigation button states (enabled/disabled) are announced
- Auto-play status changes are announced via `aria-live`
- Slide content is properly associated with the carousel region

### Focus Management

- Tab order follows visual order: carousel → controls → indicators → thumbnails
- Focus indicators have sufficient contrast (3:1 minimum)
- `focus-visible` used to show focus only for keyboard users
- Focus is not trapped (users can tab out of carousel)

### Best Practices for Accessibility

**1. Provide meaningful slide content:**

```blade
{{-- ✅ Good - descriptive content --}}
<x-pegboard::carousel-item>
    <article>
        <h3>Product Feature: Real-time Sync</h3>
        <p>Keep your team aligned with instant updates...</p>
    </article>
</x-pegboard::carousel-item>

{{-- ❌ Bad - image without context --}}
<x-pegboard::carousel-item>
    <img src="feature.jpg" />
</x-pegboard::carousel-item>
```

**2. Don't rely on color alone:**

```blade
{{-- ✅ Good - multiple visual indicators --}}
<x-pegboard::carousel-item>
    <div class="border-l-4 border-success bg-success/10">
        <span class="sr-only">Success:</span>
        <p>Your order has been confirmed!</p>
    </div>
</x-pegboard::carousel-item>
```

**3. Limit auto-play speed:**

```blade
{{-- ✅ Good - Reasonable intervals for reading --}}
<x-pegboard::carousel interval="6000">  <!-- 6 seconds -->

{{-- ❌ Bad - Too fast to read --}}
<x-pegboard::carousel interval="1000">  <!-- 1 second -->
```

**4. Provide manual controls:**

```blade
{{-- ✅ Good - Always show controls --}}
<x-pegboard::carousel>

{{-- ❌ Bad - No way to stop/navigate --}}
<x-pegboard::carousel :show-controls="false" :show-indicators="false">
```

## Technical Implementation

### CSS Scroll Snapping

The carousel uses native browser scroll snapping for smooth, performant scrolling:

```css
/* Scroll container */
.snap-x {
    scroll-snap-type: x mandatory;
}

/* Individual slides */
.snap-center {
    scroll-snap-align: center;
}
```

**Benefits:**
- Native browser performance (hardware accelerated)
- Smooth momentum scrolling on touch devices
- No JavaScript needed for snap behavior
- Respects user scroll preferences

### Container-Scoped Scrolling

The carousel uses `container.scrollTo()` instead of `element.scrollIntoView()` to prevent page scroll hijacking:

```typescript
// Scrolls only the carousel container, not the page
container.scrollTo({
    left: scrollPosition,
    behavior: 'smooth'
});
```

**Why this matters:**
- Page scroll position remains unchanged
- Only the carousel scrolls horizontally
- No unexpected page jumps
- Better user experience

### Touch Gesture Support

Pointer events provide universal gesture support:

```typescript
// Supports mouse drag, touch swipe, and pen input
container.addEventListener('pointerdown', (e) => {
    // Start drag
});
container.addEventListener('pointermove', (e) => {
    // Handle drag
});
container.addEventListener('pointerup', (e) => {
    // End drag
});
```

**Features:**
- Works on all devices (mouse, touch, pen)
- Smooth momentum scrolling
- Visual cursor feedback (grab/grabbing)
- Prevents text selection during drag

### Auto-play Implementation

Simple interval-based auto-play with pause/resume:

```typescript
setInterval(() => {
    if (!isPaused) {
        next();
    }
}, interval);
```

**Smart features:**
- Pauses on hover
- Resets timer on manual navigation
- Automatically disabled when `prefers-reduced-motion`
- Clean interval cleanup on component destroy

## Best Practices

### 1. Choose Appropriate Intervals

```blade
{{-- ✅ Good - Readable content --}}
<x-pegboard::carousel interval="6000">  <!-- 6 seconds for testimonials -->
<x-pegboard::carousel interval="8000">  <!-- 8 seconds for feature highlights -->

{{-- ❌ Bad - Too fast or too slow --}}
<x-pegboard::carousel interval="1000">  <!-- Unreadable -->
<x-pegboard::carousel interval="30000"> <!-- User will forget it's a carousel -->
```

### 2. Use Peek Mode Strategically

```blade
{{-- ✅ Good - Peek for multiple items --}}
<x-pegboard::carousel>  <!-- Products, images, cards -->

{{-- ✅ Good - No peek for full-screen content --}}
<x-pegboard::carousel :peek="false">  <!-- Hero sections, banners -->
```

### 3. Limit Slide Count

```blade
{{-- ✅ Good - 3-7 slides for auto-play --}}
<x-pegboard::carousel>
    {{-- 5 feature highlights --}}
</x-pegboard::carousel>

{{-- ⚠️ Consider - Many slides might need thumbnails --}}
<x-pegboard::carousel :show-thumbnails="true">
    {{-- 20 product images --}}
</x-pegboard::carousel>
```

### 4. Match Mode to Content Type

| Content Type | Auto-play | Peek | Thumbnails |
|--------------|-----------|------|------------|
| Hero Section | ✅ Yes (slow) | ❌ No | ❌ No |
| Testimonials | ✅ Yes | ❌ No | ❌ No |
| Products | ❌ No | ✅ Yes | ✅ Optional |
| Images | ❌ No | ✅ Yes | ✅ Yes |
| Features | ✅ Yes (slow) | ✅ Yes | ❌ No |
| Banners | ✅ Yes (fast) | ❌ No | ❌ No |

### 5. Provide Context

```blade
{{-- ✅ Good - Clear heading and purpose --}}
<div>
    <h2 class="text-2xl font-bold mb-4">Customer Testimonials</h2>
    <x-pegboard::carousel interval="6000">
        ...
    </x-pegboard::carousel>
</div>

{{-- ❌ Bad - No context --}}
<x-pegboard::carousel>
    ...
</x-pegboard::carousel>
```

### 6. Optimize Images

```blade
{{-- ✅ Good - Lazy loading, proper sizing --}}
<x-pegboard::carousel-item>
    <img
        src="{{ $image->url }}"
        alt="{{ $image->caption }}"
        loading="lazy"
        class="w-full h-96 object-cover"
    />
</x-pegboard::carousel-item>

{{-- ❌ Bad - Large unoptimized images --}}
<x-pegboard::carousel-item>
    <img src="huge-image-10mb.jpg" />
</x-pegboard::carousel-item>
```

### 7. Handle Empty States

```blade
{{-- ✅ Good - Graceful empty state --}}
@if($items->count() > 0)
    <x-pegboard::carousel>
        @foreach($items as $item)
            <x-pegboard::carousel-item>...</x-pegboard::carousel-item>
        @endforeach
    </x-pegboard::carousel>
@else
    <div class="text-center text-muted-foreground">
        No items to display
    </div>
@endif

{{-- ❌ Bad - Empty carousel --}}
<x-pegboard::carousel>
    {{-- No items --}}
</x-pegboard::carousel>
```

### 8. Disable Loop When Appropriate

```blade
{{-- ✅ Good - No loop for linear content --}}
<x-pegboard::carousel :loop="false">
    {{-- Onboarding steps 1 → 2 → 3 → END --}}
</x-pegboard::carousel>

{{-- ✅ Good - Loop for repeating content --}}
<x-pegboard::carousel :loop="true">
    {{-- Product showcase that repeats --}}
</x-pegboard::carousel>
```

## Theme Tokens

The carousel uses theme tokens from Pegboard's `@theme` block for consistent styling:

```css
/* Duration */
--duration-fast: 150ms;
--duration-normal: 200ms;

/* Colors */
--color-popover: ...;
--color-popover-foreground: ...;
--color-primary: ...;
--color-muted: ...;
--color-border: ...;

/* Carousel-specific */
--carousel-peek-amount: 5rem;
--carousel-gap: 1rem;
--carousel-control-size: 2.5rem;
--carousel-indicator-size: 0.5rem;
```

All colors automatically adapt to light/dark mode.

## Browser Support

The carousel works on all modern browsers:

- **Chrome/Edge**: Full support including native scroll snapping
- **Firefox**: Full support including native scroll snapping
- **Safari**: Full support including native scroll snapping
- **Mobile browsers**: Full support with touch gestures

**Minimum versions:**
- Chrome 69+
- Firefox 68+
- Safari 11+
- Edge 79+

**Graceful degradation:**
- Older browsers without scroll snapping still get horizontal scrolling
- Auto-play and manual navigation work in all browsers
- Touch gestures degrade to native scroll on unsupported browsers

## Performance

The carousel is optimized for performance:

**Native browser features:**
- CSS scroll snapping (hardware accelerated)
- Pointer events (efficient event handling)
- Container queries (no resize listeners)

**Minimal JavaScript:**
- Only handles auto-play timer and navigation
- No animation libraries or heavy dependencies
- Cleanup on component destroy prevents memory leaks

**Optimized rendering:**
- No forced reflows or layout thrashing
- Passive scroll event listeners
- Debounced scroll position updates

**Best practices:**
- Use lazy loading for images: `loading="lazy"`
- Optimize image sizes before upload
- Limit slide count for auto-play carousels (3-7 slides)
- Use `will-change: transform` sparingly (only on active slide)

## Related Components

- **[Accordion](./accordion.md)** - For vertically collapsible content
- **[Tabs](./tabs.md)** - For switching between static content panels
- **[Modal](./modal.md)** - For focused full-screen content
- **[Card](./card.md)** - For wrapping carousel slide content

## Support

For issues, questions, or feature requests, please open an issue in the Pegboard UI repository.
