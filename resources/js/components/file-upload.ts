import type { Alpine, AlpineData } from '../types/alpine';
import type { FileUploadOptions, FileUploadState, SelectedFileMetadata } from '../types/components';

const LIVEWIRE_EVENTS = {
    UPLOAD_START: 'livewire-upload-start',
    UPLOAD_PROGRESS: 'livewire-upload-progress',
    UPLOAD_FINISH: 'livewire-upload-finish',
    UPLOAD_ERROR: 'livewire-upload-error',
} as const;

export function fileUpload(Alpine: Alpine): void {
    Alpine.data('fileUpload', (options: FileUploadOptions = {}): AlpineData<FileUploadState> => ({
        isDragging: false,
        isInvalidType: false,
        isLoading: false,
        progress: 0,
        hasError: false,
        multiple: options.multiple ?? false,
        disabled: options.disabled ?? false,
        modelName: null as string | null,
        listeners: [],
        selectedFiles: [] as SelectedFileMetadata[],

        init() {
            this.$nextTick?.(() => {
                const input = this.$refs?.input as HTMLInputElement;

                if (!input) {
                    console.error('[Pegboard FileUpload] Input element not found!');
                    return;
                }

                this.setupLivewireListeners(input);
            });
        },

        destroy() {
            this.listeners.forEach(({ event, handler }: { event: string; handler: (e: Event) => void }) => {
                window.removeEventListener(event, handler);
            });
        },

        setupLivewireListeners(input: HTMLInputElement) {
            this.modelName = this.getWireModelName(input);

            if (!this.modelName) {
                return;
            }

            const modelName = this.modelName;

            this.listeners = [
                {
                    event: LIVEWIRE_EVENTS.UPLOAD_START,
                    handler: (event: Event) => {
                        const customEvent = event as CustomEvent;
                        if (customEvent.detail.name === modelName) {
                            this.isLoading = true;
                            this.progress = 0;
                            this.hasError = false;
                        }
                    },
                },
                {
                    event: LIVEWIRE_EVENTS.UPLOAD_PROGRESS,
                    handler: (event: Event) => {
                        const customEvent = event as CustomEvent;
                        if (customEvent.detail.name === modelName) {
                            this.progress = Math.round(customEvent.detail.progress);
                        }
                    },
                },
                {
                    event: LIVEWIRE_EVENTS.UPLOAD_FINISH,
                    handler: (event: Event) => {
                        const customEvent = event as CustomEvent;
                        if (customEvent.detail.name === modelName) {
                            this.isLoading = false;
                            this.progress = 100;
                            this.hasError = false;
                        }
                    },
                },
                {
                    event: LIVEWIRE_EVENTS.UPLOAD_ERROR,
                    handler: (event: Event) => {
                        const customEvent = event as CustomEvent;
                        console.error('[Pegboard FileUpload] Livewire upload-error event received', customEvent.detail);
                        if (customEvent.detail.name === modelName) {
                            console.error('[Pegboard FileUpload] Upload failed!');
                            this.isLoading = false;
                            this.progress = 0;
                            this.hasError = true;
                        }
                    },
                },
            ];

            this.listeners.forEach(({ event, handler }: { event: string; handler: (e: Event) => void }) => {
                window.addEventListener(event, handler);
            });
        },

        getWireModelName(input: HTMLInputElement): string | null {
            const attrs = Array.from(input.attributes);
            const wireAttr = attrs.find((attr) => attr.name.startsWith('wire:model'));
            return wireAttr?.value ?? null;
        },

        isValidFileType(items: DataTransferItemList | null): boolean {
            const input = this.$refs?.input as HTMLInputElement;

            if (!input || !input.accept || input.accept.trim() === '') {
                return true;
            }

            if (!items || items.length === 0) {
                return true;
            }

            const acceptTypes = input.accept
                .split(',')
                .map((type) => type.trim().toLowerCase());

            for (let i = 0; i < items.length; i++) {
                const item = items[i];

                if (item.kind !== 'file') {
                    continue;
                }

                const fileType = item.type.toLowerCase();

                if (!fileType) {
                    continue;
                }

                const isValid = acceptTypes.some((acceptType) => {
                    if (acceptType.endsWith('/*')) {
                        const baseType = acceptType.slice(0, -2);
                        return fileType.startsWith(baseType + '/');
                    }

                    if (acceptType.includes('/')) {
                        return fileType === acceptType;
                    }

                    if (acceptType.startsWith('.')) {
                        return true;
                    }

                    return false;
                });

                if (!isValid && fileType) {
                    return false;
                }
            }

            return true;
        },

        async processFiles(files: FileList) {
            const fileArray = Array.from(files);
            const processedFiles: SelectedFileMetadata[] = [];

            for (const file of fileArray) {
                const metadata: SelectedFileMetadata = {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                };

                if (file.type.startsWith('image/')) {
                    try {
                        metadata.previewUrl = URL.createObjectURL(file);
                    } catch (error) {
                        console.error('[Pegboard FileUpload] Failed to create preview URL for:', file.name, error);
                    }
                }

                processedFiles.push(metadata);
            }

            this.selectedFiles = processedFiles;
        },

        removeFile(index: number) {
            const input = this.$refs?.input as HTMLInputElement;
            if (!input || !input.files) {
                console.error('[Pegboard FileUpload] Cannot remove file - input element not found');
                return;
            }

            const removedFile = this.selectedFiles[index];
            if (removedFile?.previewUrl) {
                URL.revokeObjectURL(removedFile.previewUrl);
            }

            this.selectedFiles.splice(index, 1);

            const dataTransfer = new DataTransfer();
            const filesArray = Array.from(input.files);

            filesArray.forEach((file, i) => {
                if (i !== index) {
                    dataTransfer.items.add(file);
                }
            });

            input.files = dataTransfer.files;

            input.dispatchEvent(new Event('input', { bubbles: true }));

            if (this.selectedFiles.length === 0) {
                this.hasError = false;
            }
        },

        formatBytes(bytes: number): string {
            if (bytes === 0) return '0 B';

            const units = ['B', 'KB', 'MB', 'GB'];
            const power = Math.floor(Math.log(bytes) / Math.log(1024));
            const clampedPower = Math.min(power, units.length - 1);

            const size = bytes / Math.pow(1024, clampedPower);

            let formatted = size.toFixed(2);
            formatted = formatted.replace(/\.?0+$/, '');

            return `${formatted} ${units[clampedPower]}`;
        },

        openFileSelector() {
            const input = this.$refs?.input as HTMLInputElement;
            if (input) {
                input.click();
            }
        },

        onChange() {
            const input = this.$refs?.input as HTMLInputElement;

            if (!input || !input.files || input.files.length === 0) {
                return;
            }

            this.hasError = false;

            this.processFiles(input.files);

            input.dispatchEvent(new Event('input', { bubbles: true }));
        },

        onDragEnter(event: DragEvent) {
            if (event.dataTransfer?.types.includes('Files')) {
                this.isDragging = true;

                const isValid = this.isValidFileType(event.dataTransfer.items);
                this.isInvalidType = !isValid;
            }
        },

        onDragLeave(event: DragEvent) {
            const dropzone = this.$refs?.dropzone as HTMLElement;
            const relatedTarget = event.relatedTarget as Node | null;

            const isActuallyLeaving = !relatedTarget || !dropzone?.contains(relatedTarget);

            if (isActuallyLeaving) {
                this.isDragging = false;
                this.isInvalidType = false;
            }
        },

        onDragOver(event: DragEvent) {
            event.preventDefault();

            if (event.dataTransfer) {
                event.dataTransfer.dropEffect = this.isInvalidType ? 'none' : 'copy';
            }
        },

        onDrop(event: DragEvent) {
            this.isDragging = false;
            this.isInvalidType = false;

            const input = this.$refs?.input as HTMLInputElement;

            if (!input || !event.dataTransfer?.files) {
                console.warn('[Pegboard FileUpload] Drop event but no input or files found');
                return;
            }

            this.hasError = false;

            const files = event.dataTransfer.files;

            if (files.length === 0) {
                return;
            }

            if (!this.multiple && files.length > 1) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(files[0]);
                input.files = dataTransfer.files;
                this.processFiles(dataTransfer.files);
            } else {
                input.files = files;
                this.processFiles(files);
            }

            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
        },
    }));
}
