import { computed } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

export default function useGetLoginUser(){
    const router = useRouter();
    const store = useStore();

    const isLogined = computed(()=>{
        return store.getters.isLogined
    })

    // ログインしているユーザ情報取得
    const loginUser = computed(()=>{
        return store.getters.loginUser
    })

    const getLoginUser = ()=>{
        if(isLogined){
            store.dispatch("getLoginUser");
        }
    }

    return {loginUser, getLoginUser};
}