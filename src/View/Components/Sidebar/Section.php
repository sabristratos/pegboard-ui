<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Section extends Component
{
    public function __construct(
        public ?string $label = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.sidebar.section');
    }
}
