<script setup>
import {computed, ref} from "vue";
import {usePage, Link} from "@inertiajs/vue3";
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AdminSearch from "@/Components/Admin/AdminSearch.vue";
import Modal from "@/Components/Modal.vue";
import UploadedFilesPreview from "@/Pages/UploadedFiles/Preview.vue";

const props = defineProps({
    uploadedFiles: Object,
});

const page = usePage();

const pageTitle = computed(() => {
    return "Uploaded Files";
});

const searchInputs = computed(() => {
    return [
        {
            name: 's',
            type: 'text',
            label: 'Keyword',
        },
    ];
});

const items = computed(() => {
    return props.uploadedFiles;
});

const copyUrl = (evt) => {
    navigator.clipboard.writeText(evt.target.dataset.url);
    alert('URL copied');
}

let audioExtensions = ["mp3", "wav"];

const modalOptions = ref({
    show: false,
    title: 'Preview',
    item: {}
});


function previewFile(id){
    axios.get(route("uploaded-files.preview", id))
        .then(function (response) {
            console.log(response);
            modalOptions.value = {
                show: true,
                item: response?.data?.uploadedFile
            };
        })
        .catch(function (error) {
            let msg = error.response.data.message || error.message;
            alert(msg);
        });
}

</script>

<template>
    <GuestLayout :title="pageTitle" >

        <template v-slot:titleButtons>
            <v-btn size="large" variant="outlined" :to="route('uploaded-files.create')" title="Add new"><v-icon icon="mdi-plus"></v-icon> Add new</v-btn>
        </template>

        <div>

            <admin-search :form-url="route('uploaded-files.index')" :search-inputs="searchInputs"></admin-search>

            <v-row>
                <v-col cols="12">

                    <v-table class="admin-table">
                        <thead theme="dark">
                        <tr><th colspan="20" class="table-totals">Total: {{ items.total }}</th></tr>
                        <tr>
                            <th><app-sort label="ID" field="id" /></th>
                            <th>File</th>
                            <th><app-sort label="Name" field="name" /></th>
                            <th><app-sort label="Extension" field="extension" /></th>
                            <th><app-sort label="Full URL" field="full_url" /></th>
                            <th><app-sort label="# downloaded" field="downloaded" /></th>
                            <th><app-sort label="Created" field="created_at" /></th>
                            <th class="table-actions">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="item in items.data" :key="item.id">
                            <td><Link :href="route('uploaded-files.edit', [ item.id ] )" title="Edit">{{ item.id }}</Link></td>
                            <td>
                                <v-avatar>
                                    <app-dynamic-image v-if="!audioExtensions.includes(item?.extension)" :record="item" field="name" size="small"></app-dynamic-image>
                                    <v-icon v-else icon="mdi-volume-high"></v-icon>
                                </v-avatar>
                            </td>
                            <td><a href="#" @click.prevent="previewFile(item.id)" title="View">{{ item.name }}</a></td>
                            <td>{{ item.extension }}</td>
                            <td>{{ item.full_url }} <v-icon icon="mdi-content-copy" :data-url="item.full_url" @click="copyUrl"></v-icon></td>
                            <td>{{ item.downloaded }}</td>
                            <td>{{ item.created_at }}</td>

                            <td class="table-actions">
                                <!--
                                <v-btn color="info" variant="outlined"  :to="route('uploaded-files.show', [ item.id ] )" title="View"><v-icon icon="mdi-eye"></v-icon></v-btn>
                                -->
                                <v-btn color="info" variant="outlined" @click="previewFile(item.id)" title="View"><v-icon icon="mdi-eye"></v-icon></v-btn>

                                <v-btn color="warning" variant="outlined" :to="route('uploaded-files.edit', [ item.id ] )" title="Edit"><v-icon icon="mdi-file-edit"></v-icon></v-btn>
                                <v-btn color="success" variant="outlined" :to="route('uploaded-files.download', [ item.id ] )" title="Download" target="_blank"><v-icon icon="mdi-download"></v-icon></v-btn>
                                <v-btn color="error" variant="outlined" class="destroyBtn" :data-url="route('uploaded-files.destroy', item.id)" title="Delete"><v-icon icon="mdi-delete"></v-icon></v-btn>
                            </td>
                        </tr>
                        </tbody>
                    </v-table>

                    <app-pagination :items="items"></app-pagination>

                </v-col>
            </v-row>

        </div>

        <Modal
            v-if="modalOptions.show"
            :show="modalOptions.show"
            :title="modalOptions.title"
            @close="modalOptions.show = false"
            persistent
        >
            <uploaded-files-preview v-if="modalOptions.item"
                         :uploadedFile="modalOptions.item"
                         @close="modalOptions.show = false"
            ></uploaded-files-preview>
        </Modal>

    </GuestLayout>
</template>
