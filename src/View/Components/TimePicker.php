<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Stratos\Pegboard\Support\PopoverPositioning;

class TimePicker extends Component
{
    public array $popoverConfig;

    public string $popoverId;

    public function __construct(
        public string $variant = 'default',
        public string $size = 'md',
        public string $format = '12',
        public int $step = 5,
        public bool $clearable = false,
        public bool $disabled = false,
        public string $placeholder = '',
        public ?string $name = null,
        public ?string $value = null,
    ) {
        $this->popoverId = 'time-picker-'.uniqid();
        $this->popoverConfig = PopoverPositioning::getConfiguration(
            $this->popoverId,
            'bottom-start',
            8
        );
    }

    public function render(): View
    {
        return view('pegboard::components.time-picker');
    }
}
