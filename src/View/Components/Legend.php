<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Legend extends Component
{
    public function render(): View
    {
        return view('pegboard::components.legend');
    }
}
