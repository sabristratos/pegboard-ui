<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class RatingInput extends Component
{
    public function __construct(
        public int $max = 5,
        public string $size = 'md',
        public string $icon = 'star',
        public string $variant = 'warning',
        public bool $disabled = false,
        public bool $showReset = true,
        public bool $showValue = true,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.rating-input');
    }
}
