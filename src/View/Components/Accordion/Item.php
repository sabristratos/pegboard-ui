<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Accordion;

use Illuminate\View\Component;
use Illuminate\View\View;

class Item extends Component
{
    public function __construct(
        public bool $open = false,
        public ?string $heading = null,
        public ?string $accordionType = null,
        public ?string $accordionName = null
    ) {}

    public function render(): View
    {
        return view('pegboard::components.accordion.item');
    }
}
