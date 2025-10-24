import type { Alpine, AlpineData } from '../types/alpine';
import type { EditorOptions, EditorState, EditorHeadingLevel } from '../types/components';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Placeholder from '@tiptap/extension-placeholder';
import ImageResize from 'tiptap-extension-resize-image';

export function editor(Alpine: Alpine): void {
    Alpine.data('pegboardEditor', (options: EditorOptions = {}): AlpineData<EditorState> => {
        let editor: Editor | null = null;

        return {
            updatedAt: Date.now(),
            loaded: false,

            init() {
                const _this = this;

                this.$nextTick?.(() => {
                    const editorElement = this.$refs?.editorElement as HTMLElement;

                    if (!editorElement) {
                        return;
                    }

                    editor = new Editor({
                        element: editorElement,
                        extensions: [
                            StarterKit.configure({
                                heading: {
                                    levels: [1, 2, 3],
                                },
                                link: {
                                    openOnClick: false,
                                    HTMLAttributes: {
                                        class: 'text-primary underline',
                                    },
                                },
                            }),
                            Placeholder.configure({
                                placeholder: options.placeholder || 'Start writing...',
                            }),
                            ImageResize.configure({
                                inline: false,
                                allowBase64: true,
                            }),
                        ],
                        content: options.content || '',
                        editable: options.editable ?? true,
                        onCreate() {
                            _this.loaded = true;
                            _this.updatedAt = Date.now();
                            _this.syncToTextarea();
                        },
                        onUpdate() {
                            _this.updatedAt = Date.now();
                            _this.syncToTextarea();
                        },
                        onSelectionUpdate() {
                            _this.updatedAt = Date.now();
                        },
                    });
                });
            },

            destroy() {
                if (editor) {
                    editor.destroy();
                    editor = null;
                }
            },

            isLoaded(): boolean {
                return editor !== null;
            },

            isActive(type: string, attributes?: Record<string, any>): boolean {
                if (!editor) return false;
                return attributes
                    ? editor.isActive(type, attributes)
                    : editor.isActive(type);
            },

            toggleBold() {
                if (!editor) return;
                editor.chain().focus().toggleBold().run();
            },

            toggleItalic() {
                if (!editor) return;
                editor.chain().focus().toggleItalic().run();
            },

            toggleCode() {
                if (!editor) return;
                editor.chain().focus().toggleCode().run();
            },

            toggleHeading(level: EditorHeadingLevel) {
                if (!editor) return;
                editor.chain().focus().toggleHeading({ level }).run();
            },

            toggleBulletList() {
                if (!editor) return;
                editor.chain().focus().toggleBulletList().run();
            },

            toggleOrderedList() {
                if (!editor) return;
                editor.chain().focus().toggleOrderedList().run();
            },

            setLink(url: string) {
                if (!editor) return;

                if (!url) {
                    this.unsetLink();
                    return;
                }

                editor
                    .chain()
                    .focus()
                    .extendMarkRange('link')
                    .setLink({ href: url })
                    .run();
            },

            unsetLink() {
                if (!editor) return;
                editor.chain().focus().unsetLink().run();
            },

            getLinkUrl(): string | null {
                if (!editor) return null;
                const { href } = editor.getAttributes('link');
                return href || null;
            },

            insertImage() {
                const input = this.$refs?.imageInput as HTMLInputElement;
                if (input) {
                    input.click();
                }
            },

            handleImageUpload(event: Event) {
                const input = event.target as HTMLInputElement;
                const file = input.files?.[0];

                if (!file || !editor) return;

                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    const base64 = e.target?.result as string;
                    if (base64 && editor) {
                        editor.chain().focus().setImage({ src: base64 }).run();
                    }

                    input.value = '';
                };

                reader.readAsDataURL(file);
            },

            clearFormatting() {
                if (!editor) return;
                editor.chain().focus().clearNodes().unsetAllMarks().run();
            },

            getContent(): string {
                if (!editor) return '';
                return editor.getHTML();
            },

            setContent(content: string) {
                if (!editor) return;
                editor.commands.setContent(content);
                this.syncToTextarea();
            },

            focus() {
                if (!editor) return;
                editor.commands.focus();
            },

            syncToTextarea() {
                const textareaElement = this.$refs?.textarea as HTMLTextAreaElement;
                if (!editor || !textareaElement) return;

                const content = editor.getHTML();
                textareaElement.value = content;

                textareaElement.dispatchEvent(new Event('input', { bubbles: true }));
            },
        };
    });
}
