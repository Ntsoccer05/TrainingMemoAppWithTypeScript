<template>
    <div class="calendar container md:w-11/12 ml:h-50vh">
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
                    class="vc-day-content vc-focusable"
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
export default {
    data() {
        return {
            // 祝日の情報を取得
            url: "https://holidays-jp.github.io/api/v1/date.json",
            options: {
                method: "get",
            },
            // 当日をハイライト
            attrs: [
                {
                key: "today",
                highlight: true,
                dates: new Date(),
                },
                // イベントはcustomDataに
                // {
                //   key: 1,
                //   customData: {
                //     title: "test",
                //     class: "bg-orange-500 text-white",
                //   },
                //   dates: new Date("2022-09-20"),
                // },
                // {
                //   key: 2,
                //   customData: {
                //     title: "テスト",
                //     class: "bg-orange-500 text-white",
                //   },
                //   dates: new Date("2022-09-25"),
                // },
            ],
            events: [
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
            ],
            holidays: [],
            data: [],
            calendar: "",
            // タイトル変更をv-slotで行うためコメントアウト
            // masks: {
            //   title: "YYYY年 M月",
            // },
            calContent: "",
        };
    },
    async mounted() {
        // カレンダーコンポーネントの情報を取得(refはmount後にしか取得できない)
        this.calendar = this.$refs.calendar;
        // this.calContent = this.$refs.calContent;

        // 祝日の情報を取得
        await fetch(this.url, this.options).then((response) => {
            this.data = response.json();
            this.data.then((val) => {
                for (const days in val) {
                    this.holidays.push(days);
                }
            });
        });
    },
    computed: {},
    methods: {
        // ページ遷移
        toInputPage(val) {
            // オブジェクトの場合JSON形式で渡す必要あり
            this.$router.push({ name: "CalendarInput", params: { day: JSON.stringify(val) } });
        },
    },
};
</script>

<style scoped>
.calendar {
    margin: 0 auto;
}

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

/* 日付を真ん中に */
.vc-day-content {
    margin: 0 auto;
}

/* 祝日を赤色に */
.isHoliday + span {
    color: red;
}
</style>
