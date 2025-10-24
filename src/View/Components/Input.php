<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $size = 'md',
        public ?string $icon = null,
        public ?string $iconRight = null,
        public ?string $iconVariant = null,
        public bool $clearable = false,
        public bool $showPassword = false,
        public bool $copy = false,
        public bool $viewInNewPage = false,
        public bool $disabled = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.input');
    }
}
