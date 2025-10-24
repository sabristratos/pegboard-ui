@php
    $hasContent = !empty($text) || !empty(trim($slot));

    $variantClasses = match($variant) {
        'subtle' => 'border-muted',
        default => 'border-border',
    };

    if ($vertical) {
        $separatorClasses = 'inline-block self-stretch w-px border-l ' . $variantClasses;
        $containerClasses = $hasContent ? 'flex items-center gap-3' : '';
    } else {
        $separatorClasses = 'w-full border-t ' . $variantClasses;
        $containerClasses = $hasContent ? 'flex items-center gap-3 w-full' : '';
    }

    $contentClasses = 'text-sm text-muted-foreground whitespace-nowrap flex-shrink-0';
@endphp

@if($hasContent)
    <div {{ $attributes->merge(['class' => $containerClasses]) }}>
        <div class="{{ $separatorClasses }}"></div>
        <span class="{{ $contentClasses }}">
            @if($text)
                {{ $text }}
            @else
                {{ $slot }}
            @endif
        </span>
        <div class="{{ $separatorClasses }}"></div>
    </div>
@else
    @if($vertical)
        <div {{ $attributes->merge(['class' => $separatorClasses]) }}></div>
    @else
        <hr {{ $attributes->merge(['class' => $separatorClasses]) }} />
    @endif
@endif
