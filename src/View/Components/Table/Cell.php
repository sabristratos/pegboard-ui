<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Table;

use Illuminate\View\Component;
use Illuminate\View\View;

class Cell extends Component
{
    public function __construct(
        public string $align = 'left',
        public string|bool $sticky = false,
        public string $size = 'md',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.table.cell');
    }
}
