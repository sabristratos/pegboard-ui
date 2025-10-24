<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Toast extends Component
{
    public function __construct(
        public string $position = 'bottom end',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.toast');
    }
}
