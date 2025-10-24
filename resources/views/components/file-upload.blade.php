@php
    $inputId = $attributes->get('id') ?? 'file-upload-' . uniqid();
    $inputName = $name ?? $attributes->wire('model')->value() ?? 'file';
@endphp

<div
    x-data="fileUpload({
        multiple: {{ $multiple ? 'true' : 'false' }},
        disabled: {{ $disabled ? 'true' : 'false' }}
    })"
    data-pegboard-file-upload
    data-pegboard-file-upload-id="{{ $inputId }}"
    class="w-full"
>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-foreground mb-2">
            {{ $label }}
        </label>
    @endif

    <input
        x-ref="input"
        x-init="Object.defineProperty($el, 'value', {
            ...Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value'),
            set(value) {
                Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value').set.call(this, value);
                if(!value) this.dispatchEvent(new Event('change', { bubbles: true }));
            }
        })"
        type="file"
        id="{{ $inputId }}"
        name="{{ $inputName }}"
        :multiple="multiple"
        :disabled="disabled"
        @change="onChange"
        @if($accept) accept="{{ $accept }}" @endif
        data-pegboard-file-input
        class="sr-only"
        {{ $attributes->except(['class', 'id', 'name', 'multiple', 'disabled', 'accept']) }}
    />

    <div
        x-ref="dropzone"
        data-pegboard-dropzone
        :data-pegboard-dragging="isDragging && !isInvalidType ? '' : undefined"
        :data-pegboard-invalid-type="isInvalidType ? '' : undefined"
        :data-pegboard-loading="isLoading ? '' : undefined"
        :data-pegboard-error="hasError ? '' : undefined"
        @click.stop="openFileSelector"
        @keydown.enter.prevent="openFileSelector"
        @keydown.space.prevent="openFileSelector"
        @dragenter.prevent="onDragEnter"
        @dragleave.prevent="onDragLeave"
        @dragover.prevent="onDragOver"
        @drop.prevent="onDrop"
        role="button"
        :tabindex="disabled ? -1 : 0"
        aria-label="{{ $label ?? 'Upload files' }}"
        :aria-busy="isLoading ? 'true' : 'false'"
        :aria-disabled="disabled ? 'true' : 'false'"
        class="relative"
        :class="{ 'pointer-events-none opacity-50': disabled }"
    >
        @if ($dropzone ?? false)
            {{ $dropzone }}
        @else
            <x-pegboard::file-upload.dropzone
                heading="Drop files here or click to browse"
                :text="$accept ? 'Accepted: ' . $accept : 'Select files to upload'"
            />
        @endif
    </div>

    @if($description)
        <p class="mt-2 text-sm text-muted-foreground">
            {{ $description }}
        </p>
    @endif

    @if($error)
        <p class="mt-2 text-sm text-destructive">
            {{ $error }}
        </p>
    @endif

    @if (isset($previews))
        {{ $previews }}
    @else
        <template x-if="selectedFiles.length > 0">
            <div class="mt-4 space-y-2">
                <template x-for="(file, index) in selectedFiles" :key="index">
                    <div
                        data-pegboard-file-item
                        class="flex items-center gap-3 p-3 rounded-lg border border-border bg-card transition-colors duration-fast hover:bg-muted/50"
                    >
                        <div class="flex-shrink-0">
                            <template x-if="file.previewUrl">
                                <img
                                    x-bind:src="file.previewUrl"
                                    x-bind:alt="file.name"
                                    class="h-10 w-10 rounded object-cover"
                                />
                            </template>
                            <template x-if="!file.previewUrl">
                                <div class="h-10 w-10 rounded bg-muted flex items-center justify-center">
                                    <x-pegboard::icon
                                        name="document"
                                        variant="outline"
                                        class="h-5 w-5 text-muted-foreground"
                                    />
                                </div>
                            </template>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-foreground truncate" x-text="file.name"></p>
                            <p class="text-xs text-muted-foreground" x-text="formatBytes(file.size)"></p>
                        </div>

                        <div class="flex-shrink-0 flex items-center gap-1">
                            <button
                                type="button"
                                x-on:click="removeFile(index)"
                                class="inline-flex items-center justify-center h-8 w-8 rounded-md text-muted-foreground hover:text-destructive hover:bg-destructive/10 transition-colors duration-fast cursor-pointer"
                            >
                                <x-pegboard::icon name="x-mark" variant="mini" class="h-4 w-4" />
                                <span class="sr-only">Remove file</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    @endif
</div>
