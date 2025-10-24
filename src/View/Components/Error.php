<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Error extends Component
{
    public function __construct(
        public ?string $name = null,
        public ?string $message = null,
        public string $bag = 'default',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.error');
    }
}
