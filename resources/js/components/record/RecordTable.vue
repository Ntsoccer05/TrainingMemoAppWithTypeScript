<template>
  <div>
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
  </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
export default {
  props: {
    second_record: Object,
    hasSecondRecord: Boolean,
    record_state_id: Number,
  },
  setup(props) {
    const route = useRoute();
    const hasOneHand = ref(false);

    const second_record = computed(() => props.second_record);

    // メニューはセレクトボックス、休憩時間はタイムピッカー
    const header = {
      set: "セット数",
      menu: "メニュー",
      weight: "重量(kg)",
      rep: "回数",
      rest: "休憩時間",
    };

    //ログインユーザー情報取得
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

    if (props.hasSecondRecord) {
      contents.value = second_record;
      if (contents.value.set < 5) {
        contents.value.set = 5;
      } else {
        contents.value.set = contents.value.set;
      }
    }

    onMounted(async () => {
      await getLoginUser();
      await getMenuContent();
    });

    return { header, contents, hasOneHand };
  },
};
</script>

<style></style>
