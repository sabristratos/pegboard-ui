@php
    $series = $normalizedData();
    $seriesJson = json_encode($series);
    $labelsJson = json_encode($labels);
    $colorsJson = json_encode($chartColors());

    $baseClasses = 'w-full';
    $containerClasses = 'relative';
@endphp

<figure
    x-data="chart({
        type: '{{ $type }}',
        series: {{ $seriesJson }},
        labels: {{ $labelsJson }},
        colors: {{ $colorsJson }},
        animated: {{ $animated ? 'true' : 'false' }},
        interactive: {{ $interactive ? 'true' : 'false' }},
        showGrid: {{ $showGrid ? 'true' : 'false' }},
        showAxes: {{ $showAxes ? 'true' : 'false' }},
        chartId: '{{ $chartId }}',
        barSize: {{ $barSize }}
    })"
    data-chart-type="{{ $type }}"
    data-interactive="{{ $interactive ? 'true' : 'false' }}"
    data-animated="{{ $animated ? 'true' : 'false' }}"
    role="img"
    :aria-label="ariaLabel"
    {{ $attributes->merge(['class' => $baseClasses]) }}
    x-cloak
    wire:ignore
>
    @if($showLegend && count($series) > 1 && $legendPosition === 'top')
        <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 mb-4">
            @foreach($series as $index => $item)
                <div class="flex items-center gap-2">
                    <div
                        class="w-3 h-3 rounded-full flex-shrink-0"
                        style="background-color: {{ $chartColors()[$index] }}"
                    ></div>
                    <span class="text-sm text-foreground">{{ $item['label'] ?? 'Series ' . ($index + 1) }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <div :style="{ height: '{{ $height }}' }" class="{{ $containerClasses }}">
        <svg
            x-ref="chartSvg"
            :view-box.camel="viewBox"
            class="w-full h-full"
            preserveAspectRatio="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <defs data-gradient-container></defs>

            <g data-grid-container class="text-border" opacity="0.2"></g>

            <g data-y-axis-container></g>
            <g data-x-axis-container></g>

            <g data-chart-container></g>

            <line
                x-show="interactive && hoveredDataIndex !== null"
                x-cloak
                :x1="crosshairX"
                :y1="padding.top"
                :x2="crosshairX"
                :y2="chartHeight"
                stroke="currentColor"
                stroke-width="1"
                stroke-dasharray="4 4"
                class="text-muted-foreground pointer-events-none"
                opacity="0.5"
                data-crosshair
            ></line>

            <rect
                x-ref="chartOverlay"
                x-show="interactive"
                :x="padding.left"
                :y="padding.top"
                :width="plotWidth"
                :height="plotHeight"
                fill="transparent"
                style="pointer-events: all; cursor: crosshair;"
                @mousemove="handleChartHover($event)"
                @mouseleave="handleChartLeave()"
                data-chart-overlay
            ></rect>
        </svg>

        <div
            x-show="interactive && hoveredDataIndex !== null"
            x-cloak
            :style="{
                position: 'absolute',
                left: `${tooltipPosition.x}px`,
                top: `${tooltipPosition.y}px`,
                transform: 'translate(-50%, 0)',
            }"
            class="bg-gray-900 dark:bg-gray-800 text-white text-base px-4 py-2.5 rounded max-w-xs shadow-lg pointer-events-none origin-center transition-[opacity,transform,overlay,display] duration-fast ease-out transition-discrete starting:opacity-0 starting:scale-95 z-10"
            data-tooltip
        >
            <div class="space-y-2">
                <div class="font-medium text-base opacity-75" x-text="tooltipContent.label"></div>
                <template x-for="(item, index) in tooltipContent.series" :key="index">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-3 h-3 rounded-full flex-shrink-0"
                                :style="`background-color: ${item.color}`"
                            ></div>
                            <span class="text-base" x-text="item.name"></span>
                        </div>
                        <span class="font-semibold tabular-nums text-base" x-text="item.value"></span>
                    </div>
                </template>
            </div>
        </div>

        @if($showLegend && count($series) > 1 && $legendPosition === 'bottom')
            <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 mt-4">
                @foreach($series as $index => $item)
                    <div class="flex items-center gap-2">
                        <div
                            class="w-3 h-3 rounded-full flex-shrink-0"
                            style="background-color: {{ $chartColors()[$index] }}"
                        ></div>
                        <span class="text-sm text-foreground">{{ $item['label'] ?? 'Series ' . ($index + 1) }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</figure>
