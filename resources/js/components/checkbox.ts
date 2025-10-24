import type { Alpine, AlpineData } from '../types/alpine';

export interface CheckboxGroupOptions {
    name?: string | null;
    value?: Array<string | number>;
}

export interface CheckboxGroupState {
    name: string | null;
    selectedValues: Array<string | number>;
    init(): void;
    syncFromDOM(): void;
    toggleValue(value: string | number): void;
}

export interface CheckboxOptions {
    value: string | number;
    disabled?: boolean;
    indeterminate?: boolean;
}

export interface CheckboxState {
    value: string | number;
    disabled: boolean;
    indeterminate: boolean;
    init(): void;
    toggle(): void;
}

export function checkbox(Alpine: Alpine): void {
    Alpine.data('pegboardCheckboxGroup', (opts: CheckboxGroupOptions = {}): AlpineData<CheckboxGroupState> => ({
        name: opts.name ?? null,
        selectedValues: opts.value ?? [],

        init() {
            this.syncFromDOM();

            this.$el?.addEventListener('change', (e: Event) => {
                if ((e.target as HTMLElement).matches('input[type="checkbox"]')) {
                    this.syncFromDOM();
                }
            });

            this.$watch?.('selectedValues', () => {
                const checkboxes = this.$el?.querySelectorAll('input[type="checkbox"]') as NodeListOf<HTMLInputElement>;
                checkboxes.forEach(input => {
                    const shouldBeChecked = this.selectedValues.includes(input.value);
                    if (input.checked !== shouldBeChecked) {
                        input.checked = shouldBeChecked;
                    }
                });
            });
        },

        syncFromDOM() {
            const checkboxes = this.$el?.querySelectorAll('input[type="checkbox"]') as NodeListOf<HTMLInputElement>;
            this.selectedValues = Array.from(checkboxes)
                .filter(input => input.checked)
                .map(input => input.value);
        },

        toggleValue(value: string | number) {
            const input = this.$el?.querySelector(`input[type="checkbox"][value="${value}"]`) as HTMLInputElement;
            if (input) {
                input.checked = !input.checked;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    }));

    Alpine.data('pegboardCheckbox', (opts: CheckboxOptions): AlpineData<CheckboxState> => ({
        value: opts.value,
        disabled: opts.disabled ?? false,
        indeterminate: opts.indeterminate ?? false,

        init() {
            const input = this.$el?.querySelector('input[type="checkbox"]') as HTMLInputElement;

            if (input && this.indeterminate) {
                input.indeterminate = true;
            }
        },

        toggle() {
            if (this.disabled) return;

            const input = this.$el?.querySelector('input[type="checkbox"]') as HTMLInputElement;
            if (input) {
                input.checked = !input.checked;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    }));
}
