<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3'


const props = defineProps({
    src: {
        type: String,
    },
    icon: {
        type: String,
        default: "mdi-image-area",
    },
    record: {
        type: Object,
    },
    field: {
        type: String,
    },
    size: {
        type: String,
        default: "",
    },
});

const page = usePage();

const srcFromRecord =  computed(() => {
    if (!props.record || !props.field || !props.record[props.field])
        return false;

    let sizePrefix = "";
    if (props.size)
        sizePrefix = props.size + "-";

    let src = page.props.uploadsFolderView + "/" + props.record.uploadsFolder + "/" + props.field + "/" + sizePrefix + props.record[props.field];
    return src;
})
</script>

<template>
    <v-img v-if="src" :src="src"></v-img>

    <v-img v-else-if="srcFromRecord" :src="srcFromRecord"></v-img>

    <v-icon v-else icon="mdi-account"></v-icon>
</template>
