<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Badge extends Component
{
    public function __construct(
        public string $variant = 'solid',
        public string $color = 'default',
        public string $size = 'md',
        public string $shape = 'rectangle',
        public string $placement = 'top-right',
        public string|int|null $content = null,
        public bool $isDot = false,
        public bool $isInvisible = false,
        public bool $showOutline = true,
        public ?string $icon = null,
        public ?string $iconRight = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.badge');
    }
}
