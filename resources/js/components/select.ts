import type { Alpine, AlpineData } from '../types/alpine';

export interface SelectOption {
    value: string;
    text: string;
    icon?: string | null;
    element: HTMLElement;
}

export interface SelectOptions {
    multiple?: boolean;
    searchable?: boolean;
    isPillbox?: boolean;
    value?: string | string[] | null;
    name?: string | null;
}

export interface SelectState {
    multiple: boolean;
    searchable: boolean;
    isPillbox: boolean;
    name: string | null;

    open: boolean;
    search: string;
    selectedValue: string;
    selectedValues: string[];
    selectedText: string;
    options: SelectOption[];
    activeIndex: number;
    filteredOptions: SelectOption[];

    init(): void;
    registerOption(option: SelectOption): void;
    toggle(): void;
    close(): void;
    selectOption(value: string, element?: HTMLElement): void;
    removeOption(value: string): void;
    isSelected(value: string): boolean;
    isOptionVisible(value: string, text: string): boolean;
    getOptionText(value: string): string;
    getOptionIcon(value: string): string | null;
    getSelectedIconHtml(): string;
    getOptionIndex(value: string): number;
    updateFilteredOptions(): void;
    navigateDown(): void;
    navigateUp(): void;
    selectActive(): void;
    scrollToActive(): void;
    dispatchChangeEvent(): void;
}

