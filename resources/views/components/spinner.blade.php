@props(['variant', 'label', 'sizeClass'])

@php
    $mergedClasses = trim($sizeClass . ' ' . $attributes->get('class', ''));
@endphp

<div
    aria-label="{{ $label }}"
    class="relative inline-flex items-center justify-center"
>
    @if ($variant === 'default')
        <div class="relative flex {{ $mergedClasses }}">
            <i class="absolute w-full h-full rounded-full border-4 border-b-current border-solid border-t-transparent border-l-transparent border-r-transparent animate-spin"></i>
            <i class="absolute w-full h-full rounded-full border-4 border-b-current opacity-50 border-dotted border-t-transparent border-l-transparent border-r-transparent animate-spin [animation-duration:1.5s]"></i>
        </div>

    @elseif ($variant === 'pulse')
        <div class="rounded-full bg-current {{ $mergedClasses }} animate-pulse"></div>

    @elseif ($variant === 'wave')
        <div class="flex items-center justify-center gap-1 {{ $mergedClasses }}">
            <span class="size-2 rounded-full bg-current animate-bounce [animation-delay:0ms]"></span>
            <span class="size-2 rounded-full bg-current animate-bounce [animation-delay:150ms]"></span>
            <span class="size-2 rounded-full bg-current animate-bounce [animation-delay:300ms]"></span>
        </div>

    @elseif ($variant === 'ping')
        <div class="relative flex {{ $mergedClasses }}">
            <span class="absolute inline-flex h-full w-full rounded-full bg-current opacity-75 animate-ping"></span>
            <span class="relative inline-flex rounded-full h-full w-full bg-current"></span>
        </div>
    @endif
</div>
