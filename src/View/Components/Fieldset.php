<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Fieldset extends Component
{
    public function __construct(
        public ?string $legend = null,
        public ?string $description = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.fieldset');
    }
}
