<template>
  <form @submit.prevent="record">
    <button
      type="submit"
      class="block w-11/12 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border-2 border-black mb-8 mx-auto"
      @click="alertLogin"
    >
      今日のトレーニングを記録する
    </button>
  </form>
</template>

<script>
import { onMounted, ref, nextTick } from "vue";
import { useRouter } from "vue-router";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
import useSelectedDay from "../../composables/record/useSelectedDay";
import useHoldLoginState from "../../composables/certification/useHoldLoginState";
export default {
  setup() {
    const date = new Date();
    const router = useRouter();
    const authUser = ref([]);

    // 現在時刻を取得する場合
    // const time = `${date
    //   .getHours()
    //   .toString()
    //   .padStart(2, "0")}:${date
    //   .getMinutes()
    //   .toString()
    //   .padStart(2, "0")}:${date.getSeconds().toString().padStart(2, "0")}`;

    //ログイン状態をリロードしても維持するため
    const { holdLoginState, isLogined } = useHoldLoginState();

    const { getLoginUser, loginUser } = useGetLoginUser();
    // getLoginUser();
    //ログインしているかの判別をする場合DOMが生成されていない状態だとログイン状態を判別できないため
    //getLoginUser はApp.vueで行う
    onMounted(async () => {
      // onMounted(() => {
      await getLoginUser();
      await holdLoginState();

      // 画面生成後のタイミングでしかユーザ情報取得できないため
      // window.onload = () => {
      //   authUser.value = loginUser;
      // };

      // nextTickはonMounted内の処理完了後に呼び出されるのでloginUserを取得できる
      // nextTick(() => {
      //   authUser.value = loginUser;
      // });

      // getLoginUser()内でnextTickを実行
      authUser.value = loginUser;
    });

    //ログインしていなかったらメッセージを表示
    const alertLogin = () => {
      if (isLogined.value === false) {
        alert("ログインしてください");
      }
    };

    const { selectedDay, recordingDay, postDay } = useSelectedDay(date);

    selectedDay();

    const record = async () => {
      await axios
        .post("/api/record/create", {
          user_id: loginUser.value.id,
          recording_day: postDay,
        })
        .then((res) => {
          console.log(res);
          router.push("/selectMenu");
        })
        .catch((err) => {
          console.log(err);
        });
    };

    const toSelectMenu = () => {
      // トレーニング記録画面へ遷移
      router.push("/selectMenu");
    };
    return { recordingDay, loginUser, toSelectMenu, record, alertLogin };
  },
};
</script>

<style></style>
