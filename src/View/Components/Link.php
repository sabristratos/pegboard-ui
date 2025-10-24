<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Link extends Component
{
    public bool $isExternal;

    public function __construct(
        public string $href,
        public string $variant = 'default',
        public string $underline = 'always',
        public bool $external = false,
        public string $size = 'base',
    ) {
        $this->isExternal = $external;
    }

    public function render(): View
    {
        return view('pegboard::components.link');
    }
}
