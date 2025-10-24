<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Chart extends Component
{
    /**
     * Create a new Chart component instance.
     *
     * Features:
     * - Unified crosshair tooltip for all chart types (bar, line, area)
     * - Multi-series tooltips showing all values at hovered x-position
     * - Smooth CSS animations using `starting:` utilities (fade + scale)
     * - Per-series color customization (hex, RGB, Tailwind, CSS vars, theme indices)
     * - Optional legend with top/bottom positioning
     * - Percentage-based bar width control
     *
     * @param  string  $type  Chart type (bar, line, area)
     * @param  array  $data  Chart data (single series array or multi-series array with optional colors)
     *                       Multi-series format: [['label' => 'Revenue', 'values' => [10, 20], 'color' => 'emerald-500']]
     *                       Single series format: [10, 20, 30] (auto-wrapped)
     * @param  array  $labels  X-axis labels
     * @param  string  $height  Chart height (CSS value, e.g., '300px', '20rem')
     * @param  array  $colors  Fallback color indices (1-5) if series don't specify colors
     * @param  bool  $animated  Enable entry animations with CSS transitions
     * @param  bool  $interactive  Enable interactive crosshair tooltips (all chart types)
     * @param  bool  $showGrid  Show grid lines
     * @param  bool  $showAxes  Show axes
     * @param  string  $chartId  Unique identifier for the chart instance (auto-generated if empty)
     * @param  bool  $showLegend  Show legend (only displayed for multi-series charts)
     * @param  string  $legendPosition  Legend position ('top' or 'bottom')
     * @param  int  $barSize  Bar size percentage (10-100) of available space, only affects bar charts
     */
    public function __construct(
        public string $type = 'bar',
        public array $data = [],
        public array $labels = [],
        public string $height = '300px',
        public array $colors = [1],
        public bool $animated = true,
        public bool $interactive = true,
        public bool $showGrid = true,
        public bool $showAxes = true,
        public string $chartId = '',
        public bool $showLegend = true,
        public string $legendPosition = 'bottom',
        public int $barSize = 70,
    ) {
        if (empty($this->chartId)) {
            $this->chartId = 'chart-'.uniqid();
        }
    }

    public function render(): View
    {
        return view('pegboard::components.chart');
    }

    /**
     * Normalize data into a consistent multi-series format
     * Single array becomes a single series
     * Array of series preserves structure
     */
    public function normalizedData(): array
    {
        if (empty($this->data)) {
            return [];
        }

        $firstItem = $this->data[0];

        if (is_array($firstItem) && isset($firstItem['values'])) {
            return $this->data;
        }

        return [
            [
                'label' => 'Data',
                'values' => $this->data,
            ],
        ];
    }

    /**
     * Normalize a color value to a valid CSS color.
     * Handles multiple formats: Tailwind names, hex, RGB, HSL, CSS variables, and theme indices.
     *
     * @param  string|int|null  $color  The color value to normalize
     * @param  int  $fallbackIndex  Fallback theme index (1-5) if color is null
     * @return string Valid CSS color value
     */
    private function normalizeColor(string|int|null $color, int $fallbackIndex = 1): string
    {
        if ($color === null) {
            return 'var(--color-chart-'.max(1, min(5, $fallbackIndex)).')';
        }

        if (is_int($color)) {
            return 'var(--color-chart-'.max(1, min(5, $color)).')';
        }

        $color = trim($color);

        if (str_starts_with($color, '#')) {
            return $color;
        }

        if (str_starts_with($color, 'rgb') || str_starts_with($color, 'hsl')) {
            return $color;
        }

        if (str_starts_with($color, 'var(')) {
            return $color;
        }

        if (is_numeric($color)) {
            return 'var(--color-chart-'.max(1, min(5, (int) $color)).')';
        }

        return "var(--color-{$color})";
    }

    /**
     * Get the chart color CSS variables.
     * Extracts colors from series data if available, otherwise falls back to $colors prop.
     *
     * @return array Array of CSS color strings
     */
    public function chartColors(): array
    {
        $normalizedData = $this->normalizedData();

        return array_map(
            fn ($series, $index) => $this->normalizeColor(
                $series['color'] ?? null,
                $this->colors[$index] ?? ($index + 1)
            ),
            $normalizedData,
            array_keys($normalizedData)
        );
    }
}
