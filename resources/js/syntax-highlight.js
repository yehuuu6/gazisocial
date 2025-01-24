import { Alpine } from "../../vendor/livewire/livewire/dist/livewire.esm";
import "highlight.js/styles/github.css";
import hljs from "highlight.js/lib/core";
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

Alpine.data("highlightCode", () => {
    hljs.registerLanguage("javascript", javascript);
    hljs.registerLanguage("cpp", cpp);
    hljs.registerLanguage("python", python);
    hljs.registerLanguage("php", php);
    hljs.registerLanguage("java", java);
    hljs.registerLanguage("css", css);
    hljs.registerLanguage("xml", xml);
    hljs.registerLanguage("json", json);
    hljs.registerLanguage("typescript", typescript);
    hljs.registerLanguage("bash", bash);
    hljs.registerLanguage("sql", sql);
    hljs.registerLanguage("shell", shell);
    hljs.registerLanguage("rust", rust);
    hljs.registerLanguage("yaml", yaml);

    hljs.highlightAll();
});
