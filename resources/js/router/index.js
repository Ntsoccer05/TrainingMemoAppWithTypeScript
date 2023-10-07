import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/certification/loginPage.vue';
import Register from '../views/certification/registerPage.vue';
import RedirectAuthGoogle from '../components/certification/RedirectAuthGoogle.vue'
import googleRegister from '../views/certification/googleRegister.vue'
import Home from '../views/home.vue';
import SelectMenu from '../views/record/selectMenu.vue';
import Record from '../views/record/recordContents.vue';
import trainingMenuList from '../views/trainingMenuList.vue';
import AddMenu from '../views/menu/addMenu.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/login/google/callback',
    name: 'RedirectAuthGoogle',
    component: RedirectAuthGoogle
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  },
  {
    path: '/api/register/:provider',
    name: 'googleRegister',
    component: googleRegister
  },
  {
    // ?：NULL許容
    path: '/selectMenu',
    name: 'selectMenu',
    component: SelectMenu
  },
  {
    // ?：NULL許容
    path: '/record/:categoryId?/:menuId?/:recordId?',
    name: 'record',
    component: Record,
    props: true
  },
  {
    path: '/menu/:user_id?',
    name: 'menu',
    component: trainingMenuList,
    props: true
  },
  {
    path: '/addMenu/',
    name: 'addMenu',
    component: AddMenu,
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