export function select(Alpine: Alpine): void {
    Alpine.data('pegboardSelect', (opts: SelectOptions = {}): AlpineData<SelectState> => ({
        multiple: opts.multiple ?? false,
        searchable: opts.searchable ?? false,
        isPillbox: opts.isPillbox ?? false,
        name: opts.name ?? null,
        open: false,
        search: '',
        selectedValue: '',
        selectedValues: [],
        selectedText: '',
        options: [],
        activeIndex: -1,
        filteredOptions: [],

        init() {
            const hiddenInput = this.$el?.querySelector('input[type="hidden"]') as HTMLInputElement;
            if (hiddenInput && hiddenInput.value) {
                if (this.multiple) {
                    const hiddenInputs = this.$el?.querySelectorAll('input[type="hidden"]');
                    this.selectedValues = Array.from(hiddenInputs || []).map(input => (input as HTMLInputElement).value);
                } else {
                    this.selectedValue = hiddenInput.value;
                }
            } else if (opts.value) {
                if (this.multiple && Array.isArray(opts.value)) {
                    this.selectedValues = opts.value.map(v => String(v));
                } else if (!this.multiple && typeof opts.value === 'string') {
                    this.selectedValue = opts.value;
                }
            }

            this.$watch?.('search', () => {
                this.updateFilteredOptions();
                this.activeIndex = 0;
            });

            // Watch selectedValue to update selectedText when Livewire changes the value
            this.$watch?.('selectedValue', (newValue: string) => {
                if (!this.multiple && newValue) {
                    const option = this.options.find((opt: SelectOption) => opt.value === newValue);
                    if (option) {
                        this.selectedText = option.text;
                    } else {
                        // Options not registered yet - will be set when option registers
                        this.selectedText = '';
                    }
                } else if (!this.multiple && !newValue) {
                    this.selectedText = '';
                }
            });

            this.$watch?.('open', (isOpen: boolean) => {
                const popover = this.$refs?.popover as HTMLElement;

                if (!popover) {
                    return;
                }

                if (isOpen) {
                    try {
                        popover.showPopover();
                    } catch (e) {
                        console.error('[SELECT] showPopover() failed:', e);
                    }

                    if (this.searchable) {
                        this.$nextTick?.(() => {
                            const searchInput = popover.querySelector('input[type="text"]') as HTMLInputElement;
                            if (searchInput) {
                                searchInput.focus();
                            }
                        });
                    }
                } else {
                    try {
                        popover.hidePopover();
                    } catch (e) {
                        console.error('[SELECT] hidePopover() failed:', e);
                    }
                    this.search = '';
                }
            });
        },

        registerOption(option: SelectOption) {
            this.options.push(option);
            this.updateFilteredOptions();

            if (!this.multiple && this.selectedValue === option.value) {
                this.selectedText = option.text;
            }
        },

        toggle() {
            if (!this.open) {
                this.$nextTick?.(() => {
                    this.open = true;
                });
            } else {
                this.open = false;
            }
        },

        close() {
            this.open = false;
        },

        selectOption(value: string, _element?: HTMLElement) {
            if (this.multiple) {
                const index = this.selectedValues.indexOf(value);
                if (index > -1) {
                    this.selectedValues.splice(index, 1);
                } else {
                    this.selectedValues.push(value);
                }
            } else {
                this.selectedValue = value;
                const option = this.options.find((opt: SelectOption) => opt.value === value);
                this.selectedText = option?.text || '';
                this.close();
            }

            this.dispatchChangeEvent();
        },

        removeOption(value: string) {
            if (this.multiple) {
                const index = this.selectedValues.indexOf(value);
                if (index > -1) {
                    this.selectedValues.splice(index, 1);
                    this.dispatchChangeEvent();
                }
            }
        },

        isSelected(value: string): boolean {
            if (this.multiple) {
                return this.selectedValues.includes(value);
            }
            return this.selectedValue === value;
        },

        isOptionVisible(_value: string, text: string): boolean {
            if (!this.search) {
                return true;
            }
            return text.toLowerCase().includes(this.search.toLowerCase());
        },

        getOptionText(value: string): string {
            const option = this.options.find((opt: SelectOption) => opt.value === value);
            return option?.text || value;
        },

        getOptionIcon(value: string): string | null {
            const option = this.options.find((opt: SelectOption) => opt.value === value);
            return option?.icon || null;
        },

        getSelectedIconHtml(): string {
            if (!this.selectedValue) return '';

            const selectedOption = this.options.find((opt: SelectOption) => opt.value === this.selectedValue);
            if (!selectedOption || !selectedOption.icon) return '';

            const iconContainer = selectedOption.element.querySelector('[data-option-icon]');
            if (iconContainer) {
                const clone = iconContainer.cloneNode(true) as HTMLElement;
                clone.className = 'flex items-center';
                const svg = clone.querySelector('svg');
                if (svg) {
                    svg.classList.add('h-4', 'w-4');
                }
                return clone.innerHTML;
            }

            return '';
        },

        getOptionIndex(value: string): number {
            return this.filteredOptions.findIndex((opt: SelectOption) => opt.value === value);
        },

        updateFilteredOptions() {
            if (!this.search) {
                this.filteredOptions = [...this.options];
            } else {
                const searchLower = this.search.toLowerCase();
                this.filteredOptions = this.options.filter((opt: SelectOption) =>
                    opt.text.toLowerCase().includes(searchLower)
                );
            }
        },

        navigateDown() {
            if (this.filteredOptions.length === 0) {
                return;
            }
            this.activeIndex = (this.activeIndex + 1) % this.filteredOptions.length;
            this.scrollToActive();
        },

        navigateUp() {
            if (this.filteredOptions.length === 0) {
                return;
            }
            this.activeIndex = this.activeIndex <= 0
                ? this.filteredOptions.length - 1
                : this.activeIndex - 1;
            this.scrollToActive();
        },

        selectActive() {
            if (this.activeIndex >= 0 && this.activeIndex < this.filteredOptions.length) {
                const activeOption = this.filteredOptions[this.activeIndex];
                this.selectOption(activeOption.value, activeOption.element);
            }
        },

        scrollToActive() {
            if (this.activeIndex >= 0 && this.activeIndex < this.filteredOptions.length) {
                const activeOption = this.filteredOptions[this.activeIndex];
                activeOption.element.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
            }
        },

        dispatchChangeEvent() {
            this.$nextTick?.(() => {
                const hiddenInput = this.$el?.querySelector('input[type="hidden"]') as HTMLInputElement;

                if (hiddenInput) {
                    const inputEvent = new Event('input', { bubbles: true });
                    hiddenInput.dispatchEvent(inputEvent);

                    const changeEvent = new Event('change', { bubbles: true });
                    hiddenInput.dispatchEvent(changeEvent);
                }

                const componentChangeEvent = new Event('change', { bubbles: true });
                this.$el?.dispatchEvent(componentChangeEvent);
            });
        }
    }));
}
