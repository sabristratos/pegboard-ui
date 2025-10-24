@php
    // All Tailwind classes in one clean block
    $classes = '
        @container relative items-center

        data-[variant=default]:data-[orientation=horizontal]:inline-flex
        data-[variant=default]:data-[orientation=horizontal]:flex-row
        data-[variant=default]:data-[orientation=horizontal]:border-b
        data-[variant=default]:data-[orientation=horizontal]:border-border
        data-[variant=default]:data-[orientation=vertical]:inline-flex
        data-[variant=default]:data-[orientation=vertical]:flex-col
        data-[variant=default]:data-[orientation=vertical]:min-w-48

        data-[variant=segmented]:data-[orientation=horizontal]:flex
        data-[variant=segmented]:data-[orientation=horizontal]:flex-row
        data-[variant=segmented]:data-[orientation=horizontal]:p-1
        data-[variant=segmented]:data-[orientation=horizontal]:bg-card
        data-[variant=segmented]:data-[orientation=horizontal]:border
        data-[variant=segmented]:data-[orientation=horizontal]:border-border
        data-[variant=segmented]:data-[orientation=horizontal]:rounded-lg
        data-[variant=segmented]:data-[orientation=horizontal]:@max-md:inline-flex
        data-[variant=segmented]:data-[orientation=horizontal]:@max-md:p-0
        data-[variant=segmented]:data-[orientation=horizontal]:@max-md:bg-transparent
        data-[variant=segmented]:data-[orientation=horizontal]:@max-md:border-0
        data-[variant=segmented]:data-[orientation=horizontal]:@max-md:border-b
        data-[variant=segmented]:data-[orientation=vertical]:flex
        data-[variant=segmented]:data-[orientation=vertical]:flex-col
        data-[variant=segmented]:data-[orientation=vertical]:p-1
        data-[variant=segmented]:data-[orientation=vertical]:bg-card
        data-[variant=segmented]:data-[orientation=vertical]:border
        data-[variant=segmented]:data-[orientation=vertical]:border-border
        data-[variant=segmented]:data-[orientation=vertical]:rounded-lg
        data-[variant=segmented]:data-[orientation=vertical]:min-w-48

        data-[variant=pills]:data-[orientation=horizontal]:inline-flex
        data-[variant=pills]:data-[orientation=horizontal]:flex-row
        data-[variant=pills]:data-[orientation=horizontal]:gap-1
        data-[variant=pills]:data-[orientation=vertical]:inline-flex
        data-[variant=pills]:data-[orientation=vertical]:flex-col
        data-[variant=pills]:data-[orientation=vertical]:gap-1
        data-[variant=pills]:data-[orientation=vertical]:min-w-48

        data-[scrollable=true]:data-[orientation=horizontal]:overflow-x-auto
        data-[scrollable=true]:data-[orientation=vertical]:overflow-y-auto
        data-[orientation=horizontal]:@max-md:overflow-x-auto
        data-[scrollable=true]:data-[scrollbar=hide]:scrollbar-none
        data-[scrollable=true]:data-[scrollbar=show]:scrollbar-thin
        data-[scrollable=true]:data-[scrollbar=true]:scrollbar-thin
        data-[orientation=horizontal]:@max-md:scrollbar-thin

        data-[padded=true]:data-[orientation=horizontal]:px-4
        data-[padded=true]:data-[orientation=horizontal]:@max-xs:px-2
        data-[padded=true]:data-[orientation=vertical]:py-4
        data-[padded=true]:data-[orientation=vertical]:@max-xs:py-2

        data-[fade=true]:relative
    ';
@endphp

<div
    data-pegboard-tabs
    data-variant="{{ $variant }}"
    data-orientation="{{ $orientation }}"
    @if($scrollable) data-scrollable="true" @endif
    @if($scrollableScrollbar) data-scrollbar="{{ $scrollableScrollbar }}" @endif
    @if($scrollableFade) data-fade="true" @endif
    @if($padded) data-padded="true" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}

    @if($scrollable && $scrollableFade)
        @if(isset($fadeOverlays))
            {{ $fadeOverlays }}
        @else
            @if($orientation === 'vertical')
                <div
                    :data-visible="showLeftFade"
                    class="absolute left-0 top-0 w-full h-12 bg-gradient-to-b from-card to-transparent pointer-events-none opacity-0 data-[visible=true]:opacity-100 transition-opacity duration-fast"
                ></div>

                <div
                    :data-visible="showRightFade"
                    class="absolute left-0 bottom-0 w-full h-12 bg-gradient-to-t from-card to-transparent pointer-events-none opacity-0 data-[visible=true]:opacity-100 transition-opacity duration-fast"
                ></div>
            @else
                <div
                    :data-visible="showLeftFade"
                    class="absolute left-0 top-0 h-full w-12 bg-gradient-to-r from-card to-transparent pointer-events-none opacity-0 data-[visible=true]:opacity-100 transition-opacity duration-fast"
                ></div>

                <div
                    :data-visible="showRightFade"
                    class="absolute right-0 top-0 h-full w-12 bg-gradient-to-l from-card to-transparent pointer-events-none opacity-0 data-[visible=true]:opacity-100 transition-opacity duration-fast"
                ></div>
            @endif
        @endif
    @endif
</div>
