<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Alert extends Component
{
    public function __construct(
        public string $variant = 'info',
        public ?string $icon = null,
        public ?string $title = null,
        public bool $showIcon = true,
    ) {}

    public function getDefaultIcon(): string
    {
        return match ($this->variant) {
            'success' => 'check-circle',
            'warning' => 'exclamation-triangle',
            'danger' => 'x-circle',
            'neutral' => 'information-circle',
            default => 'information-circle',
        };
    }

    public function render(): View
    {
        return view('pegboard::components.alert');
    }
}
