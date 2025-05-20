import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Landing from './Pages/Landing.vue'
import NavBar from './Components/NavBar.vue';
import HeroSection from './Components/HeroSection.vue';
import FeaturesSection from './Components/FeaturesSection.vue';
import FooterSection from './Components/FooterSection.vue';

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
            .use(ZiggyVue);

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

createApp(Landing).mount('#app')