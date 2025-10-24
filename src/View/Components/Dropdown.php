<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Dropdown extends Component
{
    public function __construct(
        public string $position = 'bottom',
        public string $align = 'start',
        public int $offset = 0,
        public int $gap = 4,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.dropdown');
    }
}
