<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Status extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $size = 'md',
        public bool $pulse = false,
        public ?string $label = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.status');
    }
}
