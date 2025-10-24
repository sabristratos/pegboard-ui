<summary
    {{ $attributes->merge(['class' => 'cursor-pointer block p-4 list-none [&::-webkit-details-marker]:hidden']) }}
    data-slot="accordion-heading"
>
    <div class="flex items-center justify-between gap-3 w-full">
        <div class="flex-1">
            {{ $slot }}
        </div>
        <div class="transition-transform duration-slower ease-out group-open:rotate-180">
            <x-pegboard::icon name="chevron-down" class="h-5 w-5" />
        </div>
    </div>
</summary>
