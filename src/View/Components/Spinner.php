<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Spinner extends Component
{
    public string $sizeClass;

    public function __construct(
        public string $variant = 'simple',
        public ?string $size = null,
        public string $label = 'Loading',
    ) {
        $this->sizeClass = $size ? match ($size) {
            'sm' => 'w-4 h-4',
            'md' => 'w-8 h-8',
            'lg' => 'w-12 h-12',
            default => 'w-8 h-8',
        } : '';
    }

    public function render(): View
    {
        return view('pegboard::components.spinner');
    }
}
