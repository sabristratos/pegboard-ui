<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Select;

use Illuminate\View\Component;
use Illuminate\View\View;

class Option extends Component
{
    public function __construct(
        public string|int $value,
        public ?string $icon = null,
        public bool $disabled = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.select.option');
    }
}
