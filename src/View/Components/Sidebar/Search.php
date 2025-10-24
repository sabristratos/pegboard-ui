<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Search extends Component
{
    public function __construct(
        public string $placeholder = 'Search...',
        public ?array $shortcut = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.sidebar.search');
    }
}
