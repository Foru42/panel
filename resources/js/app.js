//import "./bootstrap";
//import "./panel";
//import "./panelNoadmin";
import { createApp } from "vue";
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import Sidebar from "./components/Sidebar.vue";
import Panel from "./components/Panel.vue";

const app = createApp();
app.component("login", Login);
app.component("register", Register);
app.component("sidebar", Sidebar);
app.component("panel", Panel);

app.mount("#app");
