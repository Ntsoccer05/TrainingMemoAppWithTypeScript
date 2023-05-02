<template>
    <div class="bg-gray-500 h-12 md:h-16">
        <header class="container mx-auto text-white relative z-10">
            <div class="flex justify-between items-center fixed w-full bg-gray-500 px-2 h-12 md:h-16">
                <h1 class="text-2xl font-semibold md:text-4xl" @click="toHome">HR</h1>
                <div>
                    <button @click="isOpen = !isOpen" class="focus:outline-none md:hidden">
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path v-show="!isOpen" d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/>
                            <path v-show="isOpen" d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/>
                        </svg>                       
                    </button>
                </div>
                <!-- ハンバーガーメニューの開閉(app.css) -->
                <div :class="isOpen ? 'show-toggleMenu' : 'hidden-toggleMenu'">
                    <ul class="md:flex md:justify-between md:items-center md:mr-1 md: m-auto lg:mr-0">
                        <li class="border-b md:mr-auto md:border-none"><a href="#" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded">HRとは</a></li>
                        <li class="border-b md:border-none"><a href="#" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded">機能一覧</a></li>
                        <li class="border-b md:border-none"><a href="#" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded">料金プラン</a></li>
                        <li class="border-b md:border-none"><a href="#" class="block px-8 py-2 my-4 hover:bg-gray-600 rounded">お知らせ</a></li>
                        <li>
                            <div class="my-8 text-center md:my-4">
                                <a href="#" class="px-6 py-2 bg-orange-500 hover:bg-orange-400 rounded-full">お問い合わせ</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    </div>
</template>
<script>
import { ref } from 'vue';
import {useRouter} from 'vue-router'
export default {
    setup() {
        const router = useRouter()
        let isOpen = ref(false);
        const toggleNav = () => (isOpen.value = !isOpen.value);
        const toHome = () => (router.push('/'))
        return { isOpen, toggleNav, toHome };
    },
};
</script>

<style>

</style>