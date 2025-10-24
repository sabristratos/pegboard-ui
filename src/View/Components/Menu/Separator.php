<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Menu;

use Illuminate\View\Component;
use Illuminate\View\View;

class Separator extends Component
{
    public function render(): View
    {
        return view('pegboard::components.menu.separator');
    }
}
