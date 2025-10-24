@php
    $rangeId = $attributes->get('id', 'range-' . uniqid());

    $containerClasses = match($orientation) {
        'vertical' => 'flex flex-col-reverse items-center gap-2 h-full',
        default => 'flex flex-col gap-2 w-full',
    };

    $trackWrapperClasses = match($orientation) {
        'vertical' => 'relative flex flex-col h-full justify-center items-center',
        default => 'relative flex gap-2 items-center',
    };

    $trackHeightWidth = match([$orientation, $size]) {
        ['vertical', 'sm'] => 'w-1 mx-2',
        ['vertical', 'md'] => 'w-3 mx-3',
        ['vertical', 'lg'] => 'w-7 mx-3.5',
        ['horizontal', 'sm'] => 'h-1 my-2',
        ['horizontal', 'md'] => 'h-3 my-3',
        ['horizontal', 'lg'] => 'h-7 my-3.5',
        default => 'h-3 my-3',
    };

    $thumbSize = match($size) {
        'sm' => 'w-5 h-5 after:w-4 after:h-4',
        'md' => 'w-6 h-6 after:w-5 after:h-5',
        'lg' => 'h-7 w-7 after:w-5 after:h-5',
        default => 'w-6 h-6 after:w-5 after:h-5',
    };

    $colorClasses = match($color) {
        'success' => 'bg-success border-success',
        'warning' => 'bg-warning border-warning',
        'danger' => 'bg-destructive border-destructive',
        'foreground' => 'bg-foreground border-foreground',
        default => 'bg-primary border-primary',
    };

    $fillColorClass = match($color) {
        'success' => 'bg-success',
        'warning' => 'bg-warning',
        'danger' => 'bg-destructive',
        'foreground' => 'bg-foreground',
        default => 'bg-primary',
    };

    $stepCount = ($max - $min) / $step;
    $steps = $showSteps && $stepCount <= 100 ? range(0, $stepCount) : [];

    $containerAttributes = $attributes->except(['class', 'wire:model', 'wire:model.live', 'wire:model.defer', 'wire:model.blur', 'wire:model.lazy'])->merge([
        'id' => $rangeId,
    ]);

    $wrapperClasses = $attributes->get('class', '');

    if ($isRange) {
        $initialValue = array_map(fn($thumb) => $thumb['value'], $thumbs);
    } else {
        $initialValue = $thumbs[0]['value'] ?? $min;
    }

    $fillerRounding = $isRange
        ? 'rounded-full'
        : ($orientation === 'vertical' ? 'rounded-b-full' : 'rounded-l-full');
@endphp

<div
    wire:ignore
    x-modelable="value"
    {{ $attributes->only(['wire:model', 'wire:model.live', 'wire:model.defer', 'wire:model.blur', 'wire:model.lazy']) }}
    x-data="pegboardRange({
        min: {{ $min }},
        max: {{ $max }},
        step: {{ $step }},
        orientation: '{{ $orientation }}',
        isRange: {{ $isRange ? 'true' : 'false' }},
        thumbs: {{ json_encode($thumbs) }},
        formatOptions: {{ $formatOptions ? json_encode($formatOptions) : 'null' }},
        rangeId: '{{ $rangeId }}',
        initialValue: {{ json_encode($initialValue) }},
        disabled: {{ $disabled ? 'true' : 'false' }}
    })"
    data-pegboard-range
    data-orientation="{{ $orientation }}"
    {{ $containerAttributes->merge(['class' => $containerClasses . ' ' . $wrapperClasses . ($disabled ? ' opacity-50 pointer-events-none' : '')]) }}
    role="group"
    aria-label="{{ $label ?: 'Range slider' }}"
    @if($disabled) aria-disabled="true" @endif
