<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Item extends Component
{
    public bool $isActive;

    public function __construct(
        public ?string $href = null,
        public ?string $icon = null,
        public string|int|null $badge = null,
        public ?bool $active = null,
        public bool $expandable = false,
    ) {
        $this->isActive = $this->computeIsActive();
    }

    protected function computeIsActive(): bool
    {
        if ($this->active !== null) {
            return $this->active;
        }

        if (! $this->href) {
            return false;
        }

        $currentUrl = request()->url();
        $currentPath = parse_url($currentUrl, PHP_URL_PATH);
        $itemPath = parse_url($this->href, PHP_URL_PATH);

        if (! is_string($currentPath) || ! is_string($itemPath)) {
            return false;
        }

        if ($currentPath === $itemPath) {
            return true;
        }

        if ($itemPath !== '/' && str_starts_with($currentPath, rtrim($itemPath, '/'))) {
            return true;
        }

        return false;
    }

    public function render(): View
    {
        return view('pegboard::components.sidebar.item');
    }
}
