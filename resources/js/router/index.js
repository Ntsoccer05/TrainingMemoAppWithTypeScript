import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/home.vue';
import SelectMenu from '../views/selectMenu.vue'
import Record from '../views/recordContents.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    // ?：NULL許容
    path: '/selectMenu/:day?',
    name: 'selectMenu',
    component: SelectMenu
  },
  {
    path: '/record/:day?',
    name: 'record',
    component: Record,
    props: true
  },
  //指定のないURLの場合ホームにリダイレクト
  {
    path: '/:paths(.*)*',
    name: 'nothing',
    redirect: '/'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition){
    if (savedPosition && to.path === '/selectMenu' && from.path === '/record') {
      return savedPosition
    } else {
      return { top: 0 }
    }
  }
});

export default router;