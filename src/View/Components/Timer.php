<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Timer extends Component
{
    public function __construct(
        public int $duration = 60,
        public string $mode = 'countdown',
        public bool $autostart = false,
        public bool $disabled = false,
        public bool $showHours = true,
        public string $size = 'md',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.timer');
    }
}
