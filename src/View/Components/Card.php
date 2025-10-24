<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Card extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $padding = 'lg',
        public bool $loading = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.card');
    }
}
