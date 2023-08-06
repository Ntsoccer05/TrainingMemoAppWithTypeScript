<template>
  <div class="md:flex">
    <table
      class="border border-collapse table-fixed mx-auto mt-3 md:w-5/12 w-11/12"
      v-for="category in categories"
      :key="category.id"
    >
      <thead>
        <tr>
          <th class="border">{{ category.content }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="menu in menus" :key="menu.id">
          <td class="border hover:bg-gray-200">{{ menu.content }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { reactive, ref } from "vue";
export default {
  setup() {
    const categories = ref([
      {
        id: 1,
        content: "aa",
      },
      {
        id: 2,
        content: "ii",
      },
    ]);

    const menus = ref([
      {
        id: 1,
        category_id: 1,
        content: "iii",
      },
      {
        id: 2,
        category_id: 1,
        content: "iii",
      },
    ]);

    return { categories, menus };
  },
};
</script>

<style></style>
