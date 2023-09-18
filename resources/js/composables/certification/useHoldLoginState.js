import { ref,nextTick } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";

export default function useHoldLoginState(){
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const isLogined = ref(false);

    //ログイン状態保持するため
    const holdLoginState = async () => {
        // 非同期処理呼び出しのため async await
        await store.dispatch("loginState");

        // nextTickは非同期処理完了後に呼び出されるのでisLoginedを取得できる
        nextTick(()=>{
            isLogined.value = store.getters.isLogined;
            if(!isLogined.value){
                // router.push("/")
            }
        })
    };

    return {holdLoginState, isLogined};
}