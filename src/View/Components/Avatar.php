<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Avatar extends Component
{
    public function __construct(
        public ?string $src = null,
        public ?string $name = null,
        public string $color = 'default',
        public string $size = 'md',
        public string $radius = 'full',
        public bool $isBordered = false,
    ) {}

    public function getInitials(): string
    {
        if (! $this->name) {
            return '';
        }

        $words = explode(' ', trim($this->name));
        $initials = '';

        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= mb_strtoupper(mb_substr($word, 0, 1));
        }

        return $initials;
    }

    public function render(): View
    {
        return view('pegboard::components.avatar');
    }
}
