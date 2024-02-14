<script setup>
import { ref } from 'vue';

const props = defineProps({
    title: {
        type: String,
        default: '',
    },
    width: {
        type: Number,
        default: 1000,
    },
    show: {
        type: Boolean,
        default: false,
    }
});

const emit = defineEmits(['close']);

const showModal = ref(props.show);

const close = () => {
    emit('close');
};

</script>

<template>
    <v-dialog
        v-model="showModal"
        :width="width"
        :scrim="false"
    >
        <v-card>
            <v-card-title>
                <span v-if="title" class="text-h5">{{title}}</span>
                <v-icon icon="mdi-close" @click="close" class="float-end"></v-icon>
            </v-card-title>

            <v-card-text>
               <slot>
                   <v-progress-linear
                       indeterminate
                       color="primary"
                       class="mb-0"
                   ></v-progress-linear>
               </slot>
            </v-card-text>

        </v-card>
    </v-dialog>
</template>

