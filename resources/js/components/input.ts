import type { Alpine, AlpineData } from '../types/alpine';
import type { InputOptions, InputState } from '../types/components';

export function input(Alpine: Alpine): void {
    Alpine.data('pegboardInput', (options: InputOptions = {}): AlpineData<InputState> => ({
        inputType: 'text',
        passwordVisible: false,
        copied: false,
        inputValue: '',
        clearable: options.clearable ?? false,
        showPassword: options.showPassword ?? false,
        copy: options.copy ?? false,
        viewInNewPage: options.viewInNewPage ?? false,

        init() {
            const input = this.$refs?.input as HTMLInputElement;
            if (input) {
                this.inputType = input.type || 'text';
                this.inputValue = input.value || '';

                input.addEventListener('input', () => {
                    this.inputValue = input.value;
                });

                (window as any).Livewire?.hook('morph.updated', ({ el, component }: any) => {
                    if (el === input || el.contains(input)) {
                        this.inputValue = input.value;
                    }
                });

                const hasLiveWireModel = Array.from(input.attributes).some(
                    attr => attr.name.startsWith('wire:model') && attr.name.includes('.live')
                );

                if (hasLiveWireModel) {
                    const wireModelAttr = Array.from(input.attributes).find(
                        attr => attr.name.startsWith('wire:model')
                    );

                    console.log('[Pegboard Input] Component initialized', {
                        inputId: input.id,
                        wireModel: wireModelAttr?.name,
                        wireModelValue: wireModelAttr?.value,
                        wireKey: input.getAttribute('wire:key'),
                    });

                    input.addEventListener('focus', () => {
                        console.log('[Pegboard Input] Focus gained', {
                            inputId: input.id,
                            value: input.value,
                            cursorPosition: input.selectionStart,
                        });
                    });

                    input.addEventListener('blur', () => {
                        console.log('[Pegboard Input] Focus lost', {
                            inputId: input.id,
                            value: input.value,
                            activeElement: document.activeElement?.tagName,
                        });
                    });

                    input.addEventListener('input', () => {
                        console.log('[Pegboard Input] Input changed', {
                            inputId: input.id,
                            value: input.value,
                            cursorPosition: input.selectionStart,
                        });
                    });
                }
            }
        },

        clear() {
            const input = this.$refs?.input as HTMLInputElement;
            if (input) {
                input.value = '';
                this.inputValue = '';
                input.dispatchEvent(new Event('input', { bubbles: false }));
                input.dispatchEvent(new Event('change', { bubbles: false }));
                input.focus();
            }
        },

        togglePasswordVisibility() {
            this.passwordVisible = !this.passwordVisible;
            this.inputType = this.passwordVisible ? 'text' : 'password';
        },

        async copyToClipboard() {
            const input = this.$refs?.input as HTMLInputElement;
            if (!input) return;

            try {
                await navigator.clipboard.writeText(input.value);
                this.copied = true;

                setTimeout(() => {
                    this.copied = false;
                }, 1000);
            } catch (err) {
                console.error('Failed to copy:', err);
            }
        },

        isValidUrl(): boolean {
            const input = this.$refs?.input as HTMLInputElement;
            if (!input || !input.value) return false;

            try {
                new URL(input.value);
                return true;
            } catch {
                return false;
            }
        },
    }));
}
