<template>
    <div class="calendar container md:w-11/12 ml:h-50vh mx-auto">
        <v-calendar ref="calendar" locale="ja-jp" :attributes="attrs">
        <!-- Calendarの中に以下でもタイトル名変更可能
        :masks = masks -->
        <!-- タイトル変更：header-titleのslot-scopeの中のpropを利用 (#はv-slotの省略記法) -->
        <template #header-title="props">
            {{ props.yearLabel }}年 {{ props.monthLabel }}
        </template>
        <!-- day-contentのslot-scopeの中のpropの中にdayがある ← 分割代入 -->
        <!-- <template #day-content="{ day }"> -->
        <template #day-content="props">
            <template v-if="props.day.inMonth">
                <span
                    tabindex="-1"
                    :aria-label="props.day.ariaLabel"
                    role="button"
                    class="vc-day-content vc-focusable mx-auto"
                    @click="toInputPage(props.day)"
                >
                    <!-- templateタグにはkeyは設定できないのでその中のtemplate以外の要素にkeyを指定 -->
                    <template v-for="holiday in holidays">
                    <template v-if="holiday === props.day.id">
                        <span class="isHoliday" :key="holiday"></span>
                    </template>
                    </template>
                    <span>{{ props.day.day }}</span>
                </span>
            </template>
        </template>
        </v-calendar>
    </div>
</template>
<script>
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
export default {
    setup(){
        const router = useRouter();
        // 祝日の情報を取得
        const url = "https://holidays-jp.github.io/api/v1/date.json";
        const options = {method: "get"};
        // 当日をハイライト
        const attrs = reactive([
            {key: "today", highlight: true, dates: new Date()}
        ]);
        // イベントをハイライト
        const events = reactive([
            {
            name: "test",
            start: new Date("2022-09-01T11:00:00"),
            end: new Date("2022-09-01T15:00:00"),
            },
            {
            name: "テスト",
            start: new Date("2022-09-07"),
            end: new Date("2022-09-09"),
            },
        ]);
        const holidays = ref([]);
        const data = ref([]);

         // ページ遷移
        const toInputPage = (val) => {
            router.push({ name: "selectMenu", params: { day: val.id } });
        };

        const getHolidays = async ()=> {
            // 祝日の情報を取得
            await fetch(url, options).then((response) => {
                data.value = response.json();
                data.value.then((val) => {
                    for (const days in val) {
                        holidays.value.push(days);
                    }
                });
            });
        };

        onMounted(() => {
            getHolidays();
        });

        return { attrs, events, holidays, toInputPage}
    },
};
</script>

<style scoped>

.vc-container {
    width: 100%;
    height: 100%;
}
/* ::v-deepで他のファイル要素にも反映 */
.vc-container::v-deep .vc-pane-layout {
    height: 100%;
}
.vc-container::v-deep .vc-weeks {
    height: 90%;
    align-items: center;
}
/* ヘッダークリック時のポップアップのタイトルに「年」を追加 */
.vc-container::v-deep .vc-nav-title::after {
    content: "年";
}
/* 土曜日を青色 */
.weekday-7 span,
.vc-weekday:nth-child(7) {
    color: blue;
}

/* 日曜日を赤色 */
.weekday-1 span,
.vc-weekday:nth-child(1),
.holiday {
    color: red;
}

/* 祝日を赤色に */
.isHoliday + span {
    color: red;
}
</style>
