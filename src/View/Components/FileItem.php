<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FileItem extends Component
{
    public string $formattedSize;

    public function __construct(
        public string $heading,
        public ?string $text = null,
        public ?string $image = null,
        public ?int $size = null,
        public string $icon = 'document',
        public bool $invalid = false,
    ) {
        $this->formattedSize = $this->formatFileSize($size ?? 0);
    }

    public function render(): View
    {
        return view('pegboard::components.file-upload.item');
    }

    private function formatFileSize(int $bytes): string
    {
        if ($bytes === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);

        $size = $bytes / pow(1024, $power);

        $formatted = number_format($size, 2, '.', '');
        $formatted = rtrim($formatted, '0');
        $formatted = rtrim($formatted, '.');

        return $formatted.' '.$units[$power];
    }
}
