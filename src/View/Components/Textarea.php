<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Textarea extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $size = 'md',
        public int $rows = 4,
        public bool $clearable = false,
        public bool $copy = false,
        public bool $disabled = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.textarea');
    }
}
