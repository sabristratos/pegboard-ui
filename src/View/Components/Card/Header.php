<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Card;

use Illuminate\View\Component;
use Illuminate\View\View;

class Header extends Component
{
    public function render(): View
    {
        return view('pegboard::components.card.header');
    }
}
