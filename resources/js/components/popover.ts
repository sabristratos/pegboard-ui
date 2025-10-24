import type { Alpine, AlpineData } from '../types/alpine';
import type { PopoverOptions, PopoverState } from '../types/components';

export function popover(Alpine: Alpine): void {
    Alpine.data('popover', (options: PopoverOptions = {}): AlpineData<PopoverState> => ({
        isOpen: false,
        trigger: options.trigger ?? 'click',
        placement: options.placement ?? 'bottom',
        offset: options.offset ?? 8,
        closeTimeout: null as ReturnType<typeof setTimeout> | null,

        init() {
            this.$nextTick?.(() => {
                const popover = this.$refs?.popover as HTMLElement;

                if (!popover) {
                    return;
                }

                popover.addEventListener('toggle', (event: Event) => {
                    const toggleEvent = event as ToggleEvent;
                    this.isOpen = toggleEvent.newState === 'open';
                });

                popover.addEventListener('keydown', (event: KeyboardEvent) => {
                    if (event.key === 'Escape') {
                        this.close();
                    }
                });
            });
        },

        open() {
            if (this.closeTimeout) {
                clearTimeout(this.closeTimeout);
                this.closeTimeout = null;
            }

            const popover = this.$refs?.popover as HTMLElement;

            if (popover && !this.isOpen) {
                popover.showPopover();
                this.isOpen = true;
            }
        },

        close() {
            const delay = this.trigger === 'hover' ? 200 : 0;

            if (this.closeTimeout) {
                clearTimeout(this.closeTimeout);
            }

            this.closeTimeout = setTimeout(() => {
                const popover = this.$refs?.popover as HTMLElement;

                if (popover && this.isOpen) {
                    popover.hidePopover();
                    this.isOpen = false;
                }

                this.closeTimeout = null;
            }, delay);
        },

        toggle() {
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        },

        keepOpen() {
            if (this.closeTimeout) {
                clearTimeout(this.closeTimeout);
                this.closeTimeout = null;
            }
        },
    }));
}

interface ToggleEvent extends Event {
    newState: 'open' | 'closed';
    oldState: 'open' | 'closed';
}
