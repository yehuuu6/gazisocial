import "./bootstrap";
import "../../vendor/masmerise/livewire-toaster/resources/js";
import "./tags-lister";

import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import collapse from "@alpinejs/collapse";
import anchor from "@alpinejs/anchor";
import focus from "@alpinejs/focus";
import Clipboard from "@ryangjchandler/alpine-clipboard";

Alpine.plugin(collapse);
Alpine.plugin(anchor);
Alpine.plugin(focus);
Alpine.plugin(Clipboard);

Livewire.start();
