<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Field extends Component
{
    public function __construct(
        public string $variant = 'block',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.field');
    }
}
