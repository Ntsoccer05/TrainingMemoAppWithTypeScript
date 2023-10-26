// setup() 関数内で定義した変数や関数を return しないと template //
内で使用することができなかったが、 script setup>内で宣言した場合すべて使用可能となる
<script setup>
// https://v2.vcalendar.io/attributes.html#_2-scoped-slot
import { onMounted, reactive, ref, nextTick, watch, computed } from "vue";
import { useRouter } from "vue-router";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
import useSelectedDay from "../../composables/record/useSelectedDay";
import useHoldLoginState from "../../composables/certification/useHoldLoginState";
import useGetRecords from "../../composables/record/useGetRecords";

const router = useRouter();
const authUser = ref([]);
// 祝日の情報を取得
const url = "https://holidays-jp.github.io/api/v1/date.json";
const options = { method: "get" };
// 当日をハイライト
const attrs = ref([{ key: "today", highlight: true, dates: new Date() }]);
const selected_at = ref("");

const holidays = ref([]);
const data = ref([]);

const dispMenu = ref([]);
const dispCategory = ref([]);

// script setup内だとDom取得はreturnしなくていい
const calendar = ref(null);

//ログイン状態をリロードしても維持するため
const { holdLoginState, isLogined } = useHoldLoginState();

const { getLoginUser, loginUser } = useGetLoginUser();

const { records, getRecords } = useGetRecords();

watch(records, () => {
  console.log(records.value);
  records.value.forEach((record) => {
    const event = {
      popover: {
        label: record.menu[0].menu_content,
        visibility: "click",
      },
      bar: {
        style: {
          backgroundColor: "red",
        },
      },
      dates: new Date(record.recorded_at.recorded_at),
    };
    attrs.value = [...attrs.value, event];
  });
});

watch(holidays.value, () => {
  holidays.value.forEach((holiday) => {
    const obj = {
      dot: true,
      // Text styles
      content: "red",
      dates: new Date(holiday),
    };
    attrs.value = [...attrs.value, obj];
  });
});

const changeDayFormat = (day) => {
  // 年-月-日の形に修正
  day = day.replace("日", "");
  day = day.replace(/年|月/g, "-");
  const date = new Date(day);
  day = `${date.getFullYear().toString()}-${(date.getMonth() + 1)
    .toString()
    .padStart(2, "0")}-${date.getDate().toString().padStart(2, "0")}`;
  // records.value.forEach((record) => {
  //   if (day === record.recorded_at.recorded_at) {
  //     debugger;
  //     record.menu.forEach((tgtMenu) => {
  //       dispMenu.value = [...dispMenu.value, tgtMenu.menu_content];
  //     });
  //     record.category.forEach((tgtCategorry) => {
  //       dispCategory.value = [...dispCategory.value, tgtCategorry.category_content];
  //     });
  //   }
  // });
  return day;
};

//ログインしているかの判別をする場合DOMが生成されていない状態だとログイン状態を判別できないため
//getLoginUser はApp.vueで行う
onMounted(async () => {
  await getLoginUser();
  getHolidays();
  await holdLoginState();
  if (loginUser.value.id) {
    await getRecords(loginUser.value.id);
  }

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
  if (isLogined.value === false) {
    alert("ログインしてください");
    return;
  }
  if (day.ariaLabel !== null) {
    // 年-月-日の形に修正
    day = day.ariaLabel.split("日");
    day = day[0].replace(/年|月/g, "-");
    // day.selected = true;
    //ログインしていなかったらメッセージを表示
    selected_at.value = day;
    const isRecord = ref(false);
    records.value.forEach((record) => {
      if (record.recorded_at.recorded_at === day) {
        isRecord.value = true;
      }
    });
    //レコードがあればPOST送信しない
    if (isRecord.value === true) {
      return;
    }
    const { postDay } = useSelectedDay(selected_at.value);
    // 日付クリック時にPOST送信する
    selectedDayRecord(postDay);
  }
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
</script>

<template>
  <div class="calendar container md:w-11/12 ml:h-2/3 mx-auto">
    <!-- $event.targetでクリックした要素を取得できる -->
    <v-calendar
      ref="calendar"
      locale="ja-jp"
      :attributes="attrs"
      @click="selectedDay($event.target)"
    >
      <!-- Calendarの中に以下でもタイトル名変更可能
          :masks = masks -->
      <!-- タイトル変更：header-titleのslot-scopeの中のpropを利用 (#はv-slotの省略記法) -->
      <template #header-title="props">
        {{ props.yearLabel }}年 {{ props.monthLabel }}
      </template>
      <!-- day-contentのslot-scopeの中のpropの中にdayがある ← 分割代入 -->
      <!-- <template #day-content="{ day }"> -->
      <template #day-popover="{ day, format, masks }">
        <div class="text-xs text-gray-300 font-semibold text-center">
          {{ format(day.date, masks.L) }}
        </div>
        <div class="text-xs text-gray-300 font-semibold text-center">鍛えた部位</div>
        <div class="text-xs text-gray-300 font-semibold text-center">
          <span v-for="record in records" :key="record.recorded_at.recorded_at">
            <template
              v-if="
                record.recorded_at.recorded_at ==
                changeDayFormat(format(day.date, masks.L))
              "
              ><span
                v-for="(category, index) in record.category"
                :key="category.category_id"
              >
                <template v-if="category.category_content">
                  <template
                    v-if="
                      index !=
                      Object.keys(record.category)[
                        Object.keys(record.category).length - 1
                      ]
                    "
                  >
                    {{ category.category_content }}、
                  </template>
                  <!-- 最後の値を表示 -->
                  <template
                    v-else-if="
                      index ==
                      Object.keys(record.category)[
                        Object.keys(record.category).length - 1
                      ]
                    "
                  >
                    {{ category.category_content }}
                  </template>
                </template>
                <template v-else> <span>登録なし</span> </template>
              </span></template
            >
          </span>
        </div>
        <div class="text-xs text-gray-300 font-semibold text-center">メニュー</div>
        <span v-for="record in records" :key="record.recorded_at.recorded_at">
          <template
            v-if="
              record.recorded_at.recorded_at == changeDayFormat(format(day.date, masks.L))
            "
            ><span v-for="(menu, index) in record.menu" :key="menu.menu_id">
              <template v-if="menu.menu_content">
                <template
                  v-if="
                    index != Object.keys(record.menu)[Object.keys(record.menu).length - 1]
                  "
                >
                  {{ menu.menu_content }}、
                </template>
                <!-- 最後の値を表示 -->
                <template
                  v-else-if="
                    index == Object.keys(record.menu)[Object.keys(record.menu).length - 1]
                  "
                >
                  {{ menu.menu_content }}
                </template>
              </template>
              <template v-else> <span>登録なし</span> </template>
            </span></template
          >
        </span>
        <div class="flex flex-col items-center justify-center mt-2">
          <button
            class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
          >
            詳細へ
          </button>
        </div>
      </template>
    </v-calendar>
  </div>
</template>

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
.vc-container::v-deep(.weekday-7 span),
.vc-container::v-deep(.vc-weekday:nth-child(7)) {
  color: blue !important;
}

/* 日曜日を赤色 */
.vc-container::v-deep(.weekday-1 span.vc-day-content),
.vc-container::v-deep(.vc-weekday:nth-child(1)) {
  color: red;
}

/* ドットを無効化 */
.vc-container::v-deep(.vc-dots) {
  display: none;
}

/* 祝日を赤色に変更 */
.vc-container::v-deep(.vc-day:has(.vc-dots) span) {
  color: red !important;
}
</style>
