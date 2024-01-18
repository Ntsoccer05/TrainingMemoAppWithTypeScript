import { ref } from "vue";
import axios from "axios";

export default function useGetSecondRecordContent(user_id, category_id, menu_id, record_state_id, recorded_at){
    const secondRecord = ref("")
    const secondRecordState = ref("")
    // ２番目に新しい記録が存在するか
    const hasSecondRecord = ref(false)

    //２番目に新しい記録を取得する
    const getSecondRecord = async(user_id, category_id, menu_id, record_state_id, recorded_at)=>{
        await axios.get("/api/recordMenu", {
            // get時にパラメータを渡す際はparamsで指定が必要
            params:{
                // keyとvalueが同じためuser_id:user_idの「:user_id」を省略できる
                user_id,
                category_id,
                menu_id,
                record_state_id,
                recorded_at,
            }
        }).then((res) =>{
            if(res.data.secondRecords){
                secondRecord.value = res.data.secondRecords
                console.log(secondRecord.value)
                console.log(res.data)
                secondRecordState.value = res.data.secondRecordState.record_state
                hasSecondRecord.value = true
            }else{
                hasSecondRecord.value = false
            }
        })
    }

    return{secondRecord,secondRecordState, hasSecondRecord, getSecondRecord}
}