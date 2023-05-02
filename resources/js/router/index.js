import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/home.vue';
import Record from '../views/recordContents.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/record',
    name: 'record',
    component: Record
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;