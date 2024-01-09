import { ref,nextTick } from "vue";
import { useStore } from "vuex";

export default function useGetLoginUser(){
    const store = useStore();
    const loginUser = ref([]);

    // async await を使わないとDOM生成後のonMountedのタイミングでも早すぎてユーザ情報を取得できない
    const getLoginUser = async ()=>{
        await store.dispatch("getLoginUser");
        // ログインしているユーザ情報取得
        // nextTickは非同期処理完了後に呼び出されるのでloginUserを取得できる
        nextTick(()=>{
            loginUser.value = store.getters.loginUser;
        })
    }

    return {loginUser, getLoginUser};
}