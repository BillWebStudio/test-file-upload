<script setup>
import { ref, watch } from "vue";
import { router } from '@inertiajs/vue3'

const props = defineProps({
    items: {
        type: Object,
        required: true,
    },
    totalVisisble: {
        type: Number,
        default: 5,
    },
});

const currentPage = ref(props.items.current_page);

watch(currentPage, () => {
    let url = new URL(document.location);
    url.searchParams.set('page', currentPage.value);
    router.get(url.href);
});
</script>

<template>
    <v-pagination v-if="items.last_page > 1"
        v-model="currentPage"
        :length="items.last_page"
        :total-visible="totalVisisble"
        class="my-5"
    ></v-pagination>
</template>

