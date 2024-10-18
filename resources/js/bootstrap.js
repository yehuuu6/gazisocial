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

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
