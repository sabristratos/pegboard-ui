<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Icon extends Component
{
    public string $iconComponent;

    public function __construct(
        public string $name,
        public string $variant = 'outline',
        public ?string $set = null,
    ) {
        if ($this->set === 'custom') {
            $this->iconComponent = 'pegboard::icons.'.$this->name;

            return;
        }

        if (! $this->set && $this->customIconExists()) {
            $this->iconComponent = 'pegboard::icons.'.$this->name;

            return;
        }

        $prefix = match ($this->variant) {
            'solid' => 'heroicon-s',
            'mini' => 'heroicon-m',
            'micro' => 'heroicon-c',
            default => 'heroicon-o',
        };

        $this->iconComponent = $prefix.'-'.$this->name;
    }

    /**
     * Check if a custom icon blade component exists.
     */
    protected function customIconExists(): bool
    {
        return view()->exists('pegboard::components.icons.'.$this->name);
    }

    public function render(): View
    {
        return view('pegboard::components.icon');
    }
}
