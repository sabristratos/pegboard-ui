<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Menu;

use Illuminate\View\Component;
use Illuminate\View\View;

class Item extends Component
{
    public function __construct(
        public ?string $icon = null,
        public ?string $iconTrailing = null,
        public string $iconVariant = 'outline',
        public ?string $kbd = null,
        public ?string $suffix = null,
        public string $variant = 'default',
        public bool $disabled = false,
        public bool $keepOpen = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.menu.item');
    }
}
