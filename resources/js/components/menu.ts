import type { Alpine, AlpineData } from '../types/alpine';
import type { MenuOptions, MenuState, MenuItem } from '../types/components';
import { createMenuNavigation } from '../types/menu';

export function menu(Alpine: Alpine): void {
    Alpine.data('menu', (options: MenuOptions = {}): AlpineData<MenuState> => ({
        ...createMenuNavigation(),

        keepOpen: options.keepOpen ?? false,
        parentMenu: null as MenuState | null,

        init() {
            this.$nextTick?.(() => {
                const menuElement = this.$el as HTMLElement;

                menuElement.addEventListener('keydown', (event: KeyboardEvent) => {
                    switch (event.key) {
                        case 'ArrowDown':
                            event.preventDefault();
                            this.navigateDown();
                            break;
                        case 'ArrowUp':
                            event.preventDefault();
                            this.navigateUp();
                            break;
                        case 'Enter':
                        case ' ':
                            event.preventDefault();
                            this.selectActive();
                            break;
                        case 'Escape':
                            event.preventDefault();
                            this.close();
                            break;
                        case 'Tab':
                            this.close();
                            break;
                    }
                });
            });
        },

        unregisterItem(element: HTMLElement) {
            this.items = this.items.filter((item: MenuItem) => item.element !== element);
        },

        close() {
            this.$dispatch?.('menu-close');
        },

        selectActive() {
            if (this.activeIndex >= 0 && this.activeIndex < this.items.length) {
                const item = this.items[this.activeIndex];

                if (!item.disabled && !item.isSubmenu) {
                    item.element.click();

                    const itemKeepOpen = item.element.hasAttribute('data-keep-open');
                    if (!this.keepOpen && !itemKeepOpen) {
                        this.close();
                    }
                }
            }
        },
    }));

    Alpine.data('menuItem', (options: { disabled?: boolean; keepOpen?: boolean } = {}) => ({
        disabled: options.disabled ?? false,
        keepOpen: options.keepOpen ?? false,

        init() {
            const menuContext = this.$el.closest('[x-data*="menu"]');

            if (menuContext instanceof HTMLElement) {
                const menu = Alpine.$data(menuContext) as MenuState;

                menu.registerItem({
                    element: this.$el as HTMLElement,
                    disabled: this.disabled,
                    isSubmenu: false,
                });
            }

            if (this.keepOpen) {
                (this.$el as HTMLElement).setAttribute('data-keep-open', 'true');
            }

            this.$el.addEventListener('DOMNodeRemoved', () => {
                if (menuContext instanceof HTMLElement) {
                    const menu = Alpine.$data(menuContext) as MenuState;
                    menu.unregisterItem(this.$el as HTMLElement);
                }
            });
        },
    }));
}
