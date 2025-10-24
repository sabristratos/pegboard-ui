<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class BreadcrumbsItem extends Component
{
    public function __construct(
        public ?string $href = null,
        public ?string $icon = null,
        public string $iconVariant = 'mini',
        public string $separator = 'chevron-right',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.breadcrumbs-item');
    }
}
