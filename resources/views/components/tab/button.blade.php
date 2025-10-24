@php
    // Icon variant defaults to mini for better sizing
    $iconVariant = $iconVariant ?? 'mini';

    // Base classes + all Tailwind variant classes
    $classes = '
        relative inline-flex items-center justify-center whitespace-nowrap font-medium
        transition-all duration-fast cursor-pointer text-muted-foreground
        focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2
        disabled:opacity-50 disabled:cursor-not-allowed

        data-[orientation=vertical]:w-full data-[orientation=vertical]:justify-start

        data-[variant=default]:data-[orientation=horizontal]:border-b-2
        data-[variant=default]:data-[orientation=horizontal]:-mb-px
        data-[variant=default]:data-[orientation=horizontal]:border-transparent
        data-[variant=default]:data-[orientation=vertical]:border-l-2
        data-[variant=default]:data-[orientation=vertical]:border-transparent
        data-[variant=default]:data-[size=sm]:px-3 data-[variant=default]:data-[size=sm]:py-1.5
        data-[variant=default]:data-[size=sm]:text-sm
        data-[variant=default]:data-[size=base]:px-4 data-[variant=default]:data-[size=base]:py-2
        data-[variant=default]:data-[size=lg]:px-5 data-[variant=default]:data-[size=lg]:py-2.5
        data-[variant=default]:data-[size=lg]:text-lg
        data-[variant=default]:data-[orientation=horizontal]:data-[active=true]:border-b-primary
        data-[variant=default]:data-[orientation=vertical]:data-[active=true]:border-l-primary
        data-[variant=default]:data-[active=true]:text-foreground
        data-[variant=default]:data-[active=false]:hover:text-foreground
        data-[variant=default]:data-[active=false]:hover:border-border

        data-[variant=segmented]:rounded-md data-[variant=segmented]:flex-1
        data-[variant=segmented]:data-[size=sm]:px-3 data-[variant=segmented]:data-[size=sm]:py-1
        data-[variant=segmented]:data-[size=sm]:text-sm
        data-[variant=segmented]:data-[size=base]:px-4 data-[variant=segmented]:data-[size=base]:py-1.5
        data-[variant=segmented]:data-[size=lg]:px-5 data-[variant=segmented]:data-[size=lg]:py-2
        data-[variant=segmented]:data-[size=lg]:text-lg
        data-[variant=segmented]:data-[active=true]:bg-muted/30
        data-[variant=segmented]:data-[active=true]:text-foreground
        data-[variant=segmented]:data-[active=false]:hover:text-foreground

        data-[variant=pills]:rounded-full data-[variant=pills]:border data-[variant=pills]:border-transparent
        data-[variant=pills]:data-[size=sm]:px-2.5 data-[variant=pills]:data-[size=sm]:py-1
        data-[variant=pills]:data-[size=sm]:text-sm
        data-[variant=pills]:data-[size=base]:px-3 data-[variant=pills]:data-[size=base]:py-1.5
        data-[variant=pills]:data-[size=lg]:px-4 data-[variant=pills]:data-[size=lg]:py-2
        data-[variant=pills]:data-[size=lg]:text-lg
        data-[variant=pills]:data-[active=true]:bg-card
        data-[variant=pills]:data-[active=true]:text-foreground
        data-[variant=pills]:data-[active=true]:shadow-md
        data-[variant=pills]:data-[active=true]:border-primary/20
        data-[variant=pills]:data-[active=false]:hover:text-foreground
        data-[variant=pills]:data-[active=false]:hover:bg-muted/30

        data-[accent=true]:data-[active=true]:text-primary
        data-[action=true]:hover:text-primary
    ';
@endphp

<button
    type="button"
    role="tab"
    :aria-selected="isActive('{{ $name }}')"
    :tabindex="isActive('{{ $name }}') ? 0 : -1"
    :data-variant="variant"
    :data-size="size"
    :data-orientation="orientation"
    :data-active="isActive('{{ $name }}')"
    @if($accent) data-accent="true" @endif
    @if($action) data-action="true" @endif
    data-tab-name="{{ $name }}"
    data-pegboard-tab
    @click="@if(!$disabled && !$action) selectTab('{{ $name }}') @endif"
    @if($disabled) disabled @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    @if($loading)
        @php
            $isIconOnly = $slot->isEmpty();
            $spinnerClasses = 'h-4 w-4 animate-spin';
            if (!$isIconOnly) {
                $spinnerClasses .= ' mr-2';
            }
        @endphp
        <svg class="{{ $spinnerClasses }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($icon)
        @php
            // Check if this is an icon-only tab (no text content)
            $isIconOnly = $slot->isEmpty();
            $iconClasses = 'h-4 w-4';

            // Add margin only if there's text content
            if (!$isIconOnly) {
                $iconClasses .= ' mr-2';
            }
        @endphp
        <x-pegboard::icon
            :name="$icon"
            :variant="$iconVariant"
            :class="$iconClasses"
        />
    @endif

    {{ $slot }}

    @if($badge !== null)
        @php
            $badgeClasses = match($badgeVariant) {
                'primary' => 'bg-primary/10 text-primary border-primary/20',
                'success' => 'bg-success/10 text-success border-success/20',
                'warning' => 'bg-warning/10 text-warning border-warning/20',
                'danger' => 'bg-destructive/10 text-destructive border-destructive/20',
                default => 'bg-muted text-muted-foreground border-border',
            };
        @endphp
        <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 text-xs font-medium rounded-full border {{ $badgeClasses }} ml-1.5">
            {{ $badge }}
        </span>
    @endif

    @if($iconTrailing)
        <x-pegboard::icon
            :name="$iconTrailing"
            :variant="$iconVariant"
            class="h-4 w-4 ml-2"
        />
    @endif
</button>
