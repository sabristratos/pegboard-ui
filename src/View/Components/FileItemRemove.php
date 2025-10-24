<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FileItemRemove extends Component
{
    public function render(): View
    {
        return view('pegboard::components.file-upload.item-remove');
    }
}
