<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3'


const props = defineProps({
    src: {
        type: String,
    },
    record: {
        type: Object,
    },
    field: {
        type: String,
    },
});

const page = usePage();

const srcFromRecord =  computed(() => {
    if (!props.record || !props.field || !props.record[props.field])
        return false;

    let sizePrefix = "";
    if (props.size)
        sizePrefix = props.size + "-";

    let src = page.props.uploadsFolderView + "/" + props.record.uploadsFolder + "/" + props.field + "/" + props.record[props.field];
    return src;
})
</script>

<template>
    <figure v-if="src || srcFromRecord">
        <figcaption>Listen to the T-Rex:</figcaption>
        <audio v-if="src" controls :src="src" class="w-100"></audio>
        <audio v-else controls :src="srcFromRecord" class="w-100"></audio>
    </figure>
</template>
