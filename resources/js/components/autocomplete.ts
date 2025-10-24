import type { Alpine, AlpineData } from '../types/alpine';
import type { AutocompleteState, AutocompleteItem } from '../types/components';

export interface AutocompleteOptions {
    clearable?: boolean;
    value?: string | null;
}

export function autocomplete(Alpine: Alpine): void {
    Alpine.data('pegboardAutocomplete', (opts: AutocompleteOptions = {}): AlpineData<AutocompleteState> => {
        let _items: AutocompleteItem[] = [];

        return {
            clearable: opts.clearable ?? false,
            open: false,
            value: opts.value ?? '',
            searchValue: '',
            get items() { return _items; },
            set items(value) { _items = value; },
            filteredItems: [],
            activeIndex: -1,
            blurTimeout: null,

            init() {
                if (opts.value) {
                    const input = this.$refs?.input as HTMLInputElement;
                    if (input) {
                        input.value = opts.value;
                    }
                }

                this.$watch?.('value', (newValue: string) => {
                    const input = this.$refs?.input as HTMLInputElement;
                    if (input && input.value !== newValue) {
                        input.value = newValue || '';
                    }
                });

                this.$watch?.('open', (isOpen: boolean) => {
                    const popover = this.$refs?.popover as HTMLElement;
                    if (!popover) return;

                    if (isOpen) {
                        popover.showPopover();
                    } else {
                        popover.hidePopover();
                    }
                });
            },

            registerItem(item: AutocompleteItem) {
                this.items.push(item);
                this.filterItems();
            },

            onInput() {
                const input = this.$refs?.input as HTMLInputElement;
                const inputValue = input ? input.value : '';
                this.searchValue = inputValue;
                this.value = inputValue;
                this.filterItems();
                this.open = true;
                this.activeIndex = 0;
            },

            onFocus() {
                if (this.blurTimeout) {
                    clearTimeout(this.blurTimeout);
                    this.blurTimeout = null;
                }

                const input = this.$refs?.input as HTMLInputElement;

                if (input && input.value) {
                    input.select();
                }

                this.searchValue = '';
                this.filterItems();
            },

            onBlur() {
                this.blurTimeout = setTimeout(() => {
                    this.close();
                }, 250);
            },

            close() {
                this.open = false;
                this.activeIndex = -1;
            },

            clear() {
                const input = this.$refs?.input as HTMLInputElement;
                if (input) {
                    input.value = '';
                    this.value = '';
                    this.searchValue = '';
                    this.close();
                }
            },

            filterItems() {
                const input = this.$refs?.input as HTMLInputElement;
                if (!input) {
                    this.filteredItems = [];
                    return;
                }

                const searchValue = input.value.toLowerCase().trim();

                if (!searchValue) {
                    this.filteredItems = this.items.filter((item: AutocompleteItem) => !item.disabled);
                    return;
                }

                this.filteredItems = this.items.filter((item: AutocompleteItem) =>
                    !item.disabled && item.text.toLowerCase().includes(searchValue)
                );
            },

            isItemVisible(text: string): boolean {
                const searchValue = this.searchValue.toLowerCase().trim();

                if (!searchValue) {
                    return true;
                }

                return text.toLowerCase().includes(searchValue);
            },

            getItemIndex(element: HTMLElement): number {
                return this.filteredItems.findIndex((item: AutocompleteItem) => item.element === element);
            },

            navigateDown() {
                if (this.filteredItems.length === 0) {
                    return;
                }
                this.activeIndex = (this.activeIndex + 1) % this.filteredItems.length;
                this.scrollToActive();
            },

            navigateUp() {
                if (this.filteredItems.length === 0) {
                    return;
                }
                this.activeIndex = this.activeIndex <= 0
                    ? this.filteredItems.length - 1
                    : this.activeIndex - 1;
                this.scrollToActive();
            },

            selectActive() {
                if (this.activeIndex >= 0 && this.activeIndex < this.filteredItems.length) {
                    const activeItem = this.filteredItems[this.activeIndex];
                    this.selectItem(activeItem.element);
                }
            },

            selectItem(element: HTMLElement) {
                const item = _items.find(i => i.element === element);
                if (!item || item.disabled) {
                    return;
                }

                const input = this.$refs?.input as HTMLInputElement;
                if (input) {
                    input.value = item.text;
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                }

                this.value = item.text;
                this.searchValue = '';
                this.close();
            },

            scrollToActive() {
                if (this.activeIndex >= 0 && this.activeIndex < this.filteredItems.length) {
                    const activeItem = this.filteredItems[this.activeIndex];
                    activeItem.element.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                }
            },
        };
    });
}
