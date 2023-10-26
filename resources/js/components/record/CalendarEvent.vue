// setup() 関数内で定義した変数や関数を return しないと template //
内で使用することができなかったが、 script setup>内で宣言した場合すべて使用可能となる

<script setup>
import { onMounted, ref, watch, defineProps } from "vue";

const props = defineProps({
  records: Object,
  attrs: Array,
});

watch(props.records, () => {
  console.log(props.records);
});

watch(props.attrs, () => {
  console.log(props.attrs);
});

console.log(props.records);
console.log(props.attrs);
</script>

<template #day-popover="{ day, format, masks }">
  <div class="text-xs text-gray-300 font-semibold text-center">
    {{ format(day.date, masks.dayPopover) }}
  </div>
</template>
