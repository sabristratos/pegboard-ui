<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Menu extends Component
{
    public function __construct(
        public bool $keepOpen = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.menu');
    }
}
