@php
    $baseClasses = 'inline-flex items-center justify-center p-2 rounded-lg transition-colors duration-fast outline-none hover:bg-muted text-muted-foreground hover:text-foreground';
@endphp

<button
    type="button"
    @click="close()"
    aria-label="Close modal"
    {{ $attributes->merge(['class' => $baseClasses]) }}
>
    @if($slot->isEmpty())
        <x-pegboard::icon name="x-mark" variant="mini" class="h-5 w-5" />
    @else
        {{ $slot }}
    @endif
</button>
