import type { Alpine, AlpineData } from '../types/alpine';
import type { InputOptions, InputState } from '../types/components';

export function input(Alpine: Alpine): void {
    Alpine.data('pegboardInput', (options: InputOptions = {}): AlpineData<InputState> => ({
        inputType: 'text',
        passwordVisible: false,
        copied: false,
        clearable: options.clearable ?? false,
        showPassword: options.showPassword ?? false,
        copy: options.copy ?? false,
        viewInNewPage: options.viewInNewPage ?? false,

        init() {
            const input = this.$refs?.input as HTMLInputElement;
            if (input) {
                this.inputType = input.type || 'text';
            }
        },

        clear() {
            const input = this.$refs?.input as HTMLInputElement;
            if (input) {
                input.value = '';
                input.dispatchEvent(new Event('input', { bubbles: true }));
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
