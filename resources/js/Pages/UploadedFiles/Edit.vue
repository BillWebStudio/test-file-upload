<script setup>
import {computed} from "vue";
import {useForm, usePage} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import FormFields from "@/Pages/UploadedFiles/formFields.vue";

const props = defineProps({
    uploadedFile: {
        type: Object,
    }
});

const page = usePage();

const pageTitle = computed(() => {
    return 'Uploaded Files > Edit';
});

const form = useForm({
    _method: 'put',
    name: props?.uploadedFile?.name,
});

const submit = () => {
    form.post(route('uploaded-files.update', props.uploadedFile.id), {});
};


</script>

<template>
    <GuestLayout :title="pageTitle" >

        <div>

            <v-form @submit.prevent="submit" class="my-4">
                <v-container>

                    <v-row>

                        <v-col cols="12" md="6">
                            <h2 class="mb-5">Rename file</h2>

                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="form.name"
                                        label="File Name"
                                        :error-messages="form.errors.name"
                                        @click="form.errors.name=null"
                                        variant="solo-filled"
                                        required
                                    ></v-text-field>
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
