<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
});
</script>

<template>
    <GuestLayout title="">

        <v-container>

            <v-row justify="center">
                <v-col cols="12" lg="6">
                    <v-alert color="primary">
                        <v-alert-title>Welcome to {{ $page.props.appName }}!</v-alert-title>
                    </v-alert>
                </v-col>
            </v-row>

        </v-container>

    </GuestLayout>
</template>
