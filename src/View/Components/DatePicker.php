<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Stratos\Pegboard\Support\PopoverPositioning;

class DatePicker extends Component
{
    public array $popoverConfig;

    public string $popoverId;

    public function __construct(
        public string $variant = 'default',
        public string $size = 'md',
        public string $format = 'Y-m-d',
        public ?string $value = null,
        public string $placeholder = 'Select date',
        public ?string $name = null,
        public bool $range = false,
        public bool $clearable = false,
        public bool $disabled = false,
    ) {
        $this->popoverId = 'date-picker-'.uniqid();
        $this->popoverConfig = PopoverPositioning::getConfiguration(
            $this->popoverId,
            'bottom-start',
            8
        );
    }

    public function render(): View
    {
        return view('pegboard::components.date-picker');
    }
}
