<script setup>
import {computed} from "vue";
import { useForm, usePage } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import FormFields from "@/Pages/UploadedFiles/formFields.vue";

const props = defineProps({
    uploadedFile: {
        type: Object,
    }
});

const page = usePage();

const pageTitle = computed(() => {
    return 'Uploaded Files > Add';
});

const fileErrors = computed(() => {
    let err = '';
    for (let key in page.props.errors){
        err += page.props.errors[key] + "\n";
    }
   // let err = page.props.errors.join(" and ")
    return err;
});


const form = useForm({
    files: [],
});

const submit = () => {
    form.post(route('uploaded-files.store'), {});
};

let audioExtensions = ["mp3", "wav"];


</script>

<template>
    <GuestLayout :title="pageTitle" >

        <div>

            <v-form @submit.prevent="submit" class="my-4">
                <v-container>

                    <v-row>

                        <v-col cols="12" md="6">
                            <h2 class="mb-5">Upload file</h2>

                            <v-row>
                                <v-col md="12">

                                    <v-file-input
                                        name="files"
                                        @input="form.files = $event.target.files"
                                        :error-messages="fileErrors"
                                        @click="form.errors.files=null"
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

                    <v-col class="d-flex align-center ga-2">
                        <v-btn :disabled="form.processing" type="submit" color="primary" size="large" title="Save">Save</v-btn>
                        <v-btn color="primary" variant="outlined" size="large" :to="route('uploaded-files.index')" title="Cancel">Cancel</v-btn>
                    </v-col>

                </v-container>

            </v-form>

        </div>

    </GuestLayout>
</template>

<style scoped>

</style>
