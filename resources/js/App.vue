<template>
  <div class="m-0 p-0 h-screen">
    <Header />
    <router-view />
  </div>
</template>

<script>
import Header from "./components/Header.vue";
export default {
  components: {
    Header,
  },
};
</script>

<style>
/* autocomplete時に入力エリアの色が変わるのを阻止 */
input:-webkit-autofill,
textarea:-webkit-autofill,
select:-webkit-autofill {
  -webkit-box-shadow: 0 0 0 1000px white inset !important;
  -webkit-text-fill-color: black !important;
}
</style>
