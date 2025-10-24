@php
    $baseClasses = 'border border-border rounded-lg p-6';
@endphp

<fieldset data-slot="fieldset" {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if($legend)
        <x-pegboard::legend class="mb-2">
            {{ $legend }}
        </x-pegboard::legend>
    @endif

    @if($description)
        <x-pegboard::description class="mb-6">
            {{ $description }}
        </x-pegboard::description>
    @endif

    <div class="space-y-6">
        {{ $slot }}
    </div>
</fieldset>
