<x-pegboard::file-upload
    :name="$name"
    :label="$label"
    :description="$description"
    :error="$error"
    :disabled="$disabled"
    :accept="$accept"
    :multiple="false"
    {{ $attributes }}
>
    <x-slot:dropzone>
        <div class="relative inline-block">
            <div class="{{ $getSizeClasses() }} relative group">
                <div
                    class="
                        absolute inset-0
                        rounded-full
                        border-2 border-dashed border-border
                        bg-muted/30
                        transition-all duration-fast
                        group-hover:border-primary group-hover:bg-primary/5 group-hover:scale-105
                        flex items-center justify-center
                        cursor-pointer
                        overflow-hidden
                    "
                    :class="{
                        'border-primary bg-primary/10 scale-110': isDragging && !isInvalidType,
                        'border-warning bg-warning/5': isInvalidType,
                        'opacity-50 animate-pulse': isLoading,
                        'border-destructive bg-destructive/5': hasError
                    }"
                >
                    <template x-if="selectedFiles.length > 0 && selectedFiles[0].previewUrl">
                        <img
                            x-bind:src="selectedFiles[0].previewUrl"
                            x-bind:alt="selectedFiles[0].name"
                            class="absolute inset-0 w-full h-full object-cover rounded-full"
                        />
                    </template>

                    <template x-if="selectedFiles.length === 0">
                        <x-pegboard::icon
                            name="user-circle"
                            variant="solid"
                            class="{{ $getIconSizeClasses() }} text-muted-foreground transition-colors duration-fast group-hover:text-primary"
                        />
                    </template>
                </div>

                <div
                    class="
                        absolute -bottom-1 -right-1
                        {{ $getBadgeSizeClasses() }}
                        rounded-full
                        bg-primary
                        border-2 border-background
                        flex items-center justify-center
                        shadow-lg
                        transition-all duration-fast
                        group-hover:scale-110 group-hover:shadow-xl
                        cursor-pointer
                    "
                    :class="{
                        'scale-125 animate-bounce': isDragging
                    }"
                >
                    <x-pegboard::icon
                        name="camera"
                        variant="solid"
                        class="{{ $getCameraIconSizeClasses() }} text-primary-foreground"
                    />
                </div>

                <template x-if="selectedFiles.length > 0">
                    <button
                        type="button"
                        x-on:click.stop="removeFile(0)"
                        class="
                            absolute -top-1 -right-1
                            {{ $getRemoveButtonSizeClasses() }}
                            rounded-full
                            bg-destructive
                            border-2 border-background
                            flex items-center justify-center
                            shadow-lg
                            transition-all duration-fast
                            hover:scale-110 hover:shadow-xl
                            cursor-pointer
                            z-10
                        "
                    >
                        <x-pegboard::icon
                            name="x-mark"
                            variant="solid"
                            class="{{ $getRemoveIconSizeClasses() }} text-destructive-foreground"
                        />
                        <span class="sr-only">Remove image</span>
                    </button>
                </template>

                <div
                    x-show="isLoading"
                    x-cloak
                    class="absolute inset-0 rounded-full bg-background/80 backdrop-blur-sm flex items-center justify-center"
                >
                    <svg class="animate-spin {{ $getIconSizeClasses() }} text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </x-slot:dropzone>

    <x-slot:previews>
    </x-slot:previews>
</x-pegboard::file-upload>
