<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class CarouselControls extends Component
{
    public function __construct(
        public string $variant = 'solid',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.carousel.controls');
    }
}
