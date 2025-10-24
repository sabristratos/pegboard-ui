<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Heading extends Component
{
    public function __construct(
        public string $size = 'md',
        public ?int $level = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.heading');
    }
}
