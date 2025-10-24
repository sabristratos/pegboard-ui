<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Popover extends Component
{
    public function __construct(
        public string $placement = 'bottom',
        public string $trigger = 'click',
        public int $offset = 8,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.popover');
    }
}
