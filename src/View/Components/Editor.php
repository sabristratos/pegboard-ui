<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Editor extends Component
{
    public function __construct(
        public string $name = '',
        public string $content = '',
        public string $placeholder = 'Start writing...',
        public bool $editable = true,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.editor');
    }
}
