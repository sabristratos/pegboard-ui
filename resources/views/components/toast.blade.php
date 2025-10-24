@props(['position' => 'bottom end'])

@php
$positionClasses = match($position) {
    'top start' => 'top-4 left-4 sm:top-6 sm:left-6',
    'top center' => 'top-4 left-1/2 -translate-x-1/2 sm:top-6',
    'top end' => 'top-4 right-4 sm:top-6 sm:right-6',
    'bottom start' => 'bottom-4 left-4 sm:bottom-6 sm:left-6',
    'bottom center' => 'bottom-4 left-1/2 -translate-x-1/2 sm:bottom-6',
    'bottom end' => 'bottom-4 right-4 sm:bottom-6 sm:right-6',
    default => 'bottom-4 right-4 sm:bottom-6 sm:right-6',
};
@endphp

<div
    x-data="pegboardToast({ position: '{{ $position }}' })"
    x-init="
        @if(session()->has('pegboard:toast'))
            @foreach(session('pegboard:toast', []) as $flashedToast)
                $store.toasts.add(@js($flashedToast));
            @endforeach
        @endif
    "
    {{ $attributes->merge(['class' => 'fixed z-[99] w-full sm:max-w-xs ' . $positionClasses]) }}
    data-position="{{ $position }}"
>
    <div
        x-ref="toastStack"
        @mouseenter="isHovered = true; stackToasts(); $store.toasts.items.forEach(t => $store.toasts.pause(t.id))"
        @mouseleave="isHovered = false; stackToasts(); $store.toasts.items.forEach(t => $store.toasts.resume(t.id))"
        class="relative"
    >
        <template x-for="(toast, index) in $store.toasts.items" :key="toast.id">
        <div
            :id="'toast-' + toast.id"
            :data-toast-id="toast.id"
            :data-variant="toast.variant"
            :data-state="toast.visible ? 'visible' : 'hidden'"
            :data-closable="true"
            :data-has-heading="toast.heading ? 'true' : 'false'"
            x-show="toast.visible"
            x-init="
                $el.setAttribute('data-state', 'entering');
                if('{{ $position }}'.includes('bottom')){
                    $el.classList.add('translate-y-full');
                } else {
                    $el.classList.add('-translate-y-full');
                }
                setTimeout(() => {
                    $el.classList.remove('translate-y-full', '-translate-y-full');
                    $el.setAttribute('data-state', 'visible');
                    stackToasts();
                }, 50);
            "
            class="
                absolute w-full rounded-lg border shadow-xl p-4 flex items-start gap-3
                transition-all duration-300 ease-out select-none
                data-[variant=default]:bg-card data-[variant=default]:border-border
                data-[variant=success]:bg-success-subtle data-[variant=success]:border-success/30
                data-[variant=warning]:bg-warning-subtle data-[variant=warning]:border-warning/30
                data-[variant=danger]:bg-danger-subtle data-[variant=danger]:border-destructive/30
            "
            :style="index === 0 ? (position.includes('bottom') ? 'bottom: 0' : 'top: 0') : ''"
            role="alert"
        >
            <div class="flex-shrink-0">
                <template x-if="toast.variant === 'success'">
                    <x-pegboard::icon name="check-circle" class="w-5 h-5 text-success" />
                </template>
                <template x-if="toast.variant === 'warning'">
                    <x-pegboard::icon name="exclamation-triangle" class="w-5 h-5 text-warning" />
                </template>
                <template x-if="toast.variant === 'danger'">
                    <x-pegboard::icon name="exclamation-circle" class="w-5 h-5 text-destructive" />
                </template>
            </div>

            <div class="flex-1 min-w-0">
                <div
                    x-show="toast.heading"
                    x-text="toast.heading"
                    class="font-semibold text-foreground mb-1"
                ></div>
                <div
                    x-text="toast.text"
                    class="text-sm text-foreground"
                    :class="{ 'mb-2': toast.action }"
                ></div>

                <template x-if="toast.action">
                    <button
                        type="button"
                        @click="toast.action.onClick(); $store.toasts.burn(toast.id)"
                        class="text-sm font-medium underline hover:no-underline transition-all duration-fast"
                        :class="{
                            'text-success hover:text-success/80': toast.variant === 'success',
                            'text-warning hover:text-warning/80': toast.variant === 'warning',
                            'text-destructive hover:text-destructive/80': toast.variant === 'danger',
                            'text-primary hover:text-primary/80': toast.variant === 'default'
                        }"
                        x-text="toast.action.label"
                    ></button>
                </template>
            </div>

            <button
                type="button"
                @click="$store.toasts.burn(toast.id)"
                x-show="index === 0 || isHovered"
                x-transition:enter="transition-opacity duration-fast"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-fast"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex-shrink-0 text-muted-foreground hover:text-foreground transition-colors duration-fast rounded p-1 hover:bg-muted/50"
                aria-label="Dismiss"
            >
                <x-pegboard::icon name="x-mark" class="w-4 h-4" />
            </button>

            <template x-if="toast.duration > 0">
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-border/30 rounded-b-lg overflow-hidden">
                    <div
                        class="h-full transition-all origin-left"
                        x-bind:class="{
                            'bg-success': toast.variant === 'success',
                            'bg-warning': toast.variant === 'warning',
                            'bg-destructive': toast.variant === 'danger',
                            'bg-primary': toast.variant === 'default'
                        }"
                        x-init="
                            $nextTick(() => {
                                $el.style.width = '100%';
                                $el.style.transitionDuration = '0ms';
                                requestAnimationFrame(() => {
                                    $el.style.transitionDuration = toast.duration + 'ms';
                                    $el.style.width = '0%';
                                });
                            })
                        "
                        @mouseenter.window="if (!toast.paused) {
                            const currentWidth = parseFloat(getComputedStyle($el).width) / parseFloat(getComputedStyle($el.parentElement).width) * 100;
                            $el.style.width = currentWidth + '%';
                            $el.style.transitionDuration = '0ms';
                        }"
                        @mouseleave.window="if (toast.paused) {
                            requestAnimationFrame(() => {
                                $el.style.transitionDuration = toast.remainingDuration + 'ms';
                                $el.style.width = '0%';
                            });
                        }"
                    ></div>
                </div>
            </template>
        </div>
    </template>
    </div>
</div>