>

    @if($label || $showValue)
        <div class="w-full flex justify-between items-center">
            @if($label)
                <label class="text-sm font-medium text-foreground" :for="rangeId">{{ $label }}</label>
            @endif

            @if($showValue)
                <output class="text-sm text-muted-foreground" :for="thumbInputIds.join(' ')" x-text="formattedValue" aria-live="off"></output>
            @endif
        </div>
    @endif

    <div class="{{ $trackWrapperClasses }}">
        @if(isset($startContent))
            {{ $startContent }}
        @endif

        <div
            class="flex relative rounded-full bg-muted/50 {{ $trackHeightWidth }} {{ $orientation === 'vertical' ? 'h-full' : 'w-full' }}"
            @click="handleTrackClick($event)"
            x-ref="track"
        >
            <div
                class="absolute {{ $fillColorClass }} {{ $fillerRounding }} {{ $orientation === 'vertical' ? 'w-full' : 'h-full' }} motion-reduce:transition-none"
                data-pegboard-filler
                :class="{
                    'transition-[left,bottom,width,height] duration-150': isInitialized && !isDragging,
                    'transition-none': !isInitialized || isDragging
                }"
                :style="fillerStyle"
            ></div>

            @if($showSteps)
                <template x-for="stepIndex in {{ count($steps) }}" :key="stepIndex">
                    <div
                        class="absolute rounded-full {{ $size === 'lg' ? 'w-2 h-2' : 'h-1.5 w-1.5' }} bg-muted data-[in-range=true]:{{ $fillColorClass }} {{ $orientation === 'vertical' ? 'left-1/2 -translate-x-1/2' : 'top-1/2 -translate-y-1/2' }}"
                        :data-in-range="isStepInRange(stepIndex - 1)"
                        :style="stepStyle(stepIndex - 1)"
                    ></div>
                </template>
            @endif

            @if($marks)
                @foreach($marks as $mark)
                    <div
                        class="absolute text-xs {{ $orientation === 'vertical' ? 'left-full ml-2' : 'top-full mt-2 -translate-x-1/2' }} text-muted-foreground"
                        style="{{ $orientation === 'vertical' ? 'top' : 'left' }}: {{ (($mark['value'] - $min) / ($max - $min)) * 100 }}%"
                    >
                        {{ $mark['label'] }}
                    </div>
                @endforeach
            @endif
            <template x-for="(thumb, index) in thumbsState" :key="index">
                <div
                    class="flex justify-center items-center before:absolute before:w-11 before:h-11 before:rounded-full after:shadow-sm after:bg-card {{ $thumbSize }} rounded-full after:rounded-full {{ $colorClasses }} {{ $orientation === 'vertical' ? 'left-1/2' : 'top-1/2' }} cursor-grab data-[dragging=true]:cursor-grabbing border-2 shadow-sm {{ $hideThumb ? 'opacity-0' : '' }} hover:scale-105 hover:shadow-lg data-[dragging=true]:shadow-lg data-[dragging=true]:after:scale-80 after:transition-all motion-reduce:after:transition-none motion-reduce:transition-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                    :class="{
                        'transition-[left,top,transform,box-shadow] duration-150': isInitialized && !thumb.dragging,
                        'transition-none': !isInitialized || thumb.dragging
                    }"
                    data-pegboard-thumb
                    :data-dragging="thumb.dragging"
                    :style="thumbStyle(index)"
                    @mousedown="startDrag($event, index)"
                    @touchstart="startDrag($event, index)"
                    tabindex="0"
                    role="slider"
                    :aria-valuemin="getThumbMin(index)"
                    :aria-valuemax="getThumbMax(index)"
                    :aria-valuenow="thumb.value"
                    :aria-label="'Thumb ' + (index + 1)"
                    @keydown="handleKeyDown($event, index)"
                >
                    <input
                        type="range"
                        class="sr-only"
                        :id="thumbInputIds[index]"
                        :name="$el.closest('[data-pegboard-range]')?.getAttribute('name') || null"
                        :min="getThumbMin(index)"
                        :max="getThumbMax(index)"
                        :step="step"
                        :value="thumb.value"
                        x-ref="input"
                        tabindex="-1"
                    />

                    <div
                        x-show="thumb.dragging && tooltipVisible"
                        x-text="tooltipValue"
                        class="absolute {{ $orientation === 'vertical' ? 'left-full ml-3' : 'bottom-full mb-3' }} px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded shadow-lg pointer-events-none whitespace-nowrap transition-[opacity,transform] duration-fast starting:opacity-0 starting:scale-90"
                    ></div>
                </div>
            </template>
        </div>

        @if(isset($endContent))
            {{ $endContent }}
        @endif
    </div>
</div>
