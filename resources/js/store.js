import { data } from 'autoprefixer';
import axios from 'axios';
import {createStore, storeKey} from 'vuex';

export default createStore({
    state:{
        user:[],
        isLogined: false,
        day: ""
    },
    getters:{
      isLogined:state => state.isLogined,
      loginUser:state => state.user,
      selectedDay:state => state.day
    },
    mutations:{
      LoginState(state){
        // ログイン状態
        state.isLogined = true;
      },
      LogoutState(state){
        // ログアウト状態
        state.isLogined = false;
      },
      selectedDay(state, day){
        state.day = day
      }
    },
    actions:{
        async loginState({state}) {
        await axios.get("/api/users")
          .then((res) => {
            // ログイン状態取得
            state.isLogined = true;
            // ログインしているユーザー情報取得
            state.user = res.data;
          })
          .catch((err) => {
            // ログイン状態取得
            state.isLogined = false;
          })
        },

        async getLoginUser({state}) {
          await axios.get("/api/users")
          .then((res) => {
            // ログインしているユーザー情報取得
            state.user = res.data;
          })
          .catch((err) => {
            // ログインしていない状態だとホーム画面へリダイレクト
          })
        }
    }
})