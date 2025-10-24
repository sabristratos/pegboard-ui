<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Menu;

use Illuminate\View\Component;
use Illuminate\View\View;

class RadioGroup extends Component
{
    public function __construct(
        public ?string $value = null,
        public bool $keepOpen = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.menu.radio-group');
    }
}
