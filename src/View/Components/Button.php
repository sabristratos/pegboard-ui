<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    public function __construct(
        public string $variant = 'primary',
        public string $size = 'md',
        public ?string $icon = null,
        public ?string $iconRight = null,
        public ?string $iconVariant = null,
        public bool $loading = false,
        public bool $disabled = false,
        public ?string $loadingText = null,
        public bool $iconOnly = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.button');
    }
}
