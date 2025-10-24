import type { AlpineComponent } from './alpine';
import type { MenuItem } from './components';

export interface MenuNavigationState {
    items: MenuItem[];
    activeIndex: number;

    registerItem(item: MenuItem): void;
    navigateDown(): void;
    navigateUp(): void;
    activateItem(index: number): void;
    focusItem(index: number): void;
    resetActiveIndex(): void;
}

/**
 * Creates shared navigation logic for menu and submenu components
 */
export function createMenuNavigation(): MenuNavigationState & Partial<AlpineComponent> {
    return {
        items: [],
        activeIndex: -1,

        registerItem(item: MenuItem) {
            this.items.push(item);
        },

        navigateDown() {
            let nextIndex = this.activeIndex + 1;

            while (nextIndex < this.items.length && this.items[nextIndex].disabled) {
                nextIndex++;
            }

            if (nextIndex < this.items.length) {
                this.activateItem(nextIndex);
            } else {
                nextIndex = 0;
                while (nextIndex < this.items.length && this.items[nextIndex].disabled) {
                    nextIndex++;
                }
                if (nextIndex < this.items.length) {
                    this.activateItem(nextIndex);
                }
            }
        },

        navigateUp() {
            let prevIndex = this.activeIndex - 1;

            if (prevIndex < 0) {
                prevIndex = this.items.length - 1;
            }

            while (prevIndex >= 0 && this.items[prevIndex].disabled) {
                prevIndex--;
            }

            if (prevIndex >= 0) {
                this.activateItem(prevIndex);
            } else {
                prevIndex = this.items.length - 1;
                while (prevIndex >= 0 && this.items[prevIndex].disabled) {
                    prevIndex--;
                }
                if (prevIndex >= 0) {
                    this.activateItem(prevIndex);
                }
            }
        },

        activateItem(index: number) {
            this.items.forEach((item: MenuItem) => {
                item.element.removeAttribute('data-active');
            });

            this.activeIndex = index;

            if (index >= 0 && index < this.items.length) {
                const item = this.items[index];
                item.element.setAttribute('data-active', 'true');
                this.focusItem(index);
            }
        },

        focusItem(index: number) {
            if (index >= 0 && index < this.items.length) {
                const item = this.items[index];
                const focusable = item.element.querySelector('button, a, [tabindex]:not([tabindex="-1"])') as HTMLElement;

                if (focusable) {
                    focusable.focus();
                } else {
                    item.element.focus();
                }
            }
        },

        resetActiveIndex() {
            this.items.forEach((item: MenuItem) => {
                item.element.removeAttribute('data-active');
            });
            this.activeIndex = -1;
        },
    };
}
