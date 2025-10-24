<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Menu;

use Illuminate\View\Component;
use Illuminate\View\View;

class CheckboxGroup extends Component
{
    public function __construct(
        public array $value = [],
    ) {}

    public function render(): View
    {
        return view('pegboard::components.menu.checkbox-group');
    }
}
