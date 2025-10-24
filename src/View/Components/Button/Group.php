<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Button;

use Illuminate\View\Component;
use Illuminate\View\View;

class Group extends Component
{
    public function __construct() {}

    public function render(): View
    {
        return view('pegboard::components.button.group');
    }
}
