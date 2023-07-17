<template>
  <button
    class="block w-11/12 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border-2 border-black mb-8 mx-auto"
    @click="toSelectMenu"
  >
    今日のトレーニングを記録する
  </button>
</template>

<script>
import { ref } from "vue";
import { useRouter } from "vue-router";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
export default {
  setup() {
    const date = new Date();
    const router = useRouter();

    const today = `${date.getFullYear()}/${date.getMonth() + 1}/${date.getDate()}`;

    const { getLoginUser, loginUser } = useGetLoginUser();

    const record = () => {};

    const toSelectMenu = () => {
      // トレーニング記録画面へ遷移
      router.push("/selectMenu");
    };
    return { toSelectMenu, getMonth, getDay, today };
  },
};
</script>

<style></style>
