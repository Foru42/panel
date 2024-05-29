import { createApp } from "vue";

import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import Sidebar from "./components/Sidebar.vue";
import Panel from "./components/Panel.vue";
import VueLazyload from "vue-lazyload";
import "./bootstrap";

const app = createApp();
app.use(VueLazyload, {
    preLoad: 1.3,
    error: "/img/error.png",
    loading: "/img/karga.gif",
    attempt: 1,
});
// Registra tus componentes
app.component("login", Login);
app.component("register", Register);
app.component("sidebar", Sidebar);
app.component("panel", Panel);

app.mount("#app");
