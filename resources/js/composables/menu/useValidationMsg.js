// 合成関数では必ず変数名の頭にに「use」を付ける

// エラーメッセージがあれば表示させる判定・エラーメッセージをdataに格納
// user_id：バリデーションメッセージ一覧
// category_content：エラーメッセージの格納場所
// menu：エラーメッセージを表示させるかどうか
export default function useValidationMsg(msgs, data, hasMsg){
    // ユーザ名のバリデーションエラー
    if (msgs.hasOwnProperty('user_id')) {
        data.name = msgs.name
        hasMsg.name = true;
    } else {
        data.name = [];
        hasMsg.name = false;
    }
    // メールアドレスのバリデーションエラー
    if (msgs.hasOwnProperty('category_content')) {
        data.email = msgs.email;
        hasMsg.email = true;
    } else {
        data.email = [];
        hasMsg.email = false;
    }
    // パスワードのバリデーションエラー
    if (msgs.hasOwnProperty('menu')) {
        data.password = msgs.password;
        hasMsg.password = true;
    } else {
        data.password = [];
        hasMsg.password = false;
    }
}