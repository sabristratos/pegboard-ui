<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Tab;

use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    public function __construct(
        public string $name = '',
        public ?string $icon = null,
        public ?string $iconTrailing = null,
        public ?string $iconVariant = null,
        public bool $action = false,
        public bool $accent = false,
        public bool $disabled = false,
        public string|int|null $badge = null,
        public string $badgeVariant = 'default',
        public bool $loading = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.tab.button');
    }
}
