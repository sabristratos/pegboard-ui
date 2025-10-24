<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Sidebar extends Component
{
    public function __construct(
        public string $position = 'left',
        public bool $open = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.sidebar');
    }
}
