<template>
  <div class="mt-10">
    <template v-if="isInputMenu">
      <div class="addPart text-center md:grid grid-cols-2">
        <label for="addPart" class="text-bold mt-3 justify-self-end"
          >追加する部位を記入してください：</label
        >
        <div class="addPart grid grid-cols-3">
          <input
            class="bg-slate-100 border-black border-x border-y mt-3 justify-self-start self-start"
            id="addPart"
            type="text"
            v-model="addCategory"
            required
          />
          <!-- <div class="addPart w-24 justify-self-start ml-3">
            <button
              class="bg-blue-500 text-white w-24 rounded-md ml-2 mb-1"
              @click="addPartContent"
            >
              追加する
            </button>
            <button
              class="bg-red-500 text-white w-24 rounded-md ml-2"
              @click="cancelAddPart"
            >
              キャンセル
            </button>
          </div> -->
        </div>
        <p :class="dispCategoryErrMsg">{{ errors.category_content }}</p>
      </div>
    </template>
    <template v-else>
      <div class="addPart text-center md:grid grid-cols-2">
        <label for="addPart" class="bold justify-self-end"
          >追加する部位を選択してください：</label
        >
        <select
          id="addPart"
          v-model="selectedCategory"
          ref="addPart"
          @change="toggleBtnInput"
          class="bg-slate-200 border-black border-x border-y justify-self-start"
          required
        >
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.content }}
          </option>
          <option ref="addPartBtn" class="block">
            <button>新規追加する</button>
          </option>
          <!-- <option ref="addPartInput" class="hidden">
            <input type="text" placeholder="追加する部位を入力してください" />
          </option> -->
        </select>
        <p :class="dispCategoryErrMsg">{{ errors.category_content }}</p>
      </div>
      <div class="md:grid text-center grid-cols-2 mt-10">
        <label for="exercise" class="text-bold justify-self-end"
          >追加する種目を記入してください：</label
        >
        <input
          class="bg-slate-100 border-black border-x border-y justify-self-start"
          id="exercise"
          type="text"
          v-model="addMenu"
          required
        />
        <p :class="dispMenuErrMsg">{{ errors.menu }}</p>
      </div>
      <div class="md:grid text-center md:grid-cols-6 xl:grid-cols-9 mt-5">
        <input
          class="bg-slate-100 border-black border-x border-y md:col-start-3 xl:col-start-4 md:mr-0 xl:mr-2 mr-2 justify-self-end"
          id="separate"
          type="checkbox"
          v-model="sepereteRecord"
        />
        <label for="separate" class="text-bold">左右別々で記録する</label>
      </div>
    </template>
    <div class="addPart grid grid-cols-2 mt-10 w-full">
      <button
        class="bg-blue-500 text-white w-24 h-8 rounded-md mr-5 mb-1 justify-self-end"
        @click="addMenuContent"
      >
        追加する
      </button>
      <button
        class="bg-red-500 text-white w-24 rounded-md ml-5 justify-self-start"
        @click="cancelAddMenu"
      >
        キャンセル
      </button>
    </div>
  </div>
</template>

