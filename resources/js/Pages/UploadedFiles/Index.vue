<script setup>
import {computed} from "vue";
import {usePage, Link} from "@inertiajs/vue3";
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AdminSearch from "@/Components/Admin/AdminSearch.vue";

const props = defineProps({
    uploadedFiles: Object,
});

const page = usePage();

const pageTitle = computed(() => {
    return "Uploaded Files";
});

//Have to make computed in order to make trans work on 1st load
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
                                    <app-dynamic-image :record="item" field="name" size="small"></app-dynamic-image>
                                </v-avatar>
                            </td>
                            <td><Link :href="route('uploaded-files.show', [ item.id ] )" title="View">{{ item.name }}</Link></td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.extension }}</td>
                            <td>{{ item.full_url }}</td>
                            <td>{{ item.downloaded }}</td>
                            <td>{{ item.created_at }}</td>

                            <td class="table-actions">
                                <v-btn color="info" variant="outlined"  :to="route('uploaded-files.show', [ item.id ] )" title="View"><v-icon icon="mdi-eye"></v-icon></v-btn>
                                <v-btn color="warning" variant="outlined" :to="route('uploaded-files.edit', [ item.id ] )" title="Edit"><v-icon icon="mdi-file-edit"></v-icon></v-btn>
                                <v-btn color="error" variant="outlined" class="destroyBtn" :data-url="route('uploaded-files.destroy', item.id)" title="Delete"><v-icon icon="mdi-delete"></v-icon></v-btn>
                            </td>
                        </tr>
                        </tbody>
                    </v-table>

                    <app-pagination :items="items"></app-pagination>

                </v-col>
            </v-row>

        </div>

    </GuestLayout>
</template>
