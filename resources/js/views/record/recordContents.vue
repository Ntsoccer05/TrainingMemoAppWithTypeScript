<script setup>
import recordContents from "../../components/record/recordContents.vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import { computed, onMounted } from "vue";

const router = useRouter();
const store = useStore();

const isLogined = computed(() => store.getters.isLogined);
onMounted(() => {
  // debugger;
  // ログインしていなかったらホーム画面へ遷移する処理はApp.vueにてまとめた
  // if (!isLogined.value) {
  //   router.push("/");
  // }
});
</script>

<template>
  <recordContents></recordContents>
</template>
