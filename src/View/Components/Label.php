<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Label extends Component
{
    public function __construct(
        public ?string $for = null,
        public ?string $tooltip = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.label');
    }
}
