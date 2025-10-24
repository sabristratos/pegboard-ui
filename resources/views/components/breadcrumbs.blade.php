<nav aria-label="Breadcrumbs" {{ $attributes->merge(['class' => '@container']) }}>
    <ol class="flex items-center gap-2 @max-xs:gap-1 text-sm @max-xs:text-xs">
        {{ $slot }}
    </ol>
</nav>
