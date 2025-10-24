<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Radio;

use Illuminate\View\Component;
use Illuminate\View\View;

class Group extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $description = null,
        public string $orientation = 'vertical',
        public ?string $name = null,
        public ?string $value = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.radio.group');
    }
}
