<template>
    <div class="m-0 p-0 h-screen">
        <Header />
        <router-view />
    </div>
</template>

<script>
import Header from './components/Header.vue'
export default {
    components:{
      Header,
    }
}
</script>

<style scoped>

</style>