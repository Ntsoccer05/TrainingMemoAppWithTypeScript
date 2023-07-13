import { data } from 'autoprefixer';
import axios from 'axios';
import {createStore, storeKey} from 'vuex';

export default createStore({
    state:{
        user:[],
        isLogined: false
    },
    mutations:{
      LoginState(state){
        // ログイン状態
        state.isLogined = true;
      },
      LogoutState(state){
        // ログアウト状態
        state.isLogined = false;
      }
    },
    actions:{
        async loginState({state}) {
          await axios.get("/api/users")
          .then((res) => {
            // ログインしているユーザー情報取得
            state.user = res.data
            // ログイン状態取得
            state.isLogined = true;
          })
          .catch((err) => {
            // ログイン状態取得
            state.isLogined = false;
          })}
    }
})