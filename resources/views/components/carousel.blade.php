@php
    $carouselId = $attributes->get('id') ?? 'carousel-' . uniqid();
@endphp

<div
    x-data="carousel({
        autoPlay: {{ $autoPlay ? 'true' : 'false' }},
        interval: {{ $interval }},
        pauseOnHover: {{ $pauseOnHover ? 'true' : 'false' }},
        loop: {{ $loop ? 'true' : 'false' }},
    })"
    data-pegboard-carousel
    data-pegboard-carousel-id="{{ $carouselId }}"
    class="relative"
    {{ $attributes->except(['class', 'id']) }}
    @mouseenter="pauseOnHover && pause()"
    @mouseleave="pauseOnHover && resume()"
>
    <div
        x-ref="scrollContainer"
        @scroll.passive="onScroll"
        @keydown.left.prevent="prev()"
        @keydown.right.prevent="next()"
        tabindex="0"
        role="region"
        aria-roledescription="carousel"
        :aria-live="isAutoPlaying && !isPaused ? 'polite' : 'off'"
        class="flex snap-x snap-mandatory overflow-x-auto scrollbar-none touch-pan-x scroll-smooth motion-reduce:scroll-auto"
        :class="{ 'gap-4': {{ $peek ? 'true' : 'false' }} }"
        @if($peek)
            style="padding-inline: {{ $peekAmount }}; scroll-padding-inline: {{ $peekAmount }};"
        @endif
    >
        {{ $slot }}
    </div>

    @if($showControls)
        @if (isset($controls))
            {{ $controls }}
        @else
            <x-pegboard::carousel.controls />
        @endif
    @endif

    @if($showIndicators)
        @if (isset($indicators))
            {{ $indicators }}
        @else
            <x-pegboard::carousel.indicators />
        @endif
    @endif

    @if($showThumbnails)
        @if (isset($thumbnails))
            {{ $thumbnails }}
        @else
            <x-pegboard::carousel.thumbnails />
        @endif
    @endif
</div>
