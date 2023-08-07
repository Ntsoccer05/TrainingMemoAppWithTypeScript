<template>
  <div class="md:flex items-baseline mt-8">
    <table
      class="border border-collapse table-fixed mx-auto md:w-5/12 w-11/12"
      v-for="category in categories"
      :key="category.id"
    >
      <thead>
        <tr>
          <th class="border">{{ category.content }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="menu in categoryMenus(category.id)" :key="menu.id">
          <td class="border hover:bg-gray-200">{{ menu.content }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { reactive, ref, computed, onMounted } from "vue";
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
        category_id: 2,
        content: "iii",
      },
      {
        id: 2,
        category_id: 1,
        content: "iii",
      },
      {
        id: 2,
        category_id: 1,
        content: "iii",
      },
    ]);

    // 絞り込みの際は必ずreturnが必要
    const categoryMenus = (categoryId) => {
      return menus.value.filter((menu) => {
        return menu.category_id === categoryId;
      });
    };

    return { categories, menus, categoryMenus };
  },
};
</script>

<style></style>
