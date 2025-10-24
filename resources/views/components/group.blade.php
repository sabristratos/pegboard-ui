@php
    $baseClasses = 'inline-flex';

    $orientationClasses = match($orientation) {
        'vertical' => 'flex-col [&>[data-pegboard-group-item]]:rounded-none [&>[data-pegboard-group-item]_[data-pegboard-control]]:rounded-none [&>[data-pegboard-group-item]:first-child]:rounded-t-md [&>[data-pegboard-group-item]:first-child_[data-pegboard-control]]:rounded-t-md [&>[data-pegboard-group-item]:last-child]:rounded-b-md [&>[data-pegboard-group-item]:last-child_[data-pegboard-control]]:rounded-b-md [&>[data-pegboard-group-item]:not(:first-child)]:-mt-px [&>[data-pegboard-group-item]:focus-within]:relative [&>[data-pegboard-group-item]:focus-within]:z-10',
        default => 'flex-row [&>[data-pegboard-group-item]]:rounded-none [&>[data-pegboard-group-item]_[data-pegboard-control]]:rounded-none [&>[data-pegboard-group-item]:first-child]:rounded-l-md [&>[data-pegboard-group-item]:first-child_[data-pegboard-control]]:rounded-l-md [&>[data-pegboard-group-item]:last-child]:rounded-r-md [&>[data-pegboard-group-item]:last-child_[data-pegboard-control]]:rounded-r-md [&>[data-pegboard-group-item]:not(:first-child)]:-ml-px [&>[data-pegboard-group-item]:focus-within]:relative [&>[data-pegboard-group-item]:focus-within]:z-10',
    };
@endphp

<div {{ $attributes->merge(['class' => "$baseClasses $orientationClasses"]) }}>
    {{ $slot }}
</div>
