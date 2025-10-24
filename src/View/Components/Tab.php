<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Tab extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $size = 'base',
        public string $orientation = 'horizontal',
        public bool $scrollable = false,
        public ?string $scrollableFade = null,
        public ?string $scrollableScrollbar = null,
        public bool $padded = false,
    ) {}

    public function getTabClasses(): string
    {
        $baseClasses = 'relative px-4 py-2 text-sm font-medium transition-colors duration-200';

        $interactionClasses = match ($this->variant) {
            'pills' => 'rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800',
            'underline' => 'hover:text-gray-900 dark:hover:text-gray-100',
            default => 'hover:bg-gray-50 dark:hover:bg-gray-900',
        };

        return "{$baseClasses} {$interactionClasses}";
    }

    public function getActiveClasses(): string
    {
        return match ($this->variant) {
            'pills' => 'bg-white dark:bg-gray-700 shadow-sm',
            'underline' => 'text-primary-600 dark:text-primary-400',
            default => 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700',
        };
    }

    public function getInactiveClasses(): string
    {
        return match ($this->variant) {
            'pills' => 'text-gray-600 dark:text-gray-400',
            'underline' => 'text-gray-500 dark:text-gray-400',
            default => 'text-gray-600 dark:text-gray-400 border-transparent',
        };
    }

    public function render(): View
    {
        return view('pegboard::components.tab.index');
    }
}
