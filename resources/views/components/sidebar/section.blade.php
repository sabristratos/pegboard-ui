@props([
    'label' => null,
])

<div class="space-y-1 last:[&>[data-sidebar-divider]]:hidden" data-sidebar-section>
    @if ($label)
        <h3 class="px-3 text-xs font-semibold uppercase tracking-wider text-muted-foreground">
            {{ $label }}
        </h3>
    @endif

    {{ $slot }}

    <div data-sidebar-divider class="border-t border-sidebar-border pt-4 mt-4"></div>
</div>
