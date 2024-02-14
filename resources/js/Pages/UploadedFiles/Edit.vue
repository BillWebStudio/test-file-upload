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
    name: null,
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

                    <form-fields :form="form" :uploadedFile="uploadedFile"></form-fields>

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
