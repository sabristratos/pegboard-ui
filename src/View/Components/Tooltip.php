<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Stratos\Pegboard\Support\PopoverPositioning;

class Tooltip extends Component
{
    public array $popoverConfig;

    public string $tooltipId;

    public function __construct(
        public string $text = '',
        public string $placement = 'top',
        public int $offset = 8,
    ) {
        $this->tooltipId = 'tooltip-'.uniqid();
        $this->popoverConfig = PopoverPositioning::getConfiguration(
            $this->tooltipId,
            $this->placement,
            $this->offset
        );
    }

    public function render(): View
    {
        return view('pegboard::components.tooltip');
    }
}
