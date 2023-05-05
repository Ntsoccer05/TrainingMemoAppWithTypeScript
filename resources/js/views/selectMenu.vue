<template>
  <div>
        <h3 class="text-lg text-center font-bold mt-4">鍛える部位を選択してください</h3>
        <button class="block w-50 bg-blue-500 hover:bg-blue-700 text-white font-bold md:py-2 py-px px-4 border-2 border-black mt-3 mb-3 ml-auto rounded-full">部位・種目を追加する</button>
        <div class="md:flex">
            <table v-for="(category, index) in categories" :key="category.id" class="border border-collapse table-fixed mx-auto mt-3 md:w-5/12 w-11/12">
                <thead>
                    <tr>
                        <th class="border">{{ category.name }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="menu in categories[index].menus" :key="menu.id">
                        <td class="border hover:bg-gray-200" @click="toRecordContents(category.id, menu)">{{ menu.content }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
  </div>
</template>

<script>
import { useRoute, useRouter } from 'vue-router';
export default {
    setup(){
        const router = useRouter();
        const route = useRoute()

        //データベースから取得
        const categories =[
            {id:1,
             name:"胸", 
             menus:[
                {id:1, category_id:1, category:"胸", content:"ベンチプレス", oneSide:0},
            ]},
            {id:2,
             name:"背中",
             menus: [
                {id:1, category_id:2, category:"背中", content:"ワンハンドローイング", oneSide:1},
             ]
            },
        ];

        //トレーニング記録画面に遷移
        const toRecordContents = (categoryId, menu) =>{
            router.push({name: 'record', params: route.params, query:{category_id: categoryId, menu_id: menu.id}})
        };

        return {categories, toRecordContents};
    }
}
</script>