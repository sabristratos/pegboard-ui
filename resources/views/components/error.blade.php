@php
    $baseClasses = 'text-sm text-destructive';

    $errorBag = $errors->getBag($bag);

    $hasError = $name && $errorBag->has($name);

    $errorMessage = $message ?? ($hasError ? $errorBag->first($name) : null);
@endphp

@if($hasError || $message)
    <p data-slot="error" {{ $attributes->merge(['class' => $baseClasses]) }}>
        @if($slot->isEmpty())
            {{ $errorMessage }}
        @else
            {{ $slot }}
        @endif
    </p>
@endif
