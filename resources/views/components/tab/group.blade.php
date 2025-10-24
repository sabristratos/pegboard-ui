@php
    // Alpine.js options
    $alpineOptions = json_encode([
        'variant' => $variant,
        'size' => $size,
        'orientation' => $orientation,
    ]);
@endphp

<div
    x-data="pegboardTabs({{ $alpineOptions }})"
    x-modelable="activeTab"
    @keydown="handleKeydown($event)"
    role="tablist"
    :aria-orientation="@js($orientation)"
    {{ $attributes->merge(['data-tab-group' => $groupId]) }}
>
    {{ $slot }}
</div>
