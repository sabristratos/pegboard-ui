@props(['name' => ''])

<div
    class="contents"
    x-data=""
    @click="$el.querySelector('button[disabled]') || $dispatch('modal-open', { name: '{{ $name }}' })"
    {{ $attributes }}
    data-modal-trigger
>
    {{ $slot }}
</div>
