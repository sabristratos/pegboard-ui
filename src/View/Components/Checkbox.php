<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Checkbox extends Component
{
    public function __construct(
        public string|int $value,
        public ?string $label = null,
        public ?string $description = null,
        public string $variant = 'default',
        public string $displayVariant = 'default',
        public string $size = 'md',
        public ?string $name = null,
        public bool $disabled = false,
        public bool $indeterminate = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.checkbox');
    }
}
