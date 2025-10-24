@props(['value' => 0, 'max' => 5, 'size' => 'md', 'icon' => 'star', 'variant' => 'warning', 'showValue' => false])

@php
$value = (float) $value;
$max = (int) $max;

$sizeClasses = match($size) {
    'sm' => 'w-4 h-4',
    'lg' => 'w-8 h-8',
    default => 'w-6 h-6',
};

$variantClasses = match($variant) {
    'primary' => 'text-primary',
    'danger' => 'text-destructive',
    'success' => 'text-success',
    default => 'text-warning',
};

$wrapperClasses = $attributes->get('class', '');
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex flex-col items-center gap-2 ' . $wrapperClasses]) }}>
    @if($showValue)
        <div class="text-sm font-medium text-foreground">
            {{ number_format($value, 1) }} / {{ $max }}
        </div>
    @endif

    <div class="inline-flex items-center">
        @for($i = 1; $i <= $max; $i++)
            <div class="relative inline-flex px-0.5 {{ $sizeClasses }}">
                @if($i <= floor($value))
                    <x-pegboard::icon
                        :name="$icon"
                        variant="solid"
                        :class="$sizeClasses . ' ' . $variantClasses . ' fill-current'"
                    />
                @elseif($i == ceil($value) && $value - floor($value) >= 0.5)
                    <div class="relative {{ $sizeClasses }}">
                        <x-pegboard::icon
                            :name="$icon"
                            variant="outline"
                            :class="$sizeClasses . ' text-muted-foreground absolute inset-0'"
                        />
                        <div class="absolute inset-0 overflow-hidden" style="width: 50%;">
                            <x-pegboard::icon
                                :name="$icon"
                                variant="solid"
                                :class="$sizeClasses . ' ' . $variantClasses . ' fill-current'"
                            />
                        </div>
                    </div>
                @else
                    <x-pegboard::icon
                        :name="$icon"
                        variant="outline"
                        :class="$sizeClasses . ' text-muted-foreground'"
                    />
                @endif
            </div>
        @endfor
    </div>
</div>
