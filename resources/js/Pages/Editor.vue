<script setup>
import {useForm, usePage} from '@inertiajs/vue3';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
});

const form = useForm({
    _method: 'post',
    content: ''
});

const editor = ClassicEditor;

let editorData = '<p>Content of the editor.</p>';

let editorConfig = {
    // The configuration of the editor.
}

</script>

<template>
    <GuestLayout title="Editor">

        <v-container>

            <v-form  class="my-4">
                <v-row>

                    <v-col cols="12" md="12">

                        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>

                        <div id="wordcount"></div>

                    </v-col>
                </v-row>

            </v-form>

        </v-container>

    </GuestLayout>
</template>


