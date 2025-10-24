@props([
    'placeholder' => 'Search...',
    'shortcut' => null,
])

@php
$baseClasses = implode(' ', [
    'px-3 py-2',
    'border-b border-sidebar-border',
    'shrink-0',
]);

$mergedClasses = $attributes->merge(['class' => $baseClasses])->get('class');

// Convert shortcut array to JSON for Alpine
$shortcutJson = $shortcut ? json_encode($shortcut) : 'null';
@endphp

<div
    x-data="pegboardSidebarSearch({ shortcut: {{ $shortcutJson }} })"
    {{ $attributes->merge(['class' => $mergedClasses]) }}
>
    <style>
        [type="search"]::-webkit-search-cancel-button,
        [type="search"]::-webkit-search-decoration {
            -webkit-appearance: none;
            appearance: none;
        }
        [type="search"]::-ms-clear {
            display: none;
        }
    </style>

    <x-pegboard::input
        type="search"
        size="sm"
        icon="magnifying-glass"
        :placeholder="$placeholder"
        x-model.debounce.150ms="searchQuery"
        data-sidebar-search-input
        autocomplete="off"
        aria-label="Search sidebar"
    >
        <x-slot:actions>
            <button
                type="button"
                @click="clearSearch"
                x-show="searchQuery"
                x-cloak
                class="flex items-center text-muted-foreground hover:text-foreground transition-colors duration-fast"
                aria-label="Clear search"
            >
                <x-pegboard::icon name="x-mark" class="h-3.5 w-3.5"/>
            </button>

            <x-pegboard::kbd size="xs" x-show="!searchQuery" x-text="keyboardShortcut" />
        </x-slot:actions>
    </x-pegboard::input>

    <div
        x-show="showNoResults"
        x-cloak
        class="px-4 py-8 text-center"
    >
        <div class="text-muted-foreground">
            <x-pegboard::icon name="magnifying-glass" class="h-8 w-8 mx-auto mb-2 opacity-50" />
            <p class="text-sm font-medium">No results found</p>
            <p class="text-xs mt-1">Try a different search term</p>
        </div>
    </div>
</div>
