<template>
  <div class="m-0 p-0 h-screen">
    <Header />
    <router-view />
  </div>
</template>

<script>
import { onMounted } from "vue";
import Header from "./components/menuList/Header.vue";
import useHoldLoginState from "./composables/certification/useHoldLoginState";
import useGetLoginUser from "./composables/certification/useGetLoginUser.js";

export default {
  components: {
    Header,
  },
  setup() {
    //ログイン状態をリロードしても維持するため
    const { holdLoginState } = useHoldLoginState();

    // async await を使わないとユーザ情報取得する前にMountedサイクルが終了してしまう
    onMounted(async () => {
      await holdLoginState();
    });

    return { holdLoginState };
  },
};
</script>

<style>
/* autocomplete時に入力エリアの色が変わるのを阻止 */
input:-webkit-autofill,
textarea:-webkit-autofill,
select:-webkit-autofill {
  box-shadow: 0 0 0 1000px white inset !important;
  -webkit-text-fill-color: black !important;
}
</style>
