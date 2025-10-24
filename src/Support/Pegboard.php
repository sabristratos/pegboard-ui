<?php

declare(strict_types=1);

namespace Stratos\Pegboard\Support;

use Livewire\Livewire;

class Pegboard
{
    /**
     * Display a toast notification
     *
     * @param  string|null  $text  The main toast message
     * @param  string|null  $heading  Optional heading for the toast
     * @param  string  $variant  Toast variant: 'default', 'success', 'warning', 'danger'
     * @param  int  $duration  Duration in milliseconds (0 for permanent)
     */
    public static function toast(
        ?string $text = null,
        ?string $heading = null,
        string $variant = 'default',
        int $duration = 5000,
    ): void {
        if ($text === null && $heading === null) {
            throw new \InvalidArgumentException('Toast must have at least text or heading');
        }

        $payload = array_filter([
            'text' => $text,
            'heading' => $heading,
            'variant' => $variant,
            'duration' => $duration,
        ], fn ($value) => $value !== null);

        static::dispatch('pegboard:toast', $payload);
    }

    /**
     * Dispatch a browser event
     */
    protected static function dispatch(string $event, mixed $data = null): void
    {
        $component = Livewire::current();

        if ($component) {
            $component->dispatch($event, [$data]);
        } else {
            $flashed = session()->get($event, []);
            $flashed[] = $data;
            session()->flash($event, $flashed);
        }
    }
}
