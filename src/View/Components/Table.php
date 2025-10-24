<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Table extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $size = 'md',
        public bool $responsive = true,
        public bool $stickyHeader = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.table');
    }
}
