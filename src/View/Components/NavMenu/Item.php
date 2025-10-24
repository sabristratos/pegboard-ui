<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\NavMenu;

use Illuminate\View\Component;
use Illuminate\View\View;

class Item extends Component
{
    public function __construct(
        public ?string $href = null,
        public ?string $icon = null,
        public string $iconVariant = 'outline',
        public string $variant = 'default',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.nav-menu.item');
    }
}
