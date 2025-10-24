@php
$baseClasses = implode(' ', [
    'flex items-center justify-between',
    'px-4 py-4',
    'border-b border-sidebar-border',
    'shrink-0', // Prevent header from shrinking
]);

$mergedClasses = $attributes->merge(['class' => $baseClasses])->get('class');
@endphp

<div {{ $attributes->merge(['class' => $mergedClasses]) }}>
    <div class="flex items-center gap-3 overflow-hidden">
        <div class="min-w-0 overflow-hidden" data-part="logo">
            {{ $slot }}
        </div>
    </div>

    <button
        type="button"
        @click="toggleMobile"
        class="md:hidden rounded p-1.5 text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition-colors duration-fast"
        aria-label="Close sidebar"
    >
        <x-pegboard::icon name="x-mark" class="h-6 w-6" />
    </button>
</div>
