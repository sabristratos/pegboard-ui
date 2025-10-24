<?php

declare(strict_types=1);

namespace Stratos\Pegboard\View\Components\FileUpload;

use Illuminate\View\Component;
use Illuminate\View\View;

class Avatar extends Component
{
    public function __construct(
        public ?string $name = null,
        public string $size = 'md',
        public ?string $label = null,
        public ?string $description = null,
        public ?string $error = null,
        public bool $disabled = false,
        public string $accept = 'image/*',
    ) {}

    public function render(): View
    {
        return view('pegboard::components.file-upload.avatar');
    }

    /**
     * Get the size classes for the avatar circle
     */
    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'h-24 w-24',
            'md' => 'h-32 w-32',
            'lg' => 'h-40 w-40',
            'xl' => 'h-48 w-48',
            default => 'h-32 w-32',
        };
    }

    /**
     * Get the icon size classes based on avatar size
     */
    public function getIconSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'h-12 w-12',
            'md' => 'h-16 w-16',
            'lg' => 'h-20 w-20',
            'xl' => 'h-24 w-24',
            default => 'h-16 w-16',
        };
    }

    /**
     * Get the camera badge size classes
     */
    public function getBadgeSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'h-7 w-7',
            'md' => 'h-10 w-10',
            'lg' => 'h-12 w-12',
            'xl' => 'h-14 w-14',
            default => 'h-10 w-10',
        };
    }

    /**
     * Get the camera icon size classes
     */
    public function getCameraIconSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'h-3.5 w-3.5',
            'md' => 'h-5 w-5',
            'lg' => 'h-6 w-6',
            'xl' => 'h-7 w-7',
            default => 'h-5 w-5',
        };
    }

    /**
     * Get the remove button size classes
     */
    public function getRemoveButtonSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'h-6 w-6',
            'md' => 'h-8 w-8',
            'lg' => 'h-9 w-9',
            'xl' => 'h-10 w-10',
            default => 'h-8 w-8',
        };
    }

    /**
     * Get the remove icon size classes
     */
    public function getRemoveIconSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'h-3 w-3',
            'md' => 'h-4 w-4',
            'lg' => 'h-4.5 w-4.5',
            'xl' => 'h-5 w-5',
            default => 'h-4 w-4',
        };
    }
}
