<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Separator extends Component
{
    public function __construct(
        public bool $vertical = false,
        public string $variant = 'default',
        public ?string $text = null,
        public string $orientation = 'horizontal',
    ) {
        if ($this->orientation === 'vertical') {
            $this->vertical = true;
        }
    }

    public function render(): View
    {
        return view('pegboard::components.separator');
    }
}
