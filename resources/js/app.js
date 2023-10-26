
import './bootstrap';
import '../css/app.css'

import { createApp } from "vue";
import App from "./App.vue";
import router from './router/index';
import VCalendar from 'v-calendar';
import { Calendar, DatePicker } from 'v-calendar';
import 'v-calendar/dist/style.css';
import store from './store'

const app = createApp(App);
app.component('VCalendar', Calendar)
app.use(VCalendar).use(router).use(store);
app.mount("#app");
