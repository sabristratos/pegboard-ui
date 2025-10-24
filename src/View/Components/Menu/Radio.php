<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Menu;

use Illuminate\View\Component;
use Illuminate\View\View;

class Radio extends Component
{
    public function __construct(
        public string|int $value,
        public bool $checked = false,
        public bool $disabled = false,
        public bool $keepOpen = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.menu.radio');
    }
}
