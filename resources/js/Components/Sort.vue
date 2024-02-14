<script setup>
import { ref, computed } from "vue";
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    label: {
        type: String,
        default: "",
    },
    field: {
        type: String,
        default: "",
    },
    direction: {
        type: String,
        default: "asc",
    },
});

const downFill = ref("lightgray");
const upFill = ref("lightgray");

const sortLink = computed(() => {
    let url = new URL(document.location);
    let sortValue = url.searchParams.get("sort");
    let sortDirection = url.searchParams.get("direction");

    if (sortValue == props.field) {
        if (sortDirection == 'asc') {
            url.searchParams.set("direction", "desc");
            downFill.value = "black";
        }
        else {
            url.searchParams.set("direction", "asc");
            upFill.value = "black";
        }

    } else {
        url.searchParams.set("sort", props.field);
        url.searchParams.set("direction", "asc");
    }

    return url.href;
});
</script>

<template>
    <div class="d-flex gap-1">
        <Link :href="sortLink" class="" >{{ label }}</Link>
        <div class="d-flex flex-column">
            <svg
                class="inline-block"
                xmlns="http://www.w3.org/2000/svg"
                width="15px"
                height="10px"
                viewBox="0 0 15 15"
                fill="none"
            >
                <path d="M7.5 3L15 11H0L7.5 3Z" :fill="upFill" />
            </svg>
            <svg
                class="inline-block"
                xmlns="http://www.w3.org/2000/svg"
                width="15px"
                height="10px"
                viewBox="0 0 15 15"
                fill="none"
            >
                <path
                    d="M7.49988 12L-0.00012207 4L14.9999 4L7.49988 12Z"
                    :fill="downFill"
                />
            </svg>
        </div>
    </div>
</template>

