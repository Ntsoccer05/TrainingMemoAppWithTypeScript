<template>
  <div class="h-full mt-8">
    <!-- トレーニング記録画面へ遷移 -->
    <RecordToday />
    <!-- TODO バーの種類をv-forで回す 内容はcategoryから取得 -->
    <div class="bar-kind w-full mt-2 mb-2">
      <!-- <div class="category-1 flex items-center mb-1">
                <div class="event-bar1 h-0.5 w-5 bg-red-600 ml-auto"></div>
                <p class="text-sm mr-2">：背筋</p>
            </div>
            <div class="category-2 flex items-center">
                <div class="event-bar2 h-0.5 w-5 bg-blue-600 ml-auto"></div>
                <p class="text-sm mr-2">：胸トレ</p>
            </div> -->
      <div class="category-1 grid grid-cols-4 ml-10 md:ml-96 items-center mb-1">
        <div class="event-bar1 h-0.5 w-5 bg-red-600 col-start-3 ml-auto"></div>
        <p class="text-sm col-start-4">：背筋</p>
      </div>
      <div class="category-2 grid grid-cols-4 ml-10 md:ml-96 items-center">
        <div class="event-bar2 h-0.5 w-5 bg-blue-600 col-start-3 ml-auto"></div>
        <p class="text-sm col-start-4">：胸トレ</p>
      </div>
    </div>
    <!-- カレンダーコンポーネント -->
    <Calendar />
  </div>
</template>

<script>
import Calendar from "../components/record/Calendar.vue";
import RecordToday from "../components/record/RecordToday.vue";
import { useRouter } from "vue-router";
export default {
  components: {
    RecordToday,
    Calendar,
  },
  setup(props) {
    const router = useRouter();
    const toSelectMenu = () => {
      // トレーニング記録画面へ遷移
      router.push("/selectMenu");
    };
    return { toSelectMenu };
  },
};
</script>
