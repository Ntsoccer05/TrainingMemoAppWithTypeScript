<template>
  <div>
    <template v-if="!editable">
      <h3 class="text-lg text-center font-bold mt-4">鍛える部位を選択してください</h3>
    </template>
    <template v-else>
      <h3 class="text-lg text-center font-bold mt-4">編集する種目を選択してください</h3>
    </template>
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
      種目を編集／削除する
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
    </div>
    <div class="md:flex md:items-start md:flex-wrap">
      <table
        v-for="category in categories"
        :key="category.id"
        class="border border-collapse table-fixed mx-auto mt-3 md:w-5/12 w-11/12"
      >
        <thead>
          <tr>
            <th class="border">{{ category.content }}</th>
          </tr>
        </thead>
        <tbody>
          <tr class="relative" v-for="menu in category.menus" :key="menu.id">
            <td
              :class="['border', editable ? '' : 'hover:bg-gray-200']"
              @click="toRecordContents(category, menu)"
            >
              <span :class="[editable ? 'hidden' : 'block']">{{ menu.content }} </span>
              <div :class="['grid grid-cols-12 gap-2', editable ? 'block' : 'hidden']">
                <!--- @blurでPOSTする -->
                <input
                  @blur="postEditMenu(category, menu)"
                  type="text"
                  v-model="menu.content"
                  class="border-2 col-span-11"
                />
                <!---
                <i
                  class="fa-solid fa-pen ml-auto"
                >
                </i>
                --->
                <button class="mr-1" @click="deleteMenu(menu.id, category.id)">
                  <i class="fa-solid fa-trash mt-2"></i>
                </button>
              </div>
              <div
                class="hidden"
                ref="deleteFunc"
                :menu_id="menu.id"
                :category_id="category.id"
              >
                <div class="absolute top-0 bg-gray-400 w-full h-full opacity-80"></div>
                <div
                  class="absolute grid top-0 grid-cols-12 justify-center align-center w-full h-full"
                >
                  <div class="md:col-span-1 xl:col-span-3"></div>
                  <p
                    class="text-sm xl:text-base col-start-1 col-span-6 md:col-span-5 mt-1 md:mt-1.5 xl:mt-1 text-white font-bold"
                  >
                    種目を削除しますか？
                  </p>
                  <button
                    @click="deleteMenuContent(category, menu)"
                    class="text-sm xl:text-base col-span-3 md:col-span-3 xl:col-span-2 rounded-2xl font-bold bg-white mt-0.5 md:mt-1.5 xl:mt-1 ml-1 mr-1 sm:mr-2 h-5 xl:h-6 text-red-600"
                  >
                    削除する
                  </button>
                  <button
                    @click="cancelClick(category, menu)"
                    class="text-sm xl:text-base col-span-3 md:col-span-3 xl:col-span-2 ml-1 sm:ml-2 sm:mr-2 rounded-2xl font-bold bg-white mt-0.5 md:mt-1.5 xl:mt-1 h-5 xl:h-6 text-black"
                  >
                    キャンセル
                  </button>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, nextTick } from "vue";
import { useRoute, useRouter } from "vue-router";
import useGetLoginUser from "../../composables/certification/useGetLoginUser.js";
export default {
  setup() {
    const router = useRouter();
    const route = useRoute();

    const editable = ref(false);
    // DOM取得のため
    const deleteFunc = ref(null);

    //以下の形でデータが入っている。
    const categories = ref([]);
    // const categories = [
    //   {
    //     id: 1,
    //     name: "胸",
    //     menus: [
    //       { id: 1, category_id: 1, category: "胸", content: "ベンチプレス", oneSide: 0 },
    //     ],
    //   },
    //   {
    //     id: 2,
    //     name: "背中",
    //     menus: [
    //       {
    //         id: 1,
    //         category_id: 2,
    //         category: "背中",
    //         content: "ワンハンドローイング",
    //         oneSide: 1,
    //       },
    //     ],
    //   },
    // ];
    const { getLoginUser, loginUser } = useGetLoginUser();

    //トレーニングメニュー追加画面に遷移
    const toAddMenu = () => {
      router.push({
        name: "addMenu",
      });
    };

    const editMenu = () => {
      editable.value = true;
    };

    const compEditMenu = () => {
      editable.value = false;
    };

    //トレーニング記録画面に遷移
    const toRecordContents = (category, menu) => {
      if (!editable.value) {
        router.push({
          name: "record",
          params: route.params,
          query: { category_id: category.id, menu_id: menu.id },
        });
      } else {
        return;
      }
    };

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

    //「本当に削除しますか？」ダイアログを表示/非表示
    const deleteMenu = (menuId, categoryId) => {
      const menu_id = menuId;
      const category_id = categoryId;
      for (const menu of deleteFunc.value) {
        if (
          menu_id == menu.attributes.menu_id.value &&
          category_id == menu.attributes.category_id.value
        ) {
          menu.className = "block";
        } else {
          menu.className = "hidden";
        }
      }
    };

    // メニュー内容を削除
    const deleteMenuContent = async (category, menu) => {
      if (category !== undefined && menu !== undefined) {
        debugger;
        await axios
          .post("/api/menus/delete", {
            user_id: loginUser.value.id,
            category_id: category.id,
            menu_id: menu.id,
            content: menu.content,
          })
          .then((res) => {
            for (const menu of deleteFunc.value) {
              if (menu.className == "block") {
                menu.className = "hidden";
              }
            }
            getMenus();
          })
          .catch((err) => {
            console.log(err);
          });
      }
    };

    // 削除するのをキャンセルする
    const cancelClick = (category, menu) => {
      if (category !== undefined && menu !== undefined) {
        for (const menu of deleteFunc.value) {
          if (menu.className == "block") {
            menu.className = "hidden";
          }
        }
      }
    };

    //メニュー内容を編集する
    const postEditMenu = async (category, menu) => {
      if (category !== undefined && menu !== undefined) {
        await axios
          .post("/api/menus/update", {
            user_id: loginUser.value.id,
            category_id: category.id,
            menu_id: menu.id,
            content: menu.content,
          })
          .then((res) => {
            console.log(res);
          })
          .catch((err) => {
            console.log(err);
          });
      }
    };

    onMounted(async () => {
      // DOM取得のため
      const deleteFuncDom = deleteFunc.value;
      await getLoginUser();

      getMenus();
      //動的に要素を追加したものに対する処理にはnextTickを用いる
      nextTick(() => {
        cancelClick();
        postEditMenu();
        deleteMenuContent();
      });
    });

    return {
      categories,
      editable,
      // DOM取得のため
      deleteFunc,
      // メソッド
      toRecordContents,
      toAddMenu,
      editMenu,
      compEditMenu,
      deleteMenu,
      postEditMenu,
      deleteMenuContent,
      cancelClick,
    };
  },
};
</script>
