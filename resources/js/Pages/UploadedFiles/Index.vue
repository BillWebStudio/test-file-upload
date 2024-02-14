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
    <AdminLayout :title="pageTitle" >

        <template v-slot:titleButtons>
            <v-btn size="large" variant="outlined" :to="route('admin.clients.create')" :title="$t('Add new')"><v-icon icon="mdi-plus"></v-icon> {{$t('Add new')}}</v-btn>
        </template>

        <div>

            <admin-search :form-url="route('admin.clients.index')" :search-inputs="searchInputs"></admin-search>

            <v-row>
                <v-col cols="12">

                    <v-table class="admin-table">
                        <thead theme="dark">
                        <tr><th colspan="20" class="table-totals">{{ $t('Total') }}: {{ items.total }}</th></tr>
                        <tr>
                            <th><app-sort :label="trans('fields.id')" field="id" /></th>
                            <th>{{ trans('fields.clients.photo') }}</th>
                            <th><app-sort :label="trans('fields.clients.name')" field="name" /></th>
                            <th><app-sort :label="trans('fields.clients.email')" field="email" /></th>
                            <th><app-sort :label="trans('fields.clients.phone')" field="phone" /></th>
                            <th><app-sort :label="trans('fields.clients.dob')" field="dob" /></th>
                            <th><app-sort :label="trans('fields.clients.hours_left')" field="hours_left" /></th>
                            <th><app-sort :label="trans('fields.clients.hours_valid_until')" field="hours_valid_until" /></th>
                            <th><app-sort :label="trans('fields.status')" field="status" /></th>

                            <th v-if="$page.props.auth.can['manage-organizations']"><app-sort :label="trans('fields.clients.organization_id')" field="organization.name" /></th>
                            <th v-if="$page.props.auth.can['manage-organizations']"><app-sort :label="trans('fields.clients.admin_id')" field="admin.name" /></th>

                            <th><app-sort :label="trans('fields.clients.referrer')" field="referrer" /></th>
                            <th><app-sort :label="trans('fields.created_at')" field="created_at" /></th>
                            <th class="table-actions">{{ trans('Actions') }}</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="item in items.data" :key="item.id">
                            <td><Link :href="route('admin.clients.edit', [ item.id ] )" :title="$t('Edit')">{{ item.id }}</Link></td>
                            <td>
                                <v-avatar>
                                    <app-dynamic-image :record="item" field="photo" size="small"></app-dynamic-image>
                                </v-avatar>
                            </td>
                            <td><Link :href="route('admin.clients.show', [ item.id ] )" :title="$t('View')">{{ item.name }}</Link></td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.phone }}</td>
                            <td>{{ item.dob }}</td>
                            <td>{{ item.hours_left }}</td>
                            <td>{{ item.hours_valid_until }}</td>
                            <td>{{ $page.props.enums.activeStatuses[item.status] }}</td>

                            <td v-if="$page.props.auth.can['manage-organizations']">{{ item?.organization?.name }}</td>
                            <td v-if="$page.props.auth.can['manage-organizations']">{{ item?.admin?.name }}</td>

                            <td>{{ $page.props.enums.referrers[item.referrer] }}</td>
                            <td>{{ item.created_at }}</td>

                            <td class="table-actions">
                                <v-btn color="info" variant="outlined"  :to="route('admin.clients.show', [ item.id ] )" :title="$t('View')"><v-icon icon="mdi-eye"></v-icon></v-btn>
                                <v-btn color="warning" variant="outlined" :to="route('admin.clients.edit', [ item.id ] )" :title="$t('Edit')"><v-icon icon="mdi-file-edit"></v-icon></v-btn>
                                <v-btn color="success" variant="outlined" :to="route('admin.subscriptions.create', [ item.id ] )" :title="$t('Add Subscription')"><v-icon icon="mdi-currency-usd"></v-icon></v-btn>
                                <v-btn color="primary" variant="outlined" :to="route('admin.calendar.index' )" :title="$t('Add Visit')"><v-icon icon="mdi-dumbbell"></v-icon></v-btn>
                            </td>
                        </tr>
                        </tbody>
                    </v-table>

                    <app-pagination :items="items"></app-pagination>

                </v-col>
            </v-row>

        </div>

    </AdminLayout>
</template>
