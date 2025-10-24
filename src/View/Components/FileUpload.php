<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FileUpload extends Component
{
    public function __construct(
        public ?string $name = null,
        public bool $multiple = false,
        public ?string $label = null,
        public ?string $description = null,
        public ?string $error = null,
        public bool $disabled = false,
        public ?string $accept = null,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.file-upload');
    }
}
