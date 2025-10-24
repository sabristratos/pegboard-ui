import type { Alpine, AlpineData } from '../types/alpine';
import type { MenuSubmenuOptions, MenuSubmenuState, MenuState } from '../types/components';
import { createMenuNavigation } from '../types/menu';

export function submenu(Alpine: Alpine): void {
    Alpine.data('submenu', (options: MenuSubmenuOptions = {}): AlpineData<MenuSubmenuState> => ({
        ...createMenuNavigation(),

        open: false,
        keepOpen: options.keepOpen ?? false,
        parentMenu: null as MenuState | null,
        closeTimeout: null as ReturnType<typeof setTimeout> | null,
        isTouchDevice: false,

        init() {
            this.isTouchDevice = window.matchMedia('(pointer: coarse)').matches;

            const parentMenuElement = this.$el?.closest('[x-data*="menu"]');

            if (parentMenuElement instanceof HTMLElement) {
                this.parentMenu = Alpine.$data(parentMenuElement) as MenuState;

                this.parentMenu.registerItem({
                    element: this.$el as HTMLElement,
                    disabled: false,
                    isSubmenu: true,
                });
            }

            this.$watch?.('open', (isOpen: boolean) => {
                const submenuElement = this.$refs?.submenu as HTMLElement;

                if (!submenuElement?.isConnected) return;

                try {
                    if (isOpen) {
                        submenuElement.showPopover();
                    } else {
                        submenuElement.hidePopover();
                        this.resetActiveIndex();
                    }
                } catch (error) {
                }
            });
        },

        toggle() {
            this.open = !this.open;
        },

        openSubmenu() {
            if (this.isTouchDevice) {
                return;
            }

            if (this.closeTimeout) {
                clearTimeout(this.closeTimeout);
                this.closeTimeout = null;
            }
            this.open = true;
        },

        close() {
            this.open = false;

            const trigger = this.$refs?.trigger as HTMLElement;
            trigger?.focus();
        },

        closeDelayed() {
            if (this.isTouchDevice) {
                return;
            }

            this.closeTimeout = setTimeout(() => {
                this.open = false;
                this.closeTimeout = null;
            }, 100);
        },

        cancelClose() {
            if (this.closeTimeout) {
                clearTimeout(this.closeTimeout);
                this.closeTimeout = null;
            }
        },

        handleTriggerClick() {
            if (this.isTouchDevice) {
                this.toggle();
            } else {
                if (!this.open) {
                    this.open = true;
                }
            }
        },

        navigateRight() {
            if (this.activeIndex >= 0 && this.activeIndex < this.items.length) {
                const item = this.items[this.activeIndex];

                if (item.isSubmenu) {
                    const submenuData = Alpine.$data(item.element) as MenuSubmenuState;
                    submenuData.openSubmenu();
                }
            }
        },

        navigateLeft() {
            this.close();
        },

        selectActive() {
            if (this.activeIndex >= 0 && this.activeIndex < this.items.length) {
                const item = this.items[this.activeIndex];

                if (!item.disabled) {
                    if (item.isSubmenu) {
                        const submenuData = Alpine.$data(item.element) as MenuSubmenuState;
                        submenuData.openSubmenu();
                    } else {
                        item.element.click();

                        const itemKeepOpen = item.element.hasAttribute('data-keep-open');
                        if (!this.keepOpen && !itemKeepOpen) {
                            this.close();

                            if (this.parentMenu) {
                                this.parentMenu.close();
                            }
                        }
                    }
                }
            }
        },
    }));
}
