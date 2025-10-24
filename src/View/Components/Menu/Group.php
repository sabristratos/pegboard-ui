<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Menu;

use Illuminate\View\Component;
use Illuminate\View\View;

class Group extends Component
{
    public function __construct(
        public ?string $heading = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.menu.group');
    }
}
