<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Tab;

use Illuminate\View\Component;
use Illuminate\View\View;

class Panel extends Component
{
    public function __construct(
        public string $name = '',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.tab.panel');
    }
}
