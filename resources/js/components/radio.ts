import type { Alpine, AlpineData } from '../types/alpine';

export interface RadioGroupOptions {
    name?: string | null;
    value?: string | null;
}

export interface RadioGroupState {
    name: string | null;
    groupName: string | null;
    selectedValue: string;
    init(): void;
    syncFromDOM(): void;
    selectValue(value: string | number): void;
}

export interface RadioOptions {
    value: string | number;
    disabled?: boolean;
}

export interface RadioState {
    value: string | number;
    disabled: boolean;
    init(): void;
    select(): void;
}

export function radio(Alpine: Alpine): void {
    Alpine.data('pegboardRadioGroup', (opts: RadioGroupOptions = {}): AlpineData<RadioGroupState> => ({
        name: opts.name ?? null,
        groupName: opts.name ?? null,
        selectedValue: opts.value ?? '',

        init() {
            this.syncFromDOM();

            this.$el?.addEventListener('change', (e: Event) => {
                if ((e.target as HTMLElement).matches('input[type="radio"]')) {
                    this.syncFromDOM();
                }
            });

            this.$watch?.('selectedValue', () => {
                const radios = this.$el?.querySelectorAll('input[type="radio"]') as NodeListOf<HTMLInputElement>;
                radios.forEach(input => {
                    const shouldBeChecked = String(input.value) === String(this.selectedValue);
                    if (input.checked !== shouldBeChecked) {
                        input.checked = shouldBeChecked;
                    }
                });
            });
        },

        syncFromDOM() {
            const checkedInput = this.$el?.querySelector('input[type="radio"]:checked') as HTMLInputElement;
            this.selectedValue = checkedInput ? checkedInput.value : '';
        },

        selectValue(value: string | number) {
            const input = this.$el?.querySelector(`input[type="radio"][value="${value}"]`) as HTMLInputElement;
            if (input) {
                input.checked = true;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    }));

    Alpine.data('pegboardRadio', (opts: RadioOptions): AlpineData<RadioState> => ({
        value: opts.value,
        disabled: opts.disabled ?? false,

        init() {},

        select() {
            if (this.disabled) return;

            const input = this.$el?.querySelector('input[type="radio"]') as HTMLInputElement;
            if (input) {
                input.checked = true;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    }));
}
