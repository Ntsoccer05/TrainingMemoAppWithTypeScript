// 合成関数では必ず変数名の頭にに「use」を付ける

// エラーメッセージがあれば表示させる判定・エラーメッセージをdataに格納
// msgs：バリデーションメッセージ一覧
// data：エラーメッセージの格納場所
// hasMsg：エラーメッセージを表示させるかどうか
export default function useValidationMsg(msgs, data, hasMsg){
    // ユーザ名のバリデーションエラー
    if(msgs){
        // メールアドレスのバリデーションエラー
        if (msgs.hasOwnProperty('email')) {
            data.email = msgs.email;
            hasMsg.email = true;
        } else {
            data.email = [];
            hasMsg.email = false;
        }
        // お問い合わせ内容のバリデーションエラー
        if (msgs.hasOwnProperty('content')) {
            data.content = msgs.content;
            hasMsg.content = true;
        } else {
            data.content = [];
            hasMsg.content = false;
        }
    }
}