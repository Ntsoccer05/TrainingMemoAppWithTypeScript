<script setup>
import trainingMenuList from "../components/trainingMenu/trainingMenuList.vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import { computed } from "vue";

const router = useRouter();
const store = useStore();

const isLogined = computed(() => store.getters.isLogined);
if (!isLogined.value) {
  router.push("/");
}
</script>

<template>
  <trainingMenuList />
</template>

<style></style>
