import './bootstrap';
import '../css/app.css'

import { createApp } from "vue";
import App from "./App.vue";
import router from './router/index';
import VCalendar from 'v-calendar';
import 'v-calendar/dist/style.css';

const app = createApp(App);
app.use(VCalendar);
app.use(router);
app.mount("#app");
