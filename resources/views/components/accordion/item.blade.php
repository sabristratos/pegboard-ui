@if($heading !== null)
    <details
        {{ $attributes->merge(['class' => 'group overflow-hidden rounded-lg border border-border bg-card [&::details-content]:overflow-hidden [&::details-content]:grid [&::details-content]:grid-rows-[0fr] [&::details-content]:opacity-0 [&::details-content]:transition-[grid-template-rows,opacity,content-visibility] [&::details-content]:duration-normal [&::details-content]:ease-in-out [&::details-content]:transition-behavior-[allow-discrete] open:[&::details-content]:grid-rows-[1fr] open:[&::details-content]:opacity-100']) }}
        @if($open) open @endif
    >
        <x-pegboard::accordion.heading class="font-medium text-foreground hover:bg-muted/50 transition-colors duration-fast">
            {{ $heading }}
        </x-pegboard::accordion.heading>
        <x-pegboard::accordion.content class="text-muted-foreground">
            {{ $slot }}
        </x-pegboard::accordion.content>
    </details>
@else
    <details
        {{ $attributes->merge(['class' => 'group [&::details-content]:overflow-hidden [&::details-content]:grid [&::details-content]:grid-rows-[0fr] [&::details-content]:opacity-0 [&::details-content]:transition-[grid-template-rows,opacity,content-visibility] [&::details-content]:duration-normal [&::details-content]:ease-in-out [&::details-content]:transition-behavior-[allow-discrete] open:[&::details-content]:grid-rows-[1fr] open:[&::details-content]:opacity-100']) }}
        @if($open) open @endif
    >
        {{ $slot }}
    </details>
@endif
