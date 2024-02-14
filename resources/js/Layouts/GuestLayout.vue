<script setup>
import { Link } from '@inertiajs/vue3';
import Notifications from "@/Components/Notifications.vue";

defineProps({
    title: String
});

</script>

<template>
    <v-app class="rounded rounded-md">

        <v-toolbar class="text-primary font-weight-bold">
            <v-toolbar-title>
                <Link :href="route('home')" class="text-decoration-none">
                    {{ $page.props.appName }}
                </Link>

            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn :to="route('home')" flat :active="route().current('home')" >Home</v-btn>
                <v-btn :to="route('uploaded_files.index')" flat >Uploaded Files</v-btn>
            </v-toolbar-items>

            <div class="hidden-md-and-up" >
                <v-menu  transition="scale-transition">
                    <template v-slot:activator="{ props }">
                        <v-btn icon="mdi-dots-vertical" v-bind="props"></v-btn>
                    </template>
                    <v-list>
                        <v-list-item>
                            <v-btn :to="route('home')" flat :active="route().current('home')" >Home</v-btn>
                        </v-list-item>

                        <v-list-item v-if="$page.props.auth?.user?.id">
                            <v-btn :to="route('uploaded_files.index')" flat >Uploaded Files</v-btn>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </div>

        </v-toolbar>

        <v-main class="d-flex align-center justify-center" style="min-height: 300px;">
            <v-container>
                <h1 v-if="title" class="text-primary">{{ title }}</h1>
                <notifications></notifications>
                <slot></slot>
            </v-container>
        </v-main>

        <v-footer class="d-flex justify-center">
            &copy; BillWebStudio 2024
        </v-footer>
    </v-app>
</template>
