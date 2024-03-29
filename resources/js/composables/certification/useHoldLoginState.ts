import { ref,nextTick } from "vue";
import { useRouter } from 'vue-router'
import { useStore } from "vuex";
import useNotLoginedRedirect from "./useNotLoginedRedirect";
import axios from "axios";

export default function useHoldLoginState(){
    const router = useRouter();
    const store = useStore();
    const isLogined = ref<boolean>(false);

    //ログイン状態保持するため
    const holdLoginState = async () => {
        // 非同期処理呼び出しのため async await
        await store.dispatch("loginState");
        await axios.get("/api/users")
          .then((res) => {
            // ログイン状態取得
            isLogined.value = true;
          })
          .catch((err) => {
            useNotLoginedRedirect(err)
          })
        // nextTickは非同期処理完了後に呼び出されるのでisLoginedを取得できる
        nextTick(()=>{
            isLogined.value = store.getters.isLogined;
        })
    };

    return {holdLoginState, isLogined};
}