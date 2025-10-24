<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Header extends Component
{
    public function __construct() {}

    public function render(): View
    {
        return view('pegboard::components.sidebar.header');
    }
}
