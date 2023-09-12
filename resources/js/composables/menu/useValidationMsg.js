// 合成関数では必ず変数名の頭にに「use」を付ける

// エラーメッセージがあれば表示させる判定・エラーメッセージをdataに格納
// user_id：バリデーションメッセージ一覧
// category_content：エラーメッセージの格納場所
// menu：エラーメッセージを表示させるかどうか
export default function useValidationMsg(msgs, data, hasMsg){
    // 部位のバリデーションエラー
    if (msgs.hasOwnProperty('menu')) {
        data.menu = msgs.menu
        hasMsg.menu = true;
    } else {
        data.menu = "";
        hasMsg.menu = false;
    }
    // 種目のバリデーションエラー
    if (msgs.hasOwnProperty('category_content')) {
        data.category_content = msgs.category_content;
        hasMsg.category_content = true;
    } else {
        data.category_content = "";
        hasMsg.category_content = false;
    }
}