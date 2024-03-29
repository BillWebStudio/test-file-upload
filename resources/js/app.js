import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import CKEditor from '@ckeditor/ckeditor5-vue';

import vuetify from '@/Plugins/vuetify';
import link from "@/Plugins/link";

import Sort from "@/Components/Sort.vue";
import Pagination from "@/Components/Pagination.vue";
import DynamicImage from "@/Components/DynamicImage.vue";
import DynamicAudio from "@/Components/DynamicAudio.vue";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const app = createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        return resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({
                render: () => h(App, props)
            })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(vuetify)
            .use(link)
            .use(CKEditor)
            .component('AppSort', Sort)
            .component('AppPagination', Pagination)
            .component('AppDynamicImage', DynamicImage)
                .component('AppDynamicAudio', DynamicAudio)
            .mount(el)
            ;
        return app;
    },
    progress: {
        color: '#4B5563',
    },
});

import './custom';
