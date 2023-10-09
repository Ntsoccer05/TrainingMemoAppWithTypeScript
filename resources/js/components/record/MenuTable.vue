<template>
  <div class="md:flex md:items-start md:flex-wrap md:justify-center">
    <table
      v-for="category in categories"
      :key="category.id"
      class="border border-collapse table-fixed mx-auto mt-3 md:w-5/12 w-11/12"
    >
      <thead>
        <tr class="relative">
          <th class="border">
            <span class="block">{{ category.content }}</span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="relative" v-for="menu in category.menus" :key="menu.id">
          <td class="border">
            <span class="ml-2 block">{{ menu.content }} </span>
          </td>
        </tr>
      </tbody>
    </table>
    <template v-if="isOdd">
      <table
        class="border border-collapse table-fixed mx-auto mt-3 md:w-5/12 w-11/12"
      ></table>
    </template>
  </div>
</template>

<script>
import { ref, computed, watch, watchEffect } from "vue";
export default {
  props: {
    categories: Object,
  },
  setup(props) {
    const categories = ref(computed(() => props.categories));
    const isOdd = ref(false);
    // watchEffectを使用すると中で使っている定義の値が変わった時、また初回レンダリング時に実行される。
    watchEffect(() => {
      if (categories.value.length % 2 === 1) {
        isOdd.value = true;
      } else {
        isOdd.value = false;
      }
    });
    // watch(categories.value, () => {
    //   if (categories.value.length % 2 === 1) {
    //     isOdd.value = true;
    //   } else {
    //     isOdd.value = false;
    //   }
    // });

    //以下の形でデータが入っている。
    // const categories = ref([]);
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

    return {
      categories,
      isOdd,
    };
  },
};
</script>

<style></style>
