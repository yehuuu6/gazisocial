import "./bootstrap";
import "./editor";

import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import collapse from "@alpinejs/collapse";
import anchor from "@alpinejs/anchor";
import focus from "@alpinejs/focus";
import AutoAnimate from "@marcreichel/alpine-auto-animate";
import Clipboard from "@ryangjchandler/alpine-clipboard";
import hljs from "highlight.js";
import "highlight.js/styles/atom-one-light.css";

Alpine.plugin(collapse);
Alpine.plugin(anchor);
Alpine.plugin(focus);
Alpine.plugin(AutoAnimate);
Alpine.plugin(Clipboard);

Livewire.start();
