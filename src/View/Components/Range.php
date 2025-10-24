<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Range extends Component
{
    public array $thumbs;

    public bool $isRange;

    public function __construct(
        public float $min = 0,
        public float $max = 100,
        public float $step = 1,
        public int|float|array|null $value = null,
        public int|float|array|null $defaultValue = null,
        public string $orientation = 'horizontal',
        public string $size = 'md',
        public string $color = 'primary',
        public ?string $label = null,
        public bool $showValue = true,
        public bool $showSteps = false,
        public ?array $marks = null,
        public bool $hideThumb = false,
        public bool $disabled = false,
        public ?array $formatOptions = null,
    ) {
        if ($step <= 0) {
            throw new \InvalidArgumentException('Step must be greater than 0');
        }

        $initialValue = $value ?? $defaultValue ?? $min;

        $values = is_array($initialValue) ? $initialValue : [$initialValue];

        $this->isRange = count($values) > 1;

        $this->thumbs = array_map(function ($val) {
            return [
                'value' => $val,
                'percentage' => $this->valueToPercentage($val),
            ];
        }, $values);
    }

    public function render(): View
    {
        return view('pegboard::components.range');
    }

    private function valueToPercentage(float $value): float
    {
        if ($this->max === $this->min) {
            return 0;
        }

        return (($value - $this->min) / ($this->max - $this->min)) * 100;
    }
}
