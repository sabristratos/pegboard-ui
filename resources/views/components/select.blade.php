@php
    use Stratos\Pegboard\Support\PopoverPositioning;

    $selectId = $attributes->get('id', 'select-' . uniqid());
    $popoverConfig = PopoverPositioning::getConfiguration($selectId, 'bottom-start', 8, matchWidth: true);

    $baseClasses = 'relative shadow-xs inline-flex items-center w-full rounded-md border transition-all duration-fast focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 cursor-pointer';

    $variantClasses = match($variant) {
        'error' => 'border-destructive bg-destructive/5 focus-within:ring-destructive',
        'success' => 'border-success bg-success/5 focus-within:ring-success',
        default => 'border-border bg-input focus-within:ring-ring',
    };

    $sizeClasses = match($size) {
        'xs' => 'px-2 py-1 text-xs min-h-7',
        'sm' => 'px-2 py-1 text-sm min-h-8',
        'lg' => 'px-4 py-2.5 text-lg min-h-11',
        default => 'px-3 py-1.5 text-base min-h-[38px]',
    };

    $iconSize = match($size) {
        'xs' => 'h-3 w-3',
        'sm' => 'h-3.5 w-3.5',
        'lg' => 'h-5 w-5',
        default => 'h-4 w-4',
    };

    $isPillbox = $displayVariant === 'pillbox' && $multiple;
@endphp

<div
    x-data="pegboardSelect({
        multiple: {{ $multiple ? 'true' : 'false' }},
        searchable: {{ $searchable ? 'true' : 'false' }},
        isPillbox: {{ $isPillbox ? 'true' : 'false' }},
        value: @js($value),
        name: @js($name)
    })"
    @if($multiple)
        x-modelable="selectedValues"
    @else
        x-modelable="selectedValue"
    @endif
    data-pegboard-group-item
    data-icon-size="{{ $iconSize }}"
    {{ $attributes->whereDoesntStartWith('wire:') }}
>
    @if($name)
        @if(!$multiple)
            <input
                type="hidden"
                name="{{ $name }}"
                :value="selectedValue"
                x-ref="hiddenInput"
                {{ $attributes->whereStartsWith('wire:') }}
            />
        @else
            <template x-for="(val, index) in selectedValues" :key="index">
                <input type="hidden" :name="'{{ $name }}' + '[]'" :value="val" />
            </template>
        @endif
    @endif

    <button
        type="button"
        @click="toggle"
        x-ref="trigger"
        :aria-expanded="open"
        role="combobox"
        aria-haspopup="listbox"
        data-pegboard-control
        style="anchor-name: {{ $popoverConfig['anchor'] }};"
        {{ $attributes->only('class')->class([
            $baseClasses,
            $variantClasses,
            $sizeClasses,
            'opacity-disabled cursor-not-allowed' => $disabled,
        ]) }}
        :class="{ 'ring-2 ring-ring': open }"
        @if($disabled) disabled @endif
    >
                <template x-if="!isPillbox">
                    <div class="flex-1 flex items-center gap-2 text-left truncate">
                        <template x-if="!multiple">
                            <div class="flex items-center gap-2 truncate">
                                <div
                                    x-show="selectedValue && getOptionIcon(selectedValue)"
                                    x-cloak
                                    class="shrink-0 flex items-center text-muted-foreground"
                                    x-html="getSelectedIconHtml()"
                                ></div>
                                <span
                                    x-text="selectedText || '{{ $placeholder }}'"
                                    :class="selectedText ? 'text-foreground' : 'text-muted-foreground'"
                                    class="text-sm truncate"
                                ></span>
                            </div>
                        </template>

                        <template x-if="multiple">
                            <span
                                x-text="selectedValues.length > 0 ? selectedValues.length + ' selected' : '{{ $placeholder }}'"
                                :class="selectedValues.length > 0 ? 'text-foreground' : 'text-muted-foreground'"
                                class="text-sm truncate"
                            ></span>
                        </template>
                    </div>
                </template>

                <template x-if="isPillbox">
                    <div class="flex-1 flex flex-wrap items-center gap-1.5">
                        <template x-if="selectedValues.length === 0">
                            <span class="text-sm text-muted-foreground">{{ $placeholder }}</span>
                        </template>

                        <template x-for="(value, index) in selectedValues" :key="value">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-sm bg-muted rounded-md">
                                <span x-text="getOptionText(value)" class="font-medium"></span>
                                <button
                                    type="button"
                                    @click.stop="removeOption(value)"
                                    class="flex items-center text-muted-foreground hover:text-foreground transition-colors"
                                    aria-label="Remove"
                                >
                                    <x-pegboard::icon name="x-mark" variant="micro" class="h-3 w-3" />
                                </button>
                            </span>
                        </template>
                    </div>
                </template>

                <span class="inline-flex ml-2 shrink-0 transition-transform duration-fast origin-center" x-bind:class="open && 'rotate-180'" x-cloak>
                    <x-pegboard::icon
                        name="chevron-down"
                        class="{{ $iconSize }} text-muted-foreground"
                    />
                </span>
            </button>

    <div
        x-ref="popover"
        id="popover-{{ $selectId }}"
        popover="manual"
        @click.outside="close"
        class="min-w-48 rounded-lg shadow-lg border border-border bg-popover p-1.5 {{ $popoverConfig['transition'] }} {{ $popoverConfig['origin'] }} z-50"
        style="{{ $popoverConfig['styles'] }}"
        role="listbox"
        :aria-multiselectable="multiple"
    >
            @if($searchable)
                <div class="relative mb-2">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">
                        <x-pegboard::icon name="magnifying-glass" variant="micro" class="h-4 w-4" />
                    </div>

                    <input
                        type="text"
                        x-model="search"
                        @keydown.escape="close"
                        @keydown.enter.prevent="selectActive"
                        @keydown.down.prevent="navigateDown"
                        @keydown.up.prevent="navigateUp"
                        placeholder="Search..."
                        class="w-full h-9 pl-9 pr-9 text-sm rounded-md border border-border bg-input text-foreground placeholder:text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    />

                    <button
                        type="button"
                        x-show="search"
                        x-cloak
                        @click="search = ''"
                        class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center text-muted-foreground hover:text-foreground transition-colors"
                    >
                        <x-pegboard::icon name="x-mark" variant="micro" class="h-4 w-4" />
                    </button>
                </div>
            @endif

            <div
                class="max-h-60 overflow-y-auto scrollbar-thin flex flex-col gap-1"
                x-ref="optionsList"
            >
                {{ $slot }}

                <div
                    x-show="filteredOptions.length === 0"
                    x-cloak
                    class="px-2 py-6 text-center text-sm text-muted-foreground"
                >
                    No results found
                </div>
            </div>
    </div>
</div>
