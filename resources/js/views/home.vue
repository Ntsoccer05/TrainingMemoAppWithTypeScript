<template>
    <div class="h-full mt-8">
        <!-- トレーニング記録画面へ遷移 -->
        <button class="block w-11/12 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border-2 border-black mb-8 mx-auto" @click="toSelectMenu">今日のトレーニングを記録する</button>
        <!-- カレンダーコンポーネント -->
        <Calendar />
    </div>
</template>

<script>
import Calendar from '../components/Calendar.vue'
import {useRouter} from 'vue-router'
export default {
    components:{
        Calendar,
    },
    setup(props) {
        const router = useRouter()
        const toSelectMenu = ()=>{
            // トレーニング記録画面へ遷移
            router.push("/selectMenu");
        };
        return {toSelectMenu};
    }
}
</script>
