<script setup>

const props = defineProps({
    uploadedFile: {
        type: Object,
    },
    form: {
        type: Object,
    }
});

let audioExtensions = ["mp3", "wav"];

</script>


<template>
        <v-row>

            <v-col cols="12" md="6">
                <h2 class="mb-5">Upload file</h2>

                <v-row>
                    <v-col md="12">

                        <v-file-input
                            name="name"
                            @input="form.name = $event.target.files"
                            :error-messages="form.errors.name"
                            @click="form.errors.name=null"
                            accept="image/*, audio/mp3, audio/wav"
                            label="File"
                            variant="solo-filled"
                            multiple
                        ></v-file-input>

                    </v-col>
                </v-row>

                <v-row v-if="uploadedFile?.name">
                    <v-col md="12">
                        <v-avatar size="50" v-if="!audioExtensions.includes(uploadedFile?.extension)">
                            <app-dynamic-image :record="uploadedFile" field="name" size="small"></app-dynamic-image>
                        </v-avatar>
                        <app-dynamic-audio v-else-if="audioExtensions.includes(uploadedFile?.extension)" :record="uploadedFile" field="name"></app-dynamic-audio>
                    </v-col>
                </v-row>

            </v-col>

        </v-row>

</template>


<style scoped>

</style>
