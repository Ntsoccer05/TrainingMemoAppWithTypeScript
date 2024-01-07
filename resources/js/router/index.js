import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/certification/loginPage.vue';
import Register from '../views/certification/registerPage.vue';
import RedirectAuthGoogle from '../components/certification/RedirectAuthGoogle.vue'
import googleRegister from '../views/certification/googleRegister.vue'
import Home from '../views/home.vue';
import SelectMenu from '../views/record/selectMenu.vue';
import Record from '../views/record/recordContents.vue';
import trainingMenuList from '../views/trainingMenuList.vue';
import AddMenu from '../views/menu/addMenu.vue';
import PasswordForget from '../views/certification/passwordForget.vue';
import ResetPassword from '../views/certification/resetPassword.vue';
import Inquiry from '../views/inquiry/inquiry.vue';
import { computed, watch, watchEffect } from 'vue';
// router.jsでVuexの値を取得したい時はuseStore()ではなく以下の形
import store from '../store.js';

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    // ログインの必要なし
    meta: { requiresAuth: false },
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    // ログインの必要なし
    meta: { requiresAuth: false },
  },
  {
    path: '/login/google/callback',
    name: 'RedirectAuthGoogle',
    component: RedirectAuthGoogle,
    // ログインの必要なし
    meta: { requiresAuth: false },
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    // ログインの必要なし
    meta: { requiresAuth: false },
  },
  {
    path: '/api/register/:provider',
    name: 'googleRegister',
    component: googleRegister,
    // ログインの必要なし
    meta: { requiresAuth: false },
  },
  {
    path: '/password/forget',
    name: 'PasswordForget',
    component: PasswordForget,
    // ログインの必要なし
    meta: { requiresAuth: false },
  },
  {
    path: '/api/password/reset',
    name: 'ResetPassword',
    component: ResetPassword,
    // ログインの必要なし
    meta: { requiresAuth: false },
  },
  {
    path: '/inquiry',
    name: 'Inquiry',
    component: Inquiry,
    // ログインの必要なし
    meta: { requiresAuth: false },
  },
  {
    // ?：NULL許容
    path: '/selectMenu/:recordId?',
    name: 'selectMenu',
    component: SelectMenu,
    // ログインの必要あり
    meta: { requiresAuth: true },
  },
  {
    // ?：NULL許容
    path: '/record/:recordId',
    name: 'record',
    component: Record,
    props: true,
    // ログインの必要あり
    meta: { requiresAuth: true },
  },
  {
    path: '/menu/:user_id?/:recordId?',
    name: 'menu',
    component: trainingMenuList,
    props: true,
    // ログインの必要あり
    meta: { requiresAuth: true },
  },
  {
    path: '/addMenu/:recordId?',
    name: 'addMenu',
    component: AddMenu,
    // ログインの必要あり
    meta: { requiresAuth: true },
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

// let isLogined = ""

// watchEffect((isLogined),() => {
//   debugger
//   isLogined = computed(() => store.state.isLogined);
// });
// watch((isLogined),()=>{
//   debugger
//   router.beforeEach((to, from) => {
//     // ログインの必要あり かつ ログインしていなかったら
//     if ((to.meta.requiresAuth && !isLogined.value) || (from.meta.requiresAuth && ! isLogined.value)) {
//       // ホーム画面へ遷移
//       router.push("/")
//     }
//   })
// })
// router.beforeEach((to, from) => {
//   // ログインの必要あり かつ ログインしていなかったら
//   if ((to.meta.requiresAuth && !isLogined.value) || (from.meta.requiresAuth && ! isLogined.value)) {
//     // ホーム画面へ遷移
//     router.push("/")
//   }
// })

export default router;