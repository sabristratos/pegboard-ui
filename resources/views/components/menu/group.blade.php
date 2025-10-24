<div class="flex flex-col gap-1 py-1">
    @if($heading)
        <div class="px-3 py-1.5 text-xs font-semibold text-muted-foreground">
            {{ $heading }}
        </div>
    @endif

    {{ $slot }}
</div>
