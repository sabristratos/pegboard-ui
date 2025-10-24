<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Autocomplete;

use Illuminate\View\Component;
use Illuminate\View\View;

class Option extends Component
{
    public function __construct(
        public bool $disabled = false,
        public ?string $searchText = null,
        public ?string $href = null,
        public ?string $value = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.autocomplete.option');
    }
}
