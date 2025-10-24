@props([
    'position' => 'left',
    'open' => false,
])

@php
$baseClasses = implode(' ', [
    'peer',
    'fixed inset-y-0 z-40 flex flex-col',
    'bg-sidebar',
    'border-r border-sidebar-border',
    'w-64',
    $position === 'left' ? 'left-0' : 'right-0',
    'transition-all duration-normal ease-in-out',
    '-translate-x-full md:translate-x-0',
    'data-[open=true]:translate-x-0',
    'starting:opacity-0 starting:-translate-x-full',
]);

$mergedClasses = $attributes->merge(['class' => $baseClasses])->get('class');
@endphp

<aside
    data-sidebar
    data-open="{{ $open ? 'true' : 'false' }}"
    data-position="{{ $position }}"
    x-data="pegboardSidebar"
    x-ref="sidebar"
    role="navigation"
    aria-label="Main navigation"
    {{ $attributes->only('class')->merge(['class' => $mergedClasses]) }}
>
    @if(isset($header))
        <x-pegboard::sidebar.header>
            {{ $header }}
        </x-pegboard::sidebar.header>
    @endif

    {{ $slot }}

    @if(isset($footer))
        <x-pegboard::sidebar.footer>
            {{ $footer }}
        </x-pegboard::sidebar.footer>
    @endif
</aside>

<div
    @click="closeMobile"
    class="fixed inset-0 z-30 bg-foreground/50 opacity-0 pointer-events-none md:hidden transition-opacity duration-fast peer-data-[open=true]:opacity-100 peer-data-[open=true]:pointer-events-auto"
    aria-hidden="true"
></div>
