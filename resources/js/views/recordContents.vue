<template>
    <form action="" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <table class="border border-collapse table-fixed mx-auto">
            <!-- 入れ子で意識すべきことを追加 -->
            <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                <p :class="{'menu': 1}" class="text-lg">種目：{{ menu[1].content }}</p>
                <button class="block w-11/12 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border-2 border-black mt-3 mb-3" @click="fillBeforeRecord">前回の記録を埋める</button>
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">今日のトータルセット数：１０セット</p>
            </caption>
            <thead>
                <tr>
                    <th class="text-left md:text-center indent-1 md:indent-0"><div class="border">今回の記録</div></th>
                    <th class="text-left md:text-center indent-1 md:indent-0"><div class="border">前回の記録</div></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(content, index) in contents" :key="index">
                    <td>
                        <div class="bg-gray-200 border indent-1">
                            {{ index + 1 }}セット目
                        </div>
                        <div :class="hasOneHand ? 'hidden' : 'block'">
                            <input class="border w-full" type="text" placeholder="重さ(kg)">
                            <input class="border w-full" type="text" placeholder="回数">
                        </div>
                        <div :class="hasOneHand ? 'block' : 'hidden'">
                            <input class="border w-full" type="text" placeholder="重さ（右）(kg)">
                            <input class="border w-full" type="text" placeholder="回数（右）">
                            <input class="border w-full" type="text" placeholder="重さ（左）(kg)">
                            <input class="border w-full" type="text" placeholder="回数（左）">
                        </div>
                        <div class="border">
                            <textarea class="w-full" name="" id="" cols="20" placeholder="メモ"></textarea>
                        </div>
                    </td>
                    <td>
                        <div class="bg-gray-200 border indent-1">
                            {{ index + 1 }}セット目
                        </div>
                        <div :class="hasOneHand ? 'hidden' : 'block'">
                            <input class="border w-full" type="text" placeholder="重さ(kg)" readonly>
                            <input class="border w-full" type="text" placeholder="回数" readonly>
                        </div>
                        <div :class="hasOneHand ? 'block' : 'hidden'">
                            <input class="border w-full" type="text" placeholder="重さ（右）(kg)" readonly>
                            <input class="border w-full" type="text" placeholder="回数（右）" readonly>
                            <input class="border w-full" type="text" placeholder="重さ（左）(kg)" readonly>
                            <input class="border w-full" type="text" placeholder="回数（左）" readonly>
                        </div>
                        <div class="border">
                            <textarea class="w-full" name="" id="" cols="20" placeholder="メモ"></textarea>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</template>

<script>
import { ref, onMounted } from 'vue';
export default {
    setup(props) {
        const hasOneHand = ref(false);

        // メニューはセレクトボックス、休憩時間はタイムピッカー
        const header = {
                set: 'セット数',
                menu: 'メニュー',
                weight: '重量(kg)',
                rep: '回数',
                rest: '休憩時間'
            };
        
        // propsでわたってくる
        const menu = [
            {id:1, content: 'ベンチプレス'},
            {id:2, content: 'ワンハンドダンベルローイング'}
        ];
        
        const contents = [
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60},
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60},
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60},
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60},
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60},
        ];

        const beforeContents = [
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60, recorded_at: 2023/03/22},
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60, recorded_at: 2023/03/22},
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60, recorded_at: 2023/03/22},
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60, recorded_at: 2023/03/22},
            {set: 1, menu: "ベンチプレス", weight: 100, rep: 10, rest: 60, recorded_at: 2023/03/22},
        ];

        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const fillBeforeRecord = ()=>{
            
        }

        onMounted(() => {
            if(menu[1].content.indexOf('ワンハンド') != -1){
                hasOneHand.value != hasOneHand.value;
            }
        });

        return {header, contents, csrf, menu, hasOneHand};
    },
}
</script>
