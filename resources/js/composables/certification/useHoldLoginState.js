import { ref,nextTick } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";

export default function useHoldLoginState(){
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const isLogined = ref(false);
    const canRedirect = ref(false);

    // ログインしていなかったらホーム画面へ遷移する処理はrouter.jsにて実行(ここだとうまく機能しない)
    // const notLoginedRedirect=()=>{
    //     if(route.name==="selectMenu" || route.name==="record" || route.name==="trainingMenuList" || route.name==="AddMenu"){
    //         canRedirect.value=true;
    //     }else{
    //         canRedirect.value=false;
    //     }
    // }

    //ログイン状態保持するため
    const holdLoginState = async () => {
        // 非同期処理呼び出しのため async await
        await store.dispatch("loginState");
        await axios.get("/api/users")
          .then((res) => {
            // ログイン状態取得
            isLogined.value = true;
            // ログインしているユーザー情報取得
            // state.user = res.data;
          })
          .catch((err) => {
            // ログイン状態取得
            isLogined.value = false;
          })
        // nextTickは非同期処理完了後に呼び出されるのでisLoginedを取得できる
        nextTick(()=>{
            isLogined.value = store.getters.isLogined;
            // router.jsにて実行(ここだとうまく機能しない)
            // notLoginedRedirect();
            // if(!isLogined.value && canRedirect.value){
            //     router.push("/")
            // }
        })
    };

    return {holdLoginState, isLogined};
}