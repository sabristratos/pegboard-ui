@php
    $baseClasses = "
        inline-flex items-center justify-center
        h-8 w-8
        rounded-md
        text-muted-foreground
        hover:text-destructive hover:bg-destructive/10
        transition-colors duration-fast
        cursor-pointer
    ";
@endphp

<button
    type="button"
    data-pegboard-file-item-remove
    {{ $attributes->merge(['class' => $baseClasses]) }}
>
    <x-pegboard::icon name="x-mark" variant="mini" class="h-4 w-4" />
    <span class="sr-only">Remove file</span>
</button>
