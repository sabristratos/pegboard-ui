<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Group extends Component
{
    public function __construct(
        public string $orientation = 'horizontal',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.group');
    }
}
