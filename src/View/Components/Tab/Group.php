<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Tab;

use Illuminate\View\Component;
use Illuminate\View\View;

class Group extends Component
{
    public string $groupId;

    public function __construct(
        ?string $name = null,
        public string $variant = 'default',
        public string $size = 'base',
        public string $orientation = 'horizontal',
        public bool $scrollable = false,
        public ?string $scrollableFade = null,
        public ?string $scrollableScrollbar = null,
        public bool $padded = false,
    ) {
        $this->groupId = $name ?? 'tab-group-'.uniqid();
    }

    public function render(): View
    {
        return view('pegboard::components.tab.group');
    }
}
