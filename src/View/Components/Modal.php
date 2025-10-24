<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Modal extends Component
{
    public function __construct(
        public string $name = '',
        public string $variant = 'default',
        public string $position = 'right',
        public bool $dismissible = true,
        public bool $closable = true,
        public bool $blur = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.modal');
    }
}
