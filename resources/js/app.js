import './bootstrap';

import { createApp } from "vue";
import App from "./App.vue";
import router from './router/index';
import { SetupCalendar } from 'v-calendar';

const app = createApp(App);
app.use([SetupCalendar, router]);

app.mount("#app");
