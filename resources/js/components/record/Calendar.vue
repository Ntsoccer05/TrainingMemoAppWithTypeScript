<template>
  <div class="calendar container md:w-11/12 ml:h-2/3 mx-auto">
    <v-calendar ref="calendar" locale="ja-jp" :attributes="attrs">
      <!-- Calendarの中に以下でもタイトル名変更可能
          :masks = masks -->
      <!-- タイトル変更：header-titleのslot-scopeの中のpropを利用 (#はv-slotの省略記法) -->
      <template #header-title="props">
        {{ props.yearLabel }}年 {{ props.monthLabel }}
      </template>
      <!-- day-contentのslot-scopeの中のpropの中にdayがある ← 分割代入 -->
      <!-- <template #day-content="{ day }"> -->
      <template #day-content="props">
        <template v-if="props.day.inMonth">
          <span
            type="submit"
            tabindex="-1"
            :aria-label="props.day.ariaLabel"
            role="button"
            class="vc-day-content vc-focusable mx-auto"
            @click="selectedDay(props.day)"
          >
            <!-- templateタグにはkeyは設定できないのでその中のtemplate以外の要素にkeyを指定 -->
            <template v-for="holiday in holidays">
              <template v-if="holiday === props.day.id">
                <span class="isHoliday" :key="holiday"></span>
              </template>
            </template>
            <span role="button" type="submit">{{ props.day.day }}</span>
          </span>
        </template>
      </template>
    </v-calendar>
  </div>
</template>
<script>
// https://v2.vcalendar.io/attributes.html#_2-scoped-slot
import { onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
import useSelectedDay from "../../composables/record/useSelectedDay";
export default {
  setup() {
    const router = useRouter();
    const authUser = ref([]);
    // 祝日の情報を取得
    const url = "https://holidays-jp.github.io/api/v1/date.json";
    const options = { method: "get" };
    // 当日をハイライト
    const attrs = ref([
      { key: "today", highlight: true, dates: new Date() },
      // TODO recordから日付と鍛えた部位を取得
      {
        bar: true,
        name: "test",
        dates: [new Date("2023-05-01T11:00:00"), new Date("2022-05-01T15:00:00")],
      },
      {
        bar: "red",
        name: "test",
        dates: [new Date("2023-05-01T11:00:00"), new Date("2022-05-01T15:00:00")],
      },
      {
        bar: true,
        name: "テスト",
        dates: [new Date("2023-05-07"), new Date("2023-05-09")],
      },
    ]);
    const selected_at = ref("");

    const holidays = ref([]);
    const data = ref([]);

    const { getLoginUser, loginUser } = useGetLoginUser();

    //ログインしているかの判別をする場合DOMが生成されていない状態だとログイン状態を判別できないため
    //getLoginUser はApp.vueで行う
    onMounted(async () => {
      //   await getLoginUser();
      // 画面生成後のタイミングでしかユーザ情報取得できないため
      window.onload = () => {
        authUser.value = loginUser;
      };
    });

    const selectedDayRecord = async (day) => {
      await axios
        .post("/api/record/create", {
          user_id: loginUser.value.id,
          recording_day: day,
        })
        .then((res) => {
          router.push({ name: "selectMenu", params: { day: day.id } });
        })
        .catch((err) => {
          console.log(err);
        });
    };

    const selectedDay = (day) => {
      selected_at.value = day.id;
      const { postDay } = useSelectedDay(selected_at.value);
      // 日付クリック時にPOST送信する
      selectedDayRecord(postDay);
    };

    const getHolidays = async () => {
      // 祝日の情報を取得
      await fetch(url, options).then((response) => {
        data.value = response.json();
        data.value.then((val) => {
          for (const days in val) {
            holidays.value.push(days);
          }
        });
      });
    };

    onMounted(() => {
      getHolidays();
    });

    return { attrs, holidays, selectedDay, selectedDayRecord };
  },
};
</script>

<style scoped>
.vc-container {
  width: 100%;
  height: 100%;
}
/* ::v-deepで他のファイル要素にも反映 */
.vc-container::v-deep(.vc-pane-layout) {
  height: 100%;
}
.vc-container::v-deep(.vc-weeks) {
  height: 90%;
  align-items: center;
}
/* ヘッダークリック時のポップアップのタイトルに「年」を追加 */
.vc-container::v-deep(.vc-nav-title::after) {
  content: "年";
}
/* 土曜日を青色 */
.weekday-7 span,
.vc-weekday:nth-child(7) {
  color: blue;
}

/* 日曜日を赤色 */
.weekday-1 span,
.vc-weekday:nth-child(1),
.holiday {
  color: red;
}

/* 祝日を赤色に */
.isHoliday + span {
  color: red;
}
</style>
