<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Accordion;

use Illuminate\View\Component;
use Illuminate\View\View;

class Heading extends Component
{
    public function render(): View
    {
        return view('pegboard::components.accordion.heading');
    }
}
