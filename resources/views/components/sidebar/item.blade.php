@props([
    'href' => null,
    'icon' => null,
    'badge' => null,
    'active' => null,
    'expandable' => false,
])

@php
$hasNested = isset($nested);

// Determine if this item is active
// Priority: explicit active prop > URL matching
if ($active !== null) {
    $isActive = (bool) $active;
} elseif ($href) {
    $isActive = request()->is(ltrim($href, '/')) || request()->fullUrlIs($href);
} else {
    $isActive = false;
}

$baseClasses = implode(' ', [
    'group flex items-center gap-3 rounded-lg px-3 py-2',
    'text-sm font-medium',
    'transition-colors duration-fast',

    // Active state
    $isActive
        ? 'bg-sidebar-primary text-sidebar-primary-foreground'
        : 'text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground',

    // Focus states for accessibility
    'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-sidebar',

    // Cursor
    ($href || $hasNested) ? 'cursor-pointer' : '',
]);

$mergedClasses = $attributes->merge(['class' => $baseClasses])->get('class');
@endphp

@if ($hasNested)
    <details
        data-sidebar-item
        data-active="{{ $isActive ? 'true' : 'false' }}"
        class="group/details [&::details-content]:overflow-hidden [&::details-content]:grid [&::details-content]:grid-rows-[0fr] [&::details-content]:opacity-0 [&::details-content]:transition-[grid-template-rows,opacity,content-visibility] [&::details-content]:duration-normal [&::details-content]:ease-in-out [&::details-content]:transition-behavior-[allow-discrete] open:[&::details-content]:grid-rows-[1fr] open:[&::details-content]:opacity-100"
    >
        <summary
            {{ $attributes->merge(['class' => $mergedClasses]) }}
            class="list-none [&::-webkit-details-marker]:hidden"
        >
            @if ($icon)
                <span class="shrink-0" data-part="icon">
                    <x-pegboard::icon :name="$icon" class="h-5 w-5" />
                </span>
            @endif

            <span class="truncate" data-part="text">
                {{ $slot }}
            </span>

            @if ($badge)
                <span class="ml-auto shrink-0" data-part="badge">
                    <span class="inline-flex items-center rounded-full bg-sidebar-accent px-2 py-0.5 text-xs font-medium text-sidebar-accent-foreground">
                        {{ $badge }}
                    </span>
                </span>
            @endif

            <svg
                class="ml-auto h-4 w-4 shrink-0 transition-transform duration-normal ease-in-out group-open/details:rotate-90"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </summary>

        <div class="mt-1 space-y-1 border-l border-border ml-5 pl-4 min-h-0">
            {{ $nested }}
        </div>
    </details>
@else
    @php
        $tag = $href ? 'a' : 'div';
        $attributes = $href ? $attributes->merge(['href' => $href]) : $attributes;
    @endphp

    <{{ $tag }}
        data-sidebar-item
        data-active="{{ $isActive ? 'true' : 'false' }}"
        {{ $attributes->merge(['class' => $mergedClasses]) }}
    >
        @if ($icon)
            <span class="shrink-0" data-part="icon">
                <x-pegboard::icon :name="$icon" class="h-5 w-5" />
            </span>
        @endif

        <span class="truncate" data-part="text">
            {{ $slot }}
        </span>

        @if ($badge)
            <span class="ml-auto shrink-0" data-part="badge">
                <span class="inline-flex items-center rounded-full bg-sidebar-accent px-2 py-0.5 text-xs font-medium text-sidebar-accent-foreground">
                    {{ $badge }}
                </span>
            </span>
        @endif
    </{{ $tag }}>
@endif
