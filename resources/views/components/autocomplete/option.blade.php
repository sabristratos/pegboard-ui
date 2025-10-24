@php
    $isDisabled = $disabled ?? false;
    $href = $href ?? null;
    $searchText = $searchText ?? null;
    $value = $value ?? null;
    $baseClasses = 'group flex items-center w-full px-2 py-1.5 text-left text-sm rounded-md transition-colors duration-fast text-foreground hover:bg-popover-hover hover:text-popover-hover-foreground focus:outline-none focus:bg-popover-hover focus:text-popover-hover-foreground data-[active=true]:bg-popover-hover data-[active=true]:text-popover-hover-foreground active:bg-popover-hover/90 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-transparent';
@endphp

@if($href)
    <a
        href="{{ $href }}"
        x-data="{ text: '', disabled: @js($isDisabled) }"
        x-init="
            @if($searchText)
                text = @js($searchText);
            @else
                text = $el.textContent.trim();
            @endif
            registerItem({ text, disabled, element: $el });
        "
        x-show="isItemVisible(text)"
        x-cloak
        :data-active="activeIndex >= 0 && activeIndex === getItemIndex($el)"
        :aria-selected="activeIndex >= 0 && activeIndex === getItemIndex($el)"
        :id="'autocomplete-option-' + getItemIndex($el)"
        role="option"
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="button"
        @click="selectItem($el)"
        @mousedown.prevent
        x-data="{ text: '', disabled: @js($isDisabled) }"
        x-init="
            @if($searchText)
                text = @js($searchText);
            @else
                text = $el.textContent.trim();
            @endif
            registerItem({ text, disabled, element: $el });
        "
        x-show="isItemVisible(text)"
        x-cloak
        :data-active="activeIndex >= 0 && activeIndex === getItemIndex($el)"
        :aria-selected="activeIndex >= 0 && activeIndex === getItemIndex($el)"
        :id="'autocomplete-option-' + getItemIndex($el)"
        role="option"
        @if($isDisabled) disabled @endif
        {{ $attributes->merge(['class' => $baseClasses]) }}
    >
        {{ $slot }}
    </button>
@endif
