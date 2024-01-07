<script setup>
import SelectMenu from "../../components/record/SelectMenu.vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import { computed, onMounted } from "vue";

const router = useRouter();
const store = useStore();

const isLogined = computed(() => store.getters.isLogined);
onMounted(() => {
  // ログインしていなかったらホーム画面へ遷移する処理はApp.vueにてまとめた
  if (!isLogined.value) {
    router.push("/");
  }
});
</script>

<template>
  <div>
    <SelectMenu />
  </div>
</template>
