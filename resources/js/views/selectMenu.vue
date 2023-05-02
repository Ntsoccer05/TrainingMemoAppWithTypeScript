<template>
  <div>
        <h3 class="text-lg text-center font-bold mt-4">鍛える部位を選択してください</h3>
        <table v-for="(category, index) in categories" :key="index" class="border border-collapse table-fixed mx-auto md:flex mt-3">
            <thead>
                <tr>
                    <th class="border">{{ category.name }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(menu, index) in menus" :key="index">
                    <td class="border">{{ menu.content }}</td>
                </tr>
            </tbody>
        </table>
  </div>
</template>

<script>
export default {
    setup(){
        //データベースから取得
        const categories =[
            {id:1, name:"胸"},
            {id:2, name:"背中"},
        ]
        const menus =[
            {id:1, category_id:1, category:"胸", content:"ベンチプレス", oneSide:0},
            {id:2, category_id:2, category:"背中", content:"ワンハンドローイング", oneSide:1},
        ]

        return {categories,menus};
    }
}
</script>

<style>

</style>