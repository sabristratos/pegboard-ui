<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Table;

use Illuminate\View\Component;
use Illuminate\View\View;

class Row extends Component
{
    public function render(): View
    {
        return view('pegboard::components.table.row');
    }
}
