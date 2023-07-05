import './bootstrap';

import "primevue/resources/themes/tailwind-light/theme.css"; //theme
import "primevue/resources/primevue.min.css"; //core CSS
import "primeicons/primeicons.css"; //icons
import '../scss/app.scss';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import PrimeVue from 'primevue/config';

import { createI18n } from "vue-i18n";
import messages_es from '../lang/es.json'
import messages_en from '../lang/en.json'

import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';

import Tooltip from 'primevue/tooltip';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const translations = {
    en: {
        msg:messages_en,
    },
    es: {
        msg:messages_es,
    },
    ca: {
        msg:messages_es,
    }
    
    
  }
  
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        
        const i18n = createI18n({
            detectBrowserLanguage: true,
            locale: 'es',
            fallbackLocale: import.meta.env.VITE_FALLBACK_LOCALE,
            legacy: false,
            globalInjection: true,
            messages: translations,
            //messages: { tr, en },
            runtimeOnly: false,
          })

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PrimeVue)
            .use(ToastService)
            .use(i18n)
            .use(ConfirmationService)
            .directive('tooltip', Tooltip)
            .mount(el);
    },
    progress: {
        color: '#FFFFFF',
    },
});



if (process.env.NODE_ENV !== 'production') {

}
