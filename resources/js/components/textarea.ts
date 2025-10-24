import type { Alpine, AlpineData } from '../types/alpine';

export interface TextareaOptions {
    copy?: boolean;
}

export interface TextareaState {
    copied: boolean;
    copy: boolean;
    clear(): void;
    copyToClipboard(): Promise<void>;
}

export function textarea(Alpine: Alpine): void {
    Alpine.data('pegboardTextarea', (options: TextareaOptions = {}): AlpineData<TextareaState> => ({
        copied: false,
        copy: options.copy ?? false,

        clear() {
            const textarea = this.$refs?.textarea as HTMLTextAreaElement;
            if (textarea) {
                textarea.value = '';
                textarea.dispatchEvent(new Event('input', { bubbles: true }));
                textarea.focus();
            }
        },

        async copyToClipboard() {
            const textarea = this.$refs?.textarea as HTMLTextAreaElement;
            if (!textarea) return;

            try {
                await navigator.clipboard.writeText(textarea.value);
                this.copied = true;

                setTimeout(() => {
                    this.copied = false;
                }, 1000);
            } catch (err) {
                console.error('Failed to copy text:', err);
            }
        }
    }));
}
