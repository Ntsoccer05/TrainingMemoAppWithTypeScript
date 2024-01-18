// import { ref } from "vue";
// import axios from "axios";

// export default function useGetRanking(){
//     const rankingContents = ref("");
//     const compGetData = ref(false);
//     const benchWeightUsers = ref([])
//     const benchVolumeUsers = ref([])
//     const squatWeightUsers = ref([])
//     const squatVolumeUsers = ref([])
//     const deadliftWeightUsers = ref([])
//     const deadliftVolumeUsers = ref([])
    
//     const getRanking = async()=>{
//         await axios.get("/api/recordRanking/users", {
//         }).then((res) =>{
//             console.log(res.data.rankingRecord)
//             rankingContents.value = res.data.rankingRecord
//             benchWeightUsers.value = JSON.parse(res.data.rankingRecord[0].bench_weight_users)
//             benchVolumeUsers.value = JSON.parse(res.data.rankingRecord[0].bench_volume_users)
//             squatWeightUsers.value = JSON.parse(res.data.rankingRecord[0].squat_weight_users)
//             squatVolumeUsers.value = JSON.parse(res.data.rankingRecord[0].squat_volume_users)
//             deadliftWeightUsers.value = JSON.parse(res.data.rankingRecord[0].deadlift_weight_users)
//             deadliftVolumeUsers.value = JSON.parse(res.data.rankingRecord[0].deadlift_volume_users)
//             compGetData.value = true
//         }).catch((err)=>{
//             console.log(err)
//         })
//     }

//     return{rankingContents, compGetData, benchWeightUsers, benchVolumeUsers, squatWeightUsers, squatVolumeUsers, deadliftWeightUsers, deadliftVolumeUsers, getRanking}
// }