import { Markdown } from "tiptap-markdown";
import { Alpine } from "../../vendor/livewire/livewire/dist/livewire.esm";
import { Editor } from "@tiptap/core";
import { Link } from "@tiptap/extension-link";
import StarterKit from "@tiptap/starter-kit";
import Underline from "@tiptap/extension-underline";
import Placeholder from "@tiptap/extension-placeholder";
import { CodeBlockLowlight } from "@tiptap/extension-code-block-lowlight";
import { createLowlight } from "lowlight";
import javascript from "highlight.js/lib/languages/javascript";
import cpp from "highlight.js/lib/languages/cpp";
import python from "highlight.js/lib/languages/python";
import php from "highlight.js/lib/languages/php";
import java from "highlight.js/lib/languages/java";
import css from "highlight.js/lib/languages/css";
import xml from "highlight.js/lib/languages/xml";
import json from "highlight.js/lib/languages/json";
import typescript from "highlight.js/lib/languages/typescript";
import bash from "highlight.js/lib/languages/bash";
import sql from "highlight.js/lib/languages/sql";
import shell from "highlight.js/lib/languages/shell";
import rust from "highlight.js/lib/languages/rust";
import yaml from "highlight.js/lib/languages/yaml";

import "highlight.js/styles/github.css";

Alpine.data("editor", (content) => {
    let editor; // Alpine's reactive engine automatically wraps component properties in proxy objects. If you attempt to use a proxied editor instance to apply a transaction, it will cause a "Range Error: Applying a mismatched transaction", so be sure to unwrap it using Alpine.raw(), or simply avoid storing your editor as a component property, as shown in this example.

    return {
        updatedAt: Date.now(), // force Alpine to rerender on selection change
        init() {
            const _this = this;

            // Get the dom element with the attribute contenteditable="true"
            const editorInstance = this.$refs.element.querySelector(
                "[contenteditable='true']"
            );

            if (editorInstance) {
                editorInstance.remove();
            }

            editor = new Editor({
                element: this.$refs.element,
                autofocus: true,
                extensions: [
                    StarterKit.configure({
                        heading: {
                            levels: [2, 3, 4],
                        },
                        codeBlock: false,
                    }),
                    CodeBlockLowlight.configure({
                        lowlight: createLowlight({
                            javascript,
                            cpp,
                            python,
                            php,
                            java,
                            css,
                            xml,
                            json,
                            typescript,
                            bash,
                            sql,
                            shell,
                            rust,
                            yaml,
                            // Add more languages here if needed.
                        }),
                    }),
                    Placeholder.configure({
                        // Use a placeholder:
                        placeholder: "Düşüncelerinizi buraya yazın...",
                    }),
                    Link,
                    Markdown,
                    Underline,
                ],
                editorProps: {
                    attributes: {
                        class: "prose prose-sm sm:prose-sm md:prose-base lg:prose-lg max-w-none h-[312px] md:h-[486px] overflow-y-auto px-3 py-2 outline-none",
                    },
                },
                content: content,
                onCreate() {
                    _this.updatedAt = Date.now();
                },
                onUpdate({ editor }) {
                    _this.content = editor.storage.markdown.getMarkdown();
                    _this.updatedAt = Date.now();
                },
                onSelectionUpdate() {
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
        toggleUnderline() {
            editor.chain().focus().toggleUnderline().run();
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

            const href = window.prompt("Bağlantı adresini girin:");
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
