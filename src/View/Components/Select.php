<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{
    public function __construct(
        public bool $multiple = false,
        public bool $searchable = false,
        public string $placeholder = 'Select...',
        public string $displayVariant = 'default', // 'default' or 'pillbox' (pillbox requires multiple=true)
        public string $variant = 'default', // 'default', 'error', 'success'
        public string $size = 'md',
        public ?string $name = null,
        public mixed $value = null,
        public bool $disabled = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.select');
    }
}
