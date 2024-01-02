// 合成関数では必ず変数名の頭にに「use」を付ける

import { computed } from "vue";// エラーメッセージのレイアウト

// エラーメッセージのレイアウト指定（エラーメッセージがある場合のみ表示）
// hasMsg：エラーメッセージが存在するかどうか
export default function useDispValidationMsg(hasMsg){
    // メールアドレスのバリデーションエラー
    const dispEmailErrMsg = computed(() => {
        return hasMsg.email ? "text-red-500 text-sm italic mt-1 mb-2" : "hidden";
    });

    // お問い合わせ内容のバリデーションエラー
    const dispContentErrMsg = computed(() => {
        return hasMsg.content ? "text-red-500 text-sm italic mt-1 mb-2" : "hidden";
    });

    return {dispEmailErrMsg, dispContentErrMsg};
}