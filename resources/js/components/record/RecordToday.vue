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
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
import useSelectedDay from "../../composables/record/useSelectedDay";
export default {
  setup() {
    const date = new Date();
    const router = useRouter();

    const today = `${date.getFullYear()}-${(date.getMonth() + 1)
      .toString()
      .padStart(2, "0")}-${date.getDate().toString().padStart(2, "0")}`;

    const time = `${date
      .getHours()
      .toString()
      .padStart(2, "0")}:${date
      .getMinutes()
      .toString()
      .padStart(2, "0")}:${date.getSeconds().toString().padStart(2, "0")}`;

    const { getLoginUser, loginUser } = useGetLoginUser();

    getLoginUser();
    const { selectedDay, recordingDay } = useSelectedDay(today);

    selectedDay();

    const record = async () => {
      // getLoginUser();
      // selectedDay();
      debugger;
      await axios
        .post("/api/record/create", {
          user_id: loginUser.value.id,
          recorded_at: `${recordingDay.value} ${time}`,
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
