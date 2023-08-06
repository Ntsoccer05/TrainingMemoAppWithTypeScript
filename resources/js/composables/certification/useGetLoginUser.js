import { ref,computed } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

export default function useGetLoginUser(){
    const router = useRouter();
    const store = useStore();
    const loginUser = ref([]);

    // const isLogined = store.getters.isLogined;

    // async await を使わないとDOM生成後のonMountedのタイミングでも早すぎてユーザ情報を取得できない
    const getLoginUser = async ()=>{
        // routes\api.phpでの設定でログインしていないとユーザ情報がとれないのでログインしているかの判別は必要ない
        // if(isLogined){
        //     store.dispatch("getLoginUser");
        //     // ログインしているユーザ情報取得 gettersではcomputedは要らない
        //     loginUser.value = computed(()=>store.getters.loginUser)
        // }
        await store.dispatch("getLoginUser");
        // ログインしているユーザ情報取得
        loginUser.value = store.getters.loginUser;
    }

    // const loginUser = computed(()=>{
    //     return store.getters.loginUser
    // })

    return {loginUser, getLoginUser};
}