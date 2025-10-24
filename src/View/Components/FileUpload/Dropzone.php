<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\FileUpload;

use Illuminate\View\Component;
use Illuminate\View\View;

class Dropzone extends Component
{
    public function __construct(
        public ?string $heading = null,
        public ?string $text = null,
        public string $icon = 'cloud-arrow-up',
        public bool $inline = false,
        public bool $withProgress = false,
    ) {}

    public function render(): View
    {
        return view('pegboard::components.file-upload.dropzone');
    }
}
