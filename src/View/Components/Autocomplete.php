<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Stratos\Pegboard\Support\PopoverPositioning;

class Autocomplete extends Component
{
    public array $popoverConfig;

    public string $popoverId;

    public function __construct(
        public string $variant = 'default',
        public string $size = 'md',
        public ?string $label = null,
        public ?string $description = null,
        public ?string $placeholder = null,
        public ?string $icon = null,
        public ?string $iconVariant = null,
        public bool $clearable = false,
        public bool $disabled = false,
        public string $emptyText = 'No results found',
        public ?string $value = null,
    ) {
        $this->popoverId = 'autocomplete-'.uniqid();
        $this->popoverConfig = PopoverPositioning::getConfiguration(
            $this->popoverId,
            'bottom-start',
            8,
            matchWidth: true
        );
    }

    public function render(): View
    {
        return view('pegboard::components.autocomplete');
    }
}
