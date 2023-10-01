<template>
  <table class="border border-collapse table-fixed mx-auto">
    <!-- 入れ子で意識すべきことを追加 -->
    <caption
      class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800"
    >
      <!-- <p class="text-lg" ref="menu">種目：{{ menu.content }}</p> -->
      <button
        class="block w-11/12 bg-blue-500 hover:bg-blue-700 text-white font-bold md:py-2 py-px px-4 border-2 border-black mt-3 mb-3 mx-auto"
        @click="fillBeforeRecord"
      >
        前回の記録を埋める
      </button>
      <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
        今日の体重：{{ bodyWeight }}
      </p>
      <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
        今日のトータルセット数：１０セット
      </p>
    </caption>
    <thead>
      <tr>
        <th class="text-left md:text-center indent-1 md:indent-0">
          <div class="border" ref="todayRecordedAt">今回の記録</div>
        </th>
        <th class="text-left md:text-center indent-1 md:indent-0">
          <div class="border" ref="beforeRecordedAt">前回の記録</div>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(content, index) in contents" :key="index">
        <td>
          <div class="bg-gray-200 border indent-1">{{ index + 1 }}セット目</div>
          <div :class="hasOneHand ? 'hidden' : 'block'">
            <input class="border w-full" type="text" placeholder="重さ(kg)" />
            <input class="border w-full" type="text" placeholder="回数" />
          </div>
          <div :class="hasOneHand ? 'block' : 'hidden'">
            <input class="border w-full" type="text" placeholder="重さ（右）(kg)" />
            <input class="border w-full" type="text" placeholder="回数（右）" />
            <input class="border w-full" type="text" placeholder="重さ（左）(kg)" />
            <input class="border w-full" type="text" placeholder="回数（左）" />
          </div>
          <div class="border">
            <textarea
              class="w-full"
              name=""
              id=""
              cols="20"
              placeholder="メモ"
            ></textarea>
          </div>
        </td>
        <td>
          <div class="bg-gray-200 border indent-1">{{ index + 1 }}セット目</div>
          <div :class="hasOneHand ? 'hidden' : 'block'">
            <input
              class="border w-full"
              type="text"
              placeholder="重さ(kg)"
              ref="beforeWeight"
              readonly
            />
            <input
              class="border w-full"
              type="text"
              placeholder="回数"
              ref="beforeReps"
              readonly
            />
          </div>
          <div :class="hasOneHand ? 'block' : 'hidden'">
            <input
              class="border w-full"
              type="text"
              placeholder="重さ（右）(kg)"
              ref="beforeRightWeight"
              readonly
            />
            <input
              class="border w-full"
              type="text"
              placeholder="回数（右）"
              ref="beforeRightReps"
              readonly
            />
            <input
              class="border w-full"
              type="text"
              placeholder="重さ（左）(kg)"
              ref="beforeLeftWeight"
              readonly
            />
            <input
              class="border w-full"
              type="text"
              placeholder="回数（左）"
              ref="beforeLeftReps"
              readonly
            />
          </div>
          <div class="border">
            <textarea
              class="w-full"
              name=""
              id=""
              cols="20"
              placeholder="メモ"
              readonly
              ref="beforeMemo"
            ></textarea>
          </div>
        </td>
      </tr>
    </tbody>
    <div>{{ menu }}</div>
  </table>
</template>

<script>
import { ref, onMounted } from "vue";
import useGetRecordState from "../../composables/record/useGetRecordState";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
import { useRoute } from "vue-router";
export default {
  setup() {
    const route = useRoute();
    const hasOneHand = ref(false);

    const bodyWeight = ref("");

    // メニューはセレクトボックス、休憩時間はタイムピッカー
    const header = {
      set: "セット数",
      menu: "メニュー",
      weight: "重量(kg)",
      rep: "回数",
      rest: "休憩時間",
    };

    const { getLatestRecordState, latestRecord } = useGetRecordState();

    const { getLoginUser, loginUser } = useGetLoginUser();

    // 片方ずつ記録するかどうかmenusテーブルのoneSideカラムにて判断
    const getMenuContent = async () => {
      await axios
        .get("api/menus", {
          params: {
            user_id: loginUser.value.id,
            category_id: route.query.categoryId,
            menu_id: route.query.menuId,
          },
        })
        .then((res) => {
          if (res.data.menu.oneSide === 1) {
            hasOneHand.value = true;
          } else {
            hasOneHand.value = false;
          }
        })
        .catch((err) => [console.log(err)]);
    };

    const contents = ref([
      { set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60 },
      { set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60 },
      { set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60 },
      { set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60 },
      { set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60 },
    ]);

    const beforeContents = ref([
      {
        set: 1,
        menu: "ベンチプレス",
        weight: 100,
        rep: 10,
        rest: 60,
        recorded_at: "2023/03/22",
      },
      {
        set: 1,
        menu: "ベンチプレス",
        weight: 100,
        rep: 10,
        rest: 60,
        recorded_at: "2023/03/22",
      },
      {
        set: 1,
        menu: "ベンチプレス",
        weight: 100,
        rep: 10,
        rest: 60,
        recorded_at: "2023/03/22",
      },
      {
        set: 1,
        menu: "ベンチプレス",
        weight: 100,
        rep: 10,
        rest: 60,
        recorded_at: "2023/03/22",
      },
      {
        set: 1,
        menu: "ベンチプレス",
        weight: 100,
        rep: 10,
        rest: 60,
        recorded_at: "2023/03/22",
      },
    ]);

    const fillBeforeRecord = () => {
      console.log(beforeLeftReps[0].value);
    };

    onMounted(async () => {
      await getLoginUser();
      await getLatestRecordState();
      await getMenuContent();

      if (latestRecord.value.bodyWeight) {
        bodyWeight.value = `${latestRecord.value.bodyWeight} kg`;
      } else {
        bodyWeight.value = "記録されていません";
      }
      // if(menu.oneSide = 1){
      //     hasOneHand.value != hasOneHand.value;
      // }
    });

    return { header, contents, hasOneHand, bodyWeight, fillBeforeRecord };
  },
};
</script>
