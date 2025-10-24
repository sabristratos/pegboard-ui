<div {{ $attributes->merge(['class' => '']) }} data-slot="accordion-content">
    <div class="min-h-0 px-4 pb-4">
        {{ $slot }}
    </div>
</div>
