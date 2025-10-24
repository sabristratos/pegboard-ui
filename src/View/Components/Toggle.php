<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Toggle extends Component
{
    public function __construct(
        public string $size = 'md',
        public bool $checked = false,
        public bool $disabled = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.toggle');
    }
}
