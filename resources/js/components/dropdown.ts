import type { Alpine, AlpineData } from '../types/alpine';
import type { DropdownOptions, DropdownState, PopoverPlacement } from '../types/components';

export function dropdown(Alpine: Alpine): void {
    Alpine.data('dropdown', (options: DropdownOptions = {}): AlpineData<DropdownState> => ({
        open: false,
        position: options.position ?? 'bottom',
        align: options.align ?? 'start',
        offset: options.offset ?? 0,
        gap: options.gap ?? 4,
        placement: 'bottom' as PopoverPlacement,

        init() {
            this.placement = this.getPlacement();
            const menu = this.$refs?.menu as HTMLElement;

            if (!menu) {
                return;
            }

            menu.addEventListener('toggle', (event: Event) => {
                const toggleEvent = event as ToggleEvent;
                this.open = toggleEvent.newState === 'open';
            });

            this.$watch?.('open', (isOpen: boolean) => {
                if (!menu?.isConnected) {
                    return;
                }

                try {
                    if (isOpen) {
                        menu.showPopover();
                    } else {
                        menu.hidePopover();
                    }
                } catch (error) {
                    console.error('[Pegboard Dropdown] Popover error:', error);
                }
            });
        },

        toggle() {
            this.open = !this.open;
        },

        close() {
            this.open = false;
        },

        getPlacement(): PopoverPlacement {
            if (this.align === 'center') {
                return this.position as PopoverPlacement;
            }

            return `${this.position}-${this.align}` as PopoverPlacement;
        },
    }));
}

interface ToggleEvent extends Event {
    newState: 'open' | 'closed';
    oldState: 'open' | 'closed';
}