<script>
import { ref, reactive, onMounted, nextTick } from "vue";
import { useRoute, useRouter } from "vue-router";
import useValidationMsg from "../../composables/menu/useValidationMsg";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
import dispValidationMsg from "../../composables/menu/useDispValidationMsg";
export default {
  setup() {
    const router = useRouter();
    const route = useRoute();

    const editable = ref(false);

    const errors = reactive({
      category_content: [],
      menu: [],
    });
    const dispErrorMsg = reactive({
      category_content: false,
      menu: false,
    });

    const post = reactive({});

    //以下の形でデータが入っている。
    const categories = ref([]);

    const selectedCategory = ref("");
    const addCategory = ref("");
    const addMenu = ref("");
    const sepereteRecord = ref(false);

    const isInputMenu = ref(false);

    // DOM取得(Returnに追記しないとDOM取得できない)
    const addPart = ref(null);
    const addPartBtn = ref(null);
    // const addPartInput = ref(null);

    //バリデーションエラーメッセージのレイアウト
    const { dispCategoryErrMsg, dispMenuErrMsg } = dispValidationMsg(dispErrorMsg);

    const toggleBtnInput = () => {
      if (selectedCategory.value == "新規追加する") {
        isInputMenu.value = true;

        //バリデーションメッセージを初期化
        dispErrorMsg.category_content = false;
        dispErrorMsg.menu = false;
        //バリデーションエラーメッセージのレイアウト
        const { dispCategoryErrMsg, dispMenuErrMsg } = dispValidationMsg(dispErrorMsg);
        return { dispCategoryErrMsg, dispMenuErrMsg };
        // addPart.value.replaceWith(datalist);
        // addPart.value.size = addPart.value.length - 1;
        // addPartBtn.value.className = "hidden";
        // addPartInput.value.className = "block";
      }
    };

    // START 今回使用しない
    // const addPartContent = async () => {
    //   await axios
    //     .post("/api/menus/store", {
    //       user_id: loginUser.id,
    //       category: selectedCategory,
    //     })
    //     .then((res) => {
    //       console.log(res);
    //       if (selectedCategory.value == "新規追加する") {
    //         isInputMenu.value = false;
    //         // この状態だとDOMにセレクトボックスがないためaddPartは取得できないためv-modelの状態を初期化することでセレクトボックスの中身を初期化できる
    //         selectedCategory.value = "";
    //       }
    //     })
    //     .catch((err) => {
    //       console.log(err);
    //     });
    // };
    // const cancelAddPart = () => {
    //   if (selectedCategory.value == "新規追加する") {
    //     isInputMenu.value = false;
    //     // この状態だとDOMにセレクトボックスがないためaddPartは取得できないためv-modelの状態を初期化することでセレクトボックスの中身を初期化できる
    //     selectedCategory.value = "";
    //   }
    // };
    // END 今回使用しない

    // 追加するボタン押下時
    const addMenuContent = async () => {
      if (isInputMenu.value === true) {
        post.user_id = loginUser.value.id;
        if (addCategory.value === "") {
          post.category_content = false;
        } else {
          post.category_content = addCategory.value;
        }
      } else {
        post.user_id = loginUser.value.id;
        post.category_content = "";
        post.category_id = selectedCategory.value;
        post.menu = addMenu.value;
        post.oneSide = sepereteRecord.value;
      }
      await axios
        .post("/api/menus/store", post)
        .then((res) => {
          if (res.data.status === 400) {
            // POST時のバリデーションエラー
            const errorMsgs = res.data.errors;
            useValidationMsg(errorMsgs, errors, dispErrorMsg);
            //バリデーションエラーメッセージのレイアウト
            const { dispCategoryErrMsg, dispMenuErrMsg } = dispValidationMsg(
              dispErrorMsg
            );
            return { dispCategoryErrMsg, dispMenuErrMsg };
          }
          if (selectedCategory.value == "新規追加する") {
            isInputMenu.value = false;
            // この状態だとDOMにセレクトボックスがないためaddPartは取得できないためv-modelの状態を初期化することでセレクトボックスの中身を初期化できる
            selectedCategory.value = "";
            addCategory.value = "";
            getMenus();
          } else {
            if (addMenu.value !== "") {
              addMenu.value = "";
            }
            //前の画面へ戻りたいため
            history.back();
            router.push({ name: "selectMenu" });
          }
        })
        .catch((err) => {
          // POST時のバリデーションエラー
          console.log(err);
          const errorMsgs = err.response.data.errors;
          useValidationMsg(errorMsgs, errors, dispErrorMsg);
        });
    };

    // キャンセルボタン押下時
    const cancelAddMenu = () => {
      if (selectedCategory.value == "新規追加する") {
        isInputMenu.value = false;
        // この状態だとDOMにセレクトボックスがないためaddPartは取得できないためv-modelの状態を初期化することでセレクトボックスの中身を初期化できる
        selectedCategory.value = "";

        //バリデーションメッセージを初期化
        dispErrorMsg.category_content = false;
        dispErrorMsg.menu = false;
        //バリデーションエラーメッセージのレイアウト
        const { dispCategoryErrMsg, dispMenuErrMsg } = dispValidationMsg(dispErrorMsg);
        return { dispCategoryErrMsg, dispMenuErrMsg };
      } else {
        addMenu.value = "";
        //前の画面へ戻りたいため
        history.back();
        // router.push({ name: "selectMenu" });
      }
    };

    const { getLoginUser, loginUser } = useGetLoginUser();

    //メニュー内容を取得
    const getMenus = async () => {
      await axios
        .get("/api/menus", {
          // get時にパラメータを渡す際はparamsで指定が必要
          params: {
            user_id: loginUser.value.id,
          },
        })
        .then((res) => {
          categories.value = res.data.categorylist;
          // console.log(categories.value);
        })
        .catch((err) => {
          console.log(err);
        });
    };

    onMounted(async () => {
      // DOM取得のため
      const addPartDom = addPart.value;

      await getLoginUser();

      getMenus();
      //動的に要素を追加したものに対する処理にはnextTickを用いる
      nextTick(() => {
        const addPartBtnDom = addPartBtn.value;
        // const addPartInputDom = addPartInput.value;
        toggleBtnInput();
        // addPartContent();
        // cancelAddPart();
      });
    });

    return {
      categories,
      selectedCategory,
      errors,
      addMenu,
      sepereteRecord,
      addCategory,
      addPart,
      addPartBtn,
      // addPartInput,
      isInputMenu,
      dispCategoryErrMsg,
      dispMenuErrMsg,
      toggleBtnInput,
      // addPartContent,
      // cancelAddPart,
      cancelAddMenu,
      addMenuContent,
    };
  },
};
</script>

<style></style>
