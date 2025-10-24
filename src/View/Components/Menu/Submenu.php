<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Menu;

use Illuminate\View\Component;
use Illuminate\View\View;
use Stratos\Pegboard\Support\PopoverPositioning;

class Submenu extends Component
{
    public array $popoverConfig;

    public string $submenuId;

    public function __construct(
        public string $heading = '',
        public ?string $icon = null,
        public ?string $iconTrailing = null,
        public string $iconVariant = 'outline',
        public bool $keepOpen = false,
    ) {
        $this->submenuId = 'submenu-'.uniqid();
        $this->popoverConfig = PopoverPositioning::getConfiguration(
            $this->submenuId,
            'right-start',
            4
        );
    }

    public function render(): View
    {
        return view('pegboard::components.menu.submenu');
    }
}
