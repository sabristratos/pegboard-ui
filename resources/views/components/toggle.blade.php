@php
    // Smart name handling - only show name if explicitly set, not from wire:model
    $showName = isset($name);
    if (!isset($name)) {
        $name = $attributes->whereStartsWith('wire:model')->first();
    }

    $baseClasses = 'relative rounded-full transition-colors duration-fast';

    $sizeClasses = match($size) {
        'xs' => 'w-7 h-4 min-w-7 after:h-3 after:w-3 peer-checked:after:translate-x-[12px] rtl:peer-checked:after:-translate-x-[12px]',
        'sm' => 'w-9 h-5 min-w-9 after:h-4 after:w-4 peer-checked:after:translate-x-[16px] rtl:peer-checked:after:-translate-x-[16px]',
        'lg' => 'w-14 h-7 min-w-14 after:h-6 after:w-6 peer-checked:after:translate-x-[28px] rtl:peer-checked:after:-translate-x-[28px]',
        default => 'w-11 h-6 min-w-11 after:h-5 after:w-5 peer-checked:after:translate-x-[20px] rtl:peer-checked:after:-translate-x-[20px]',
    };

    $bgClasses = 'bg-muted';
    $checkedClasses = 'peer-checked:bg-primary';
    $focusClasses = 'peer-focus-visible:outline-none peer-focus-visible:ring-2 peer-focus-visible:ring-ring peer-focus-visible:ring-offset-2';
    $disabledClasses = 'peer-disabled:opacity-disabled peer-disabled:cursor-not-allowed';

    $afterBase = "after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:transition-transform after:duration-fast peer-checked:after:bg-primary-foreground";

    $allClasses = $baseClasses . ' ' . $sizeClasses . ' ' . $bgClasses . ' ' . $checkedClasses . ' ' . $focusClasses . ' ' . $disabledClasses . ' ' . $afterBase;
@endphp

<label class="inline-flex items-center {{ $disabled ? 'cursor-not-allowed' : 'cursor-pointer' }}">
    <input
        type="checkbox"
        @if($checked) checked @endif
        @if($disabled) disabled @endif
        @if($showName) name="{{ $name }}" @endif
        {{ $attributes }}
        class="peer opacity-0 h-0 w-0 pointer-events-none"
    />

    <div class="{{ $allClasses }}" aria-hidden="true"></div>
</label>
