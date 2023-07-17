import { computed } from "vue";
import { useStore } from "vuex";

export default function useGetLoginUser(){
    const store = useStore();

    const loginUser = computed(()=>{
        return store.getters.loginUser
    })

    const getLoginUser = ()=>{
        store.dispatch("loginState");
    }

    return {loginUser, getLoginUser};
}