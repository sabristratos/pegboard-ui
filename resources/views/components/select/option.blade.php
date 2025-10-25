@php
    $optionValue = (string) $value;
    $optionIcon = $icon ?? null;
    $isDisabled = $disabled ?? false;
@endphp

<button
    type="button"
    @click="selectOption(@js($optionValue), $el)"
    x-data="{
        value: @js($optionValue),
        text: '',
        icon: @js($optionIcon),
        get iconSize() {
            return $el.closest('[data-icon-size]')?.dataset.iconSize || 'h-4 w-4';
        }
    }"
    x-init="
        text = $el.textContent.trim();
        registerOption({ value, text, icon, element: $el });
    "
    x-show="isOptionVisible(value, text)"
    :data-active="activeIndex === getOptionIndex(value)"
    :data-selected="isSelected(value)"
    @if($isDisabled) disabled @endif
    role="option"
    :aria-selected="isSelected(value)"
    :aria-disabled="@js($isDisabled)"
    class="group flex items-center w-full px-2 py-1.5 text-left text-sm rounded-md transition-colors duration-fast
           text-foreground
           hover:bg-popover-hover hover:text-popover-hover-foreground
           focus:outline-none focus:bg-popover-hover focus:text-popover-hover-foreground
           data-[active=true]:bg-popover-hover data-[active=true]:text-popover-hover-foreground
           data-[selected=true]:bg-popover-hover
           active:bg-popover-hover/90
           disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-transparent"
>
    @if($optionIcon)
        <div class="mr-2 text-muted-foreground shrink-0" data-option-icon>
            <x-pegboard::icon :name="$optionIcon" ::class="iconSize" />
        </div>
    @endif

    <span class="flex-1 truncate">
        {{ $slot }}
    </span>

    <div
        x-show="isSelected(@js($optionValue))"
        x-cloak
        class="ml-2 flex items-center justify-center text-primary shrink-0"
    >
        <x-pegboard::icon
            name="check"
            ::class="iconSize"
        />
    </div>
</button>
