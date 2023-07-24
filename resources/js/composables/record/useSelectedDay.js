import { useStore } from "vuex";
import { computed } from "vue";

export default function useSelected(day){
    const store = useStore();

    const selectedDay = ()=>{
        store.commit("selectedDay", day);
    }

    const recordingDay = computed(()=>{
        return store.getters.selectedDay;
    })

    return {selectedDay, recordingDay};
}