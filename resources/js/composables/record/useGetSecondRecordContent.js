import { ref,nextTick } from "vue";
import axios from "axios";

export default function useGetSecondRecordContent(user_id, category_id, menu_id, record_state_id){
    const secondRecord = ref("")
    // ２番目に新しい記録が存在するか
    const hasSecondRecord = ref(false)

    //２番目に新しい記録を取得する
    const getSecondRecord = async(user_id, category_id, menu_id, record_state_id)=>{
        await axios.get("/api/recordContent", {
            // get時にパラメータを渡す際はparamsで指定が必要
            params:{
                // keyとvalueが同じためuser_id:user_idの「:user_id」を省略できる
                user_id,
                category_id,
                menu_id,
                record_state_id,
            }
        }).then((res) =>{
            debugger;
            if(res.data.secondRecord){
                secondRecord.value = res.data.secondRecord
                hasSecondRecord.value = true
            }else{
                hasSecondRecord.value = false
            }
        })
    }

    return{secondRecord, hasSecondRecord, getSecondRecord}
}