import './bootstrap';
import '../css/app.css';
// import '../sass/app.scss';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

import { Quasar } from 'quasar'
import quasarLang from 'quasar/lang/pt-BR'

import '@quasar/extras/roboto-font-latin-ext/roboto-font-latin-ext.css'
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/material-icons-outlined/material-icons-outlined.css'
import '@quasar/extras/material-icons-round/material-icons-round.css'

import 'quasar/src/css/index.sass'

// import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
// import { library } from "@fortawesome/fontawesome-svg-core";
// import { fas } from '@fortawesome/free-solid-svg-icons'
// library.add(fas);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
         createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Quasar, {
                plugins: {}, // import Quasar plugins and add here
                lang: quasarLang,
            })
            // .component("fa", FontAwesomeIcon)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
