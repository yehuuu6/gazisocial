import { Editor } from "@tiptap/core";
import StarterKit from "@tiptap/starter-kit";
import { Markdown } from "tiptap-markdown";
import { Link } from "@tiptap/extension-link";

window.setupEditor = function (content) {
    console.log("setupEditor");
    let editor;
    return {
        updatedAt: Date.now(), // force Alpine to rerender on selection change
        init(element) {
            const _this = this;
            editor = new Editor({
                element: element,
                extensions: [
                    StarterKit.configure({
                        heading: {
                            levels: [3, 4, 5],
                        },
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
                onUpdate: ({ editor }) => {
                    _this.content = editor.storage.markdown.getMarkdown();
                    _this.updatedAt = Date.now();
                },
                onCreate({ editor }) {
                    _this.updatedAt = Date.now();
                },
                onSelectionUpdate({ editor }) {
                    _this.updatedAt = Date.now();
                },
            });

            this.$watch("content", (content) => {
                if (content === editor.storage.markdown.getMarkdown()) return;
                editor.commands.setContent(content, false);
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
    };
};
