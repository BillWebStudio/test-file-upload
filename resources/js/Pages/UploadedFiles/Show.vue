<script setup>
import {computed} from "vue";
import GuestLayout from '@/Layouts/GuestLayout.vue';

const props = defineProps({
    uploadedFile: {
        type: Object,
    },
});

const pageTitle = computed(() => {
    return 'Uploaded Files > View';
});

let audioExtensions = ["mp3", "wav"];

</script>

<template>
    <GuestLayout :title="pageTitle" >

        <div>
            <v-container>

                <v-row>
                    <v-col cols="12" md="6">

                        <app-dynamic-image v-if="!audioExtensions.includes(uploadedFile?.extension)" :record="uploadedFile" field="name" size="large"></app-dynamic-image>
                        <app-dynamic-audio v-else-if="audioExtensions.includes(uploadedFile?.extension)" :record="uploadedFile" field="name"></app-dynamic-audio>

                    </v-col>


                    <v-col cols="12" md="6">
                        <v-row class="row">
                            <v-col cols="12" sm="3"><strong>ID:</strong></v-col>
                            <v-col cols="12" sm="9">{{ uploadedFile.id }}</v-col>
                        </v-row>

                        <v-row class="row">
                            <v-col cols="12" sm="3"><strong>File Name:</strong></v-col>
                            <v-col cols="12" sm="9">{{ uploadedFile.name }}</v-col>
                        </v-row>

                        <v-row class="row">
                            <v-col cols="12" sm="3"><strong>Extension:</strong></v-col>
                            <v-col cols="12" sm="9">{{ uploadedFile.extension }}</v-col>
                        </v-row>

                        <v-row class="row">
                            <v-col cols="12" sm="3"><strong>Full URL:</strong></v-col>
                            <v-col cols="12" sm="9">{{ uploadedFile.full_url }}</v-col>
                        </v-row>

                        <v-row class="row">
                            <v-col cols="12" sm="3"><strong>Number of downloads:</strong></v-col>
                            <v-col cols="12" sm="9">{{ uploadedFile.downloaded }}</v-col>
                        </v-row>

                        <v-row class="row">
                            <v-col cols="12" sm="3"><strong>Created:</strong></v-col>
                            <v-col cols="12" sm="9">{{ uploadedFile.created_at }}</v-col>
                        </v-row>
                    </v-col>


                </v-row>

                <v-col class="d-flex align-center mt-4 ga-2">
                    <v-btn color="primary" variant="outlined" size="large" :to="route('uploaded-files.index')" title="Index">Index</v-btn>
                    <v-btn color="warning" size="large" :to="route('uploaded-files.edit', uploadedFile.id)" title="Edit">Edit</v-btn>
                    <v-btn color="error" size="large" class="destroyBtn" :data-url="route('uploaded-files.destroy', uploadedFile.id)" title="Delete">Delete</v-btn>
                </v-col>

            </v-container>

        </div>

    </GuestLayout>
</template>

