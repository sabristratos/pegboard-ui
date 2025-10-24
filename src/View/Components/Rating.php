<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Rating extends Component
{
    public function __construct(
        public ?float $value = 0,
        public int $max = 5,
        public string $size = 'md',
        public string $icon = 'star',
        public string $variant = 'warning',
        public bool $showValue = false,
    ) {
        $this->value = $value ?? 0;
    }

    public function render(): View
    {
        return view('pegboard::components.rating');
    }
}
