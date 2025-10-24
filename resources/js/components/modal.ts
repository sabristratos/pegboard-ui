import type { Alpine, AlpineData } from '../types/alpine';
import type { ModalOptions, ModalState } from '../types/components';

export function modal(Alpine: Alpine): void {
    Alpine.data('modal', (options: ModalOptions = {}): AlpineData<ModalState> => ({
        isOpen: false,
        name: options.name ?? '',
        variant: options.variant ?? 'default',
        dismissible: options.dismissible ?? true,
        closable: options.closable ?? true,

        init() {
            this.$nextTick?.(() => {
                const dialog = this.$refs?.dialog as HTMLDialogElement;

                if (!dialog) {
                    return;
                }

                dialog.addEventListener('close', () => {
                    this.isOpen = false;
                });

                if (this.dismissible) {
                    dialog.addEventListener('click', (event: MouseEvent) => {
                        const rect = dialog.getBoundingClientRect();
                        const isInDialog = (
                            rect.top <= event.clientY &&
                            event.clientY <= rect.top + rect.height &&
                            rect.left <= event.clientX &&
                            event.clientX <= rect.left + rect.width
                        );

                        if (!isInDialog) {
                            this.close();
                        }
                    });
                }

                dialog.addEventListener('cancel', (event: Event) => {
                    if (!this.dismissible) {
                        event.preventDefault();
                    }
                });
            });
        },

        open() {
            const dialog = this.$refs?.dialog as HTMLDialogElement;

            if (dialog && !this.isOpen) {
                dialog.showModal();
                this.isOpen = true;

                this.$nextTick?.(() => {
                    const focusable = dialog.querySelector<HTMLElement>(
                        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
                    );

                    if (focusable) {
                        focusable.focus();
                    }
                });
            }
        },

        close() {
            const dialog = this.$refs?.dialog as HTMLDialogElement;

            if (dialog && this.isOpen) {
                dialog.close();
                this.isOpen = false;
            }
        },

        toggle() {
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        },
    }));
}
