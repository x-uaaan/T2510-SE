import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import VCalendar from 'v-calendar';
import 'v-calendar/style.css';
import Landing from './Pages/Landing.vue'
import NavBar from './Components/NavBar.vue';
import HeroSection from './Components/HeroSection.vue';
import FeaturesSection from './Components/FeaturesSection.vue';
import FooterSection from './Components/FooterSection.vue';
import axios from 'axios';
import { ZiggyVue } from 'ziggy-js';
import { Ziggy } from './ziggy';

axios.defaults.baseURL = '/api';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(VCalendar, {})
            .use(ZiggyVue, Ziggy);

        app.component('NavBar', NavBar);
        app.component('HeroSection', HeroSection);
        app.component('FeaturesSection', FeaturesSection);
        app.component('FooterSection', FooterSection);

        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});