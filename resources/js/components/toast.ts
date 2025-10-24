import type { Alpine } from '../types/alpine';
import type { ToastOptions, ToastItem, ToastPosition } from '../types/components';

export function toast(Alpine: Alpine): void {
    Alpine.store('toasts', {
        items: [] as ToastItem[],
        nextId: 1,
        maxToasts: 4,

        add(options: ToastOptions | string) {
            if (typeof options === 'string') {
                options = { text: options };
            }

            const id = this.nextId++;
            const duration = options.duration !== undefined ? options.duration : 4000;
            const toast: ToastItem = {
                id,
                heading: options.heading || '',
                text: options.text || '',
                variant: options.variant || 'default',
                duration,
                visible: false,
                createdAt: Date.now(),
                paused: false,
                remainingDuration: duration,
                action: options.action || null,
            };

            this.items.unshift(toast);

            if (this.items.length > this.maxToasts) {
                const oldestToast = this.items[this.maxToasts];
                if (oldestToast) {
                    this.burn(oldestToast.id);
                }
            }

            requestAnimationFrame(() => {
                const toastItem = this.items.find((t: ToastItem) => t.id === id);
                if (toastItem) {
                    toastItem.visible = true;
                }
            });

            if (toast.duration > 0) {
                setTimeout(() => {
                    this.burn(id);
                }, toast.duration);
            }

            return id;
        },

        pause(id: number) {
            const toast = this.items.find((t: ToastItem) => t.id === id);
            if (toast && !toast.paused) {
                toast.paused = true;
                const elapsed = Date.now() - (toast.createdAt || 0);
                toast.remainingDuration = Math.max(0, toast.duration - elapsed);
            }
        },

        resume(id: number) {
            const toast = this.items.find((t: ToastItem) => t.id === id);
            if (toast && toast.paused) {
                toast.paused = false;
                toast.createdAt = Date.now();

                if (toast.remainingDuration && toast.remainingDuration > 0) {
                    setTimeout(() => {
                        this.burn(id);
                    }, toast.remainingDuration);
                }
            }
        },

        burn(id: number) {
            const toast = this.items.find((t: ToastItem) => t.id === id);
            if (!toast) return;

            const element = document.getElementById(`toast-${id}`);

            if (element) {
                element.setAttribute('data-state', 'exiting');
            }

            toast.visible = false;

            setTimeout(() => {
                this.items = this.items.filter((t: ToastItem) => t.id !== id);
            }, 300);
        },

        remove(id: number) {
            this.burn(id);
        },

        clear() {
            this.items.forEach((toast: ToastItem) => {
                toast.visible = false;
            });

            setTimeout(() => {
                this.items = [];
            }, 300);
        },
    });

    Alpine.data('pegboardToast', (config?: { position?: ToastPosition }) => ({
        position: config?.position || 'bottom end',
        isHovered: false,
        handleEscape: null as ((event: KeyboardEvent) => void) | null,

        init() {
            if (typeof (window as any).Livewire !== 'undefined') {
                (window as any).Livewire.on('pegboard:toast', (...params: any[]) => {
                    // Livewire wraps the data in an array, so unwrap it
                    const data = params[0]?.[0] || params[0];
                    (Alpine.store('toasts') as any).add(data);
                });
            }

            window.addEventListener('pegboard:toast', ((event: CustomEvent<ToastOptions>) => {
                // Browser events may also be wrapped, unwrap if needed
                const data = Array.isArray(event.detail) ? event.detail[0] : event.detail;
                (Alpine.store('toasts') as any).add(data);
            }) as EventListener);

            this.$watch('$store.toasts.items', () => {
                this.stackToasts();
            });

            this.handleEscape = (event: KeyboardEvent) => {
                if (
                    event.key === 'Escape' &&
                    (Alpine.store('toasts') as any).items.length > 0 &&
                    !document.querySelector('dialog[open]')
                ) {
                    (Alpine.store('toasts') as any).clear();
                }
            };

            window.addEventListener('keydown', this.handleEscape);
        },

        destroy() {
            if (this.handleEscape) {
                window.removeEventListener('keydown', this.handleEscape);
            }
        },

        stackToasts() {
            const toasts = (Alpine.store('toasts') as any).items;
            if (toasts.length === 0) return;
            const paddingBetweenToasts = 12;

            requestAnimationFrame(() => {
                const wrapper = this.$refs.toastStack as HTMLElement;
                if (!wrapper) return;

                if (this.isHovered) {
                    let cumulativeHeight = 0;
                    toasts.forEach((toast: ToastItem, index: number) => {
                        const element = document.getElementById(`toast-${toast.id}`);
                        if (!element) return;

                        element.style.zIndex = String(100 - index * 10);

                        if (this.position.includes('bottom')) {
                            element.style.bottom = `${cumulativeHeight}px`;
                            element.style.top = 'auto';
                        } else {
                            element.style.top = `${cumulativeHeight}px`;
                            element.style.bottom = 'auto';
                        }

                        element.style.transform = 'scale(1)';
                        element.style.opacity = '1';
                        cumulativeHeight += element.getBoundingClientRect().height + paddingBetweenToasts;
                    });

                    wrapper.style.height = `${cumulativeHeight}px`;
                } else {
                    let maxExtent = 0;
                    toasts.forEach((toast: ToastItem, index: number) => {
                        const element = document.getElementById(`toast-${toast.id}`);
                        if (!element) return;

                        element.style.zIndex = String(100 - index * 10);

                        if (this.position.includes('bottom')) {
                            element.style.bottom = '0px';
                            element.style.top = 'auto';
                        } else {
                            element.style.top = '0px';
                            element.style.bottom = 'auto';
                        }

                        const scale = 1 - index * 0.06;
                        const offset = index * 16;

                        if (this.position.includes('bottom')) {
                            element.style.transform = `scale(${scale}) translateY(-${offset}px)`;
                        } else {
                            element.style.transform = `scale(${scale}) translateY(${offset}px)`;
                        }

                        if (index > 3) {
                            element.style.opacity = '0';
                        } else {
                            element.style.opacity = '1';
                        }

                        if (index <= 3) {
                            maxExtent = Math.max(maxExtent, offset + element.getBoundingClientRect().height);
                        }
                    });

                    wrapper.style.height = `${maxExtent}px`;
                }
            });
        },

        getToastClasses(_index: number): string {
            const classes: string[] = [];

            if (this.isHovered) {
                if (this.position.includes('bottom')) {
                    classes.push('mb-3');
                } else {
                    classes.push('mt-3');
                }
            }

            return classes.join(' ');
        },
    }));

    if (typeof window !== 'undefined') {
        (window as any).Pegboard = (window as any).Pegboard || {};
        (window as any).Pegboard.toast = Object.assign(
            (options: ToastOptions | string) => {
                return (Alpine.store('toasts') as any).add(options);
            },
            {
                success: (text: string, heading?: string) => {
                    return (Alpine.store('toasts') as any).add({ text, heading, variant: 'success' });
                },
                error: (text: string, heading?: string) => {
                    return (Alpine.store('toasts') as any).add({ text, heading, variant: 'danger' });
                },
                warning: (text: string, heading?: string) => {
                    return (Alpine.store('toasts') as any).add({ text, heading, variant: 'warning' });
                },
                danger: (text: string, heading?: string) => {
                    return (Alpine.store('toasts') as any).add({ text, heading, variant: 'danger' });
                },
            }
        );
    }

    Alpine.magic('pegboard', () => ({
        toast: Object.assign(
            (options: ToastOptions | string) => {
                return (Alpine.store('toasts') as any).add(options);
            },
            {
                success: (text: string, heading?: string) => {
                    return (Alpine.store('toasts') as any).add({ text, heading, variant: 'success' });
                },
                error: (text: string, heading?: string) => {
                    return (Alpine.store('toasts') as any).add({ text, heading, variant: 'danger' });
                },
                warning: (text: string, heading?: string) => {
                    return (Alpine.store('toasts') as any).add({ text, heading, variant: 'warning' });
                },
                danger: (text: string, heading?: string) => {
                    return (Alpine.store('toasts') as any).add({ text, heading, variant: 'danger' });
                },
            }
        ),
    }));
}
