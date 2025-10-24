@php
    $modalId = $name ?: 'modal-' . uniqid();

    $backdropClasses = 'backdrop:bg-black/50 backdrop:transition-all backdrop:duration-normal starting:backdrop:bg-black/0';
    if ($blur) {
        $backdropClasses .= ' backdrop:backdrop-blur-sm';
    }

    if ($variant === 'flyout') {
        $baseClasses = '@container fixed m-0 flex flex-col overflow-hidden bg-card transition-all duration-normal ease-out transition-discrete';

        $dialogClasses = match($position) {
            'left' => 'inset-y-0 left-0 right-auto w-full min-h-dvh max-h-dvh max-w-md @max-lg:max-w-sm @max-md:max-w-full border-e border-border translate-x-[-100%] open:translate-x-0 starting:open:translate-x-[-100%]',
            'right' => 'inset-y-0 left-auto right-0 w-full min-h-dvh max-h-dvh max-w-md @max-lg:max-w-sm @max-md:max-w-full border-s border-border translate-x-[100%] open:translate-x-0 starting:open:translate-x-[100%]',
            'bottom' => 'inset-x-0 bottom-0 top-auto w-full max-w-none min-h-0 max-h-[80vh] @max-md:max-h-[90vh] border-t border-border rounded-t-2xl translate-y-[100%] open:translate-y-0 starting:open:translate-y-[100%]',
            default => 'inset-y-0 left-auto right-0 w-full min-h-dvh max-h-dvh max-w-md @max-lg:max-w-sm @max-md:max-w-full border-s border-border translate-x-[100%] open:translate-x-0 starting:open:translate-x-[100%]',
        };
    } else {
        $baseClasses = '@container p-0 border-0 bg-transparent transition-all duration-normal ease-out transition-discrete';
        $dialogClasses = 'fixed inset-0 m-auto max-h-[calc(100vh-3rem)] @max-md:max-h-[calc(100vh-2rem)] max-w-lg @max-md:max-w-md @max-xs:max-w-[calc(100vw-2rem)] w-full opacity-0 scale-95 open:opacity-100 open:scale-100 starting:open:opacity-0 starting:open:scale-95 origin-center';
    }

    $contentClasses = 'relative bg-card rounded-lg @max-xs:rounded-md shadow-xl w-full';
@endphp

<dialog
    x-data="modal({
        name: '{{ $modalId }}',
        variant: '{{ $variant }}',
        dismissible: {{ $dismissible ? 'true' : 'false' }},
        closable: {{ $closable ? 'true' : 'false' }}
    })"
    x-ref="dialog"
    @modal-open.window="if ($event.detail.name === '{{ $modalId }}') open()"
    @modal-show.window="if ($event.detail.name === '{{ $modalId }}') open()"
    @modal-close.window="if (!$event.detail.name || $event.detail.name === '{{ $modalId }}') close()"
    @close="$dispatch('modal-closed', { name: '{{ $modalId }}' })"
    @cancel="$dispatch('modal-cancelled', { name: '{{ $modalId }}' })"
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $backdropClasses . ' ' . $dialogClasses]) }}
    :data-open="isOpen"
    data-modal-name="{{ $modalId }}"
    data-variant="{{ $variant }}"
    @if($variant === 'flyout') data-position="{{ $position }}" @endif
    wire:ignore.self
>
    @if($variant === 'flyout')
        @isset($header)
            <div class="z-20 border-b border-border bg-card px-8 py-4 @max-md:px-6 @max-md:py-3 @max-xs:px-4">
                {{ $header }}
            </div>
        @endisset

        <div class="flex-1 overflow-y-auto px-8 py-6 @max-md:px-6 @max-md:py-4 @max-xs:px-4 @max-xs:py-3">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="z-20 border-t border-border bg-card px-8 py-4 @max-md:px-6 @max-md:py-3 @max-xs:px-4">
                {{ $footer }}
            </div>
        @endisset

        @if($closable)
            <div class="absolute top-4 right-4 @max-md:right-6 @max-xs:right-4 z-30">
                <x-pegboard::modal.close />
            </div>
        @endif
    @else
        <div class="{{ $contentClasses }}">
            @isset($header)
                <div class="border-b border-border px-6 py-4 @max-md:px-5 @max-md:py-3 @max-xs:px-4">
                    {{ $header }}
                </div>
            @endisset

            <div class="p-6 @max-md:p-5 @max-xs:p-4">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="border-t border-border px-6 py-4 @max-md:px-5 @max-md:py-3 @max-xs:px-4">
                    {{ $footer }}
                </div>
            @endisset

            @if($closable)
                <div class="absolute top-4 right-4 @max-xs:top-3 @max-xs:right-3 z-10">
                    <x-pegboard::modal.close />
                </div>
            @endif
        </div>
    @endif
</dialog>
