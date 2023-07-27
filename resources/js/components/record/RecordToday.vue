<template>
  <form @submit.prevent="record">
    <button
      type="submit"
      class="block w-11/12 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border-2 border-black mb-8 mx-auto"
    >
      今日のトレーニングを記録する
    </button>
  </form>
</template>

<script>
import { useRouter } from "vue-router";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
import useSelectedDay from "../../composables/record/useSelectedDay";
export default {
  setup() {
    const date = new Date();
    const router = useRouter();

    // 現在時刻を取得する場合
    // const time = `${date
    //   .getHours()
    //   .toString()
    //   .padStart(2, "0")}:${date
    //   .getMinutes()
    //   .toString()
    //   .padStart(2, "0")}:${date.getSeconds().toString().padStart(2, "0")}`;

    const { getLoginUser, loginUser } = useGetLoginUser();

    getLoginUser();
    const { selectedDay, recordingDay, postDay } = useSelectedDay(date);

    selectedDay();

    const record = async () => {
      debugger;
      await axios
        .post("/api/record/create", {
          user_id: loginUser.value.id,
          recording_day: postDay,
        })
        .then((res) => {
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
    return { toSelectMenu, recordingDay, today, loginUser, record };
  },
};
</script>

<style></style>
