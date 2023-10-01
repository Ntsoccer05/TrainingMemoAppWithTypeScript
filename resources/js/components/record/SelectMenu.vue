<template>
  <div>
    <h3 class="text-lg text-center font-bold mt-6">{{ dispHeadText }}</h3>
    <button
      class="block w-50 bg-blue-500 hover:bg-blue-700 text-white font-bold md:py-2 py-px px-4 border-2 border-black mt-3 mb-3 ml-auto rounded-full mr-5"
      @click="toAddMenu()"
    >
      部位・種目を追加する
    </button>
    <button
      :class="[
        'w-50 bg-red-500 hover:bg-red-700 text-white font-bold md:py-2 py-px px-4 border-2 border-black mt-3 mb-3 ml-auto rounded-full mr-5',
        editable ? 'hidden' : 'block',
      ]"
      @click="editMenu()"
    >
      編集／削除する
    </button>
    <button
      :class="[
        'w-50 bg-red-500 hover:bg-red-700 text-white font-bold md:py-2 py-px px-4 border-2 border-black mt-3 mb-3 ml-auto rounded-full mr-5',
        editable ? 'block' : 'hidden',
      ]"
      @click="compEditMenu()"
    >
      編集／削除を終了する
    </button>
    <div :class="['text-right mr-5 md:mr-10', editable ? 'block' : 'hidden']">
      <!---div><i class="fa-solid fa-pen"></i><span>：編集</span></div>--->
      <div><i class="fa-solid fa-trash"></i><span class="font-bold">：削除</span></div>
      <div>
        <span class="font-bold text-red-600">※部位を削除すると種目も削除されます</span>
      </div>
    </div>
    <div class="mx-auto w-11/12 mt-5 mb-5">
      <label for="weight block sm:inline"> 今日の体重：</label>
      <input
        class="border border-black text-right w-28"
        name="weight"
        type="number"
        step="0.1"
        placeholder="kg"
        :value="weight"
        @input="validateWeight($event.target.value)"
        @blur="postWeight"
      />
    </div>

    <!-- :子供のprops名：データ値 -->
    <EditableTableMenu :dispHeadText="dispHeadText" :editable="editable" />
  </div>
</template>

<script>
import EditableTableMenu from "./EditableTableMenu.vue";
import { ref, onMounted, nextTick } from "vue";
import { useRoute, useRouter } from "vue-router";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
import useGetRecordState from "../../composables/record/useGetRecordState";
export default {
  components: {
    EditableTableMenu,
  },
  setup() {
    const router = useRouter();
    const route = useRoute();

    const dispHeadText = ref("鍛える部位を選択してください");

    const weight = ref(null);

    const editable = ref(false);
    // DOM取得のため
    const deleteFunc = ref(null);
    const deleteCategory = ref(null);

    const { getLoginUser, loginUser } = useGetLoginUser();

    const { getLatestRecordState, latestRecord } = useGetRecordState();

    //トレーニングメニュー追加画面に遷移
    const toAddMenu = () => {
      router.push({
        name: "addMenu",
      });
    };

    const editMenu = () => {
      editable.value = true;
      dispHeadText.value = "編集する部位・種目を選択してください";
    };

    const compEditMenu = () => {
      editable.value = false;
      dispHeadText.value = "鍛える部位を選択してください";
    };

    //体重を記録する
    const postWeight = async () => {
      await axios
        .post("/api/record/edit", {
          user_id: loginUser.value.id,
          recording_day: latestRecord.value.recorded_at,
          weight: weight.value,
        })
        .then((res) => {
          console.log(res);
        })
        .catch((err) => {
          console.log(err);
        });
    };

    // valはString
    const validateWeight = (val) => {
      // replaceは型がStringのもののみ適用できる
      val.replace(/\D/g, "");
      // parseFloatで整数型へ変換している
      val = parseFloat(val);
      // toFixedで小数第一位で四捨五入する
      val = parseFloat(val.toFixed(1));
      // matchは型がStringのもののみ適用できる
      val.toString().match(/^(\d+)(\.\d*)?/u) ? val : "";
      weight.value = val;
    };

    onMounted(async () => {
      // DOM取得のため
      const deleteFuncDom = deleteFunc.value;
      const deleteCategoryDom = deleteCategory.value;

      await getLoginUser();
      await getLatestRecordState();
      if (latestRecord.value.bodyWeight) {
        weight.value = latestRecord.value.bodyWeight;
      }
    });

    return {
      dispHeadText,
      editable,
      weight,
      // DOM取得のため
      deleteFunc,
      deleteCategory,
      // メソッド
      toAddMenu,
      editMenu,
      compEditMenu,
      postWeight,
      validateWeight,
    };
  },
};
</script>
