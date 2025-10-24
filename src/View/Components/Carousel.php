<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Carousel extends Component
{
    public function __construct(
        public bool $autoPlay = true,
        public int $interval = 5000,
        public bool $pauseOnHover = true,
        public bool $loop = true,
        public bool $peek = true,
        public string $peekAmount = '5rem',
        public bool $showControls = true,
        public bool $showIndicators = true,
        public bool $showThumbnails = false,
        public string $align = 'center',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.carousel');
    }
}
