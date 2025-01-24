import { Markdown } from "tiptap-markdown";
import { Alpine } from "../../vendor/livewire/livewire/dist/livewire.esm";
import { Editor } from "@tiptap/core";
import { Link } from "@tiptap/extension-link";
import StarterKit from "@tiptap/starter-kit";
import Placeholder from "@tiptap/extension-placeholder";
import { CodeBlockLowlight } from "@tiptap/extension-code-block-lowlight";
import { common, createLowlight } from "lowlight";

document.addEventListener("alpine:init", () => {
    Alpine.data("editor", (content) => {
        let editor; // Alpine's reactive engine automatically wraps component properties in proxy objects. If you attempt to use a proxied editor instance to apply a transaction, it will cause a "Range Error: Applying a mismatched transaction", so be sure to unwrap it using Alpine.raw(), or simply avoid storing your editor as a component property, as shown in this example.

        return {
            updatedAt: Date.now(), // force Alpine to rerender on selection change
            init() {
                const _this = this;

                editor = new Editor({
                    element: this.$refs.element,
                    extensions: [
                        StarterKit.configure({
                            heading: {
                                levels: [2, 3, 4],
                            },
                            codeBlock: false,
                        }),
                        CodeBlockLowlight.configure({
                            lowlight: createLowlight(common),
                        }),
                        Placeholder.configure({
                            // Use a placeholder:
                            placeholder: "Düşüncelerinizi buraya yazın...",
                        }),
                        Link,
                        Markdown,
                    ],
                    editorProps: {
                        attributes: {
                            class: "prose prose-base sm:prose-sm md:prose-base lg:prose-lg max-w-none min-h-[312px] px-3 py-2 focus:outline-indigo-500",
                        },
                    },
                    content: content,
                    onCreate({ editor }) {
                        _this.updatedAt = Date.now();
                    },
                    onUpdate({ editor }) {
                        _this.content = editor.storage.markdown.getMarkdown();
                        _this.updatedAt = Date.now();
                    },
                    onSelectionUpdate({ editor }) {
                        _this.updatedAt = Date.now();
                    },
                });
            },
            isLoaded() {
                return editor;
            },
            isActive(type, opts = {}) {
                return editor.isActive(type, opts);
            },
            toggleBold() {
                editor.chain().focus().toggleBold().run();
            },
            toggleItalic() {
                editor.chain().toggleItalic().focus().run();
            },
            toggleStrike() {
                editor.chain().focus().toggleStrike().run();
            },
            toggleQuote() {
                editor.chain().focus().toggleBlockquote().run();
            },
            toggleBulletList() {
                editor.chain().focus().toggleBulletList().run();
            },
            toggleOrderedList() {
                editor.chain().focus().toggleOrderedList().run();
            },
            toggleHeading(opts) {
                editor.chain().toggleHeading(opts).focus().run();
            },
            promptUserForHref() {
                if (editor.isActive("link")) {
                    return editor.chain().focus().unsetLink().run();
                }

                const href = window.prompt("Enter the URL");
                if (!href) return editor.chain().focus().run();
                editor
                    .chain()
                    .focus()
                    .extendMarkRange("link")
                    .setLink({ href })
                    .run();
            },
            toggleCodeBlock() {
                editor.chain().focus().toggleCodeBlock().run();
            },
        };
    });
});
