import axios from "axios";
import collapse from "@alpinejs/collapse";
import anchor from "@alpinejs/anchor";
import focus from "@alpinejs/focus";
import AutoAnimate from "@marcreichel/alpine-auto-animate";

Alpine.plugin(collapse);
Alpine.plugin(anchor);
Alpine.plugin(focus);
Alpine.plugin(AutoAnimate);

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
