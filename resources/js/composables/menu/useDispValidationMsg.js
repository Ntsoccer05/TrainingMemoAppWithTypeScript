// 合成関数では必ず変数名の頭にに「use」を付ける

import { computed } from "vue";// エラーメッセージのレイアウト

// エラーメッセージのレイアウト指定（エラーメッセージがある場合のみ表示）
// hasMsg：エラーメッセージが存在するかどうか
export default function useDispValidationMsg(hasMsg){
    // 部位のバリデーションエラー
    const dispCategoryErrMsg = computed(() => {
        return hasMsg.category_content ? "col-start-2 justify-self-start text-red-500 font-bold text-sm italic mt-1 mb-2" : "hidden";
    });
    
    // 種目のバリデーションエラー
    const dispMenuErrMsg = computed(() => {
        return hasMsg.menu ? "col-start-2 justify-self-start text-red-500 font-bold text-sm italic mt-1 mb-2" : "hidden";
    });

    return {dispCategoryErrMsg, dispMenuErrMsg};
}