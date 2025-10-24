@php
    $editorOptions = json_encode([
        'content' => $content,
        'editable' => $editable,
        'placeholder' => $placeholder,
        'name' => $name,
    ]);
@endphp

<div
    class="pegboard-editor-wrapper border border-border rounded-md overflow-hidden bg-card transition-all duration-fast focus-within:outline-none focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2"
    x-data="pegboardEditor({{ $editorOptions }})"
    data-pegboard-editor
>
    <div
        x-show="loaded"
        x-cloak
        class="pegboard-editor-toolbar flex flex-wrap items-center gap-1 p-2 border-b border-border bg-muted/30"
        data-pegboard-editor-toolbar
        role="toolbar"
        aria-label="Text formatting">
            <button
                type="button"
                @click="toggleBold()"
                :class="isActive('bold', {}, updatedAt) ? 'bg-primary text-primary-foreground' : 'bg-transparent text-foreground hover:bg-muted'"
                class="flex items-center justify-center h-8 w-8 rounded transition-colors duration-fast"
                title="Bold (Ctrl+B)"
                aria-label="Toggle bold"
            >
                <x-pegboard::icon name="bold" variant="micro" class="h-4 w-4" />
            </button>

            <button
                type="button"
                @click="toggleItalic()"
                :class="isActive('italic', {}, updatedAt) ? 'bg-primary text-primary-foreground' : 'bg-transparent text-foreground hover:bg-muted'"
                class="flex items-center justify-center h-8 w-8 rounded transition-colors duration-fast"
                title="Italic (Ctrl+I)"
                aria-label="Toggle italic"
            >
                <x-pegboard::icon name="italic" variant="micro" class="h-4 w-4" />
            </button>

            <button
                type="button"
                @click="toggleCode()"
                :class="isActive('code', {}, updatedAt) ? 'bg-primary text-primary-foreground' : 'bg-transparent text-foreground hover:bg-muted'"
                class="flex items-center justify-center h-8 w-8 rounded transition-colors duration-fast"
                title="Code (Ctrl+E)"
                aria-label="Toggle code"
            >
                <x-pegboard::icon name="code-bracket" variant="micro" class="h-4 w-4" />
            </button>

            <x-pegboard::separator orientation="vertical" class="h-6 mx-1" />

            <button
                type="button"
                @click="toggleHeading(1)"
                :class="isActive('heading', { level: 1 }, updatedAt) ? 'bg-primary text-primary-foreground' : 'bg-transparent text-foreground hover:bg-muted'"
                class="flex items-center justify-center h-8 px-2 rounded transition-colors duration-fast text-sm font-semibold"
                title="Heading 1"
                aria-label="Toggle heading 1"
            >
                H1
            </button>

            <button
                type="button"
                @click="toggleHeading(2)"
                :class="isActive('heading', { level: 2 }, updatedAt) ? 'bg-primary text-primary-foreground' : 'bg-transparent text-foreground hover:bg-muted'"
                class="flex items-center justify-center h-8 px-2 rounded transition-colors duration-fast text-sm font-semibold"
                title="Heading 2"
                aria-label="Toggle heading 2"
            >
                H2
            </button>

            <button
                type="button"
                @click="toggleHeading(3)"
                :class="isActive('heading', { level: 3 }, updatedAt) ? 'bg-primary text-primary-foreground' : 'bg-transparent text-foreground hover:bg-muted'"
                class="flex items-center justify-center h-8 px-2 rounded transition-colors duration-fast text-sm font-semibold"
                title="Heading 3"
                aria-label="Toggle heading 3"
            >
                H3
            </button>

            <x-pegboard::separator orientation="vertical" class="h-6 mx-1" />

            <button
                type="button"
                @click="toggleBulletList()"
                :class="isActive('bulletList', {}, updatedAt) ? 'bg-primary text-primary-foreground' : 'bg-transparent text-foreground hover:bg-muted'"
                class="flex items-center justify-center h-8 w-8 rounded transition-colors duration-fast"
                title="Bullet list"
                aria-label="Toggle bullet list"
            >
                <x-pegboard::icon name="list-bullet" variant="micro" class="h-4 w-4" />
            </button>

            <button
                type="button"
                @click="toggleOrderedList()"
                :class="isActive('orderedList', {}, updatedAt) ? 'bg-primary text-primary-foreground' : 'bg-transparent text-foreground hover:bg-muted'"
                class="flex items-center justify-center h-8 w-8 rounded transition-colors duration-fast"
                title="Numbered list"
                aria-label="Toggle ordered list"
            >
                <x-pegboard::icon name="numbered-list" variant="micro" class="h-4 w-4" />
            </button>

            <x-pegboard::separator orientation="vertical" class="h-6 mx-1" />

            <button
                type="button"
                @click="() => {
                    const url = prompt('Enter URL:', getLinkUrl() || 'https://');
                    if (url) setLink(url);
                }"
                :class="isActive('link', {}, updatedAt) ? 'bg-primary text-primary-foreground' : 'bg-transparent text-foreground hover:bg-muted'"
                class="flex items-center justify-center h-8 w-8 rounded transition-colors duration-fast"
                title="Insert link"
                aria-label="Insert or edit link"
            >
                <x-pegboard::icon name="link" variant="micro" class="h-4 w-4" />
            </button>

            <template x-if="isActive('link', {}, updatedAt)">
                <button
                    type="button"
                    @click="unsetLink()"
                    class="flex items-center justify-center h-8 w-8 rounded bg-transparent text-foreground hover:bg-muted transition-colors duration-fast"
                    title="Remove link"
                    aria-label="Remove link"
                >
                    <x-pegboard::icon name="link-slash" variant="micro" class="h-4 w-4" />
                </button>
            </template>

            <x-pegboard::separator orientation="vertical" class="h-6 mx-1" />

            <button
                type="button"
                @click="insertImage()"
                class="flex items-center justify-center h-8 w-8 rounded bg-transparent text-foreground hover:bg-muted transition-colors duration-fast"
                title="Insert image"
                aria-label="Insert image"
            >
                <x-pegboard::icon name="photo" variant="micro" class="h-4 w-4" />
            </button>

            <button
                type="button"
                @click="clearFormatting()"
                class="flex items-center justify-center h-8 w-8 rounded bg-transparent text-foreground hover:bg-muted transition-colors duration-fast"
                title="Clear formatting"
                aria-label="Clear formatting"
            >
                <x-pegboard::icon name="strikethrough" variant="micro" class="h-4 w-4" />
            </button>
    </div>

    <div
        x-ref="editorElement"
        wire:ignore
        class="min-h-[200px] p-4 max-w-none focus:outline-none"
        data-pegboard-editor-content
    ></div>

    <template x-if="loaded">
        <div
            x-show="false"
            class="pegboard-editor-bubble-menu hidden"
            data-pegboard-editor-bubble-menu
        >
        </div>
    </template>

    <input
        x-ref="imageInput"
        type="file"
        accept="image/*"
        @change="handleImageUpload($event)"
        class="sr-only"
        tabindex="-1"
        aria-hidden="true"
    />

    <textarea
        x-ref="textarea"
        :name="name || '{{ $name }}'"
        {{ $attributes->except(['class']) }}
        class="sr-only"
        tabindex="-1"
        aria-hidden="true"
    ></textarea>
</div>
