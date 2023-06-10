import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createI18n } from "vue-i18n";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const messages = {
    en: {
    nav: {
        home: "Главная",
        about: "О нас"
      },
      home: {
        header: "Добро пожаловать в руководство Vue 3 I18n!",
        created_by: "Это руководство создано для вас компанией Lokalise."
      },
      about: {
        header: "О нас"
      }
    },
    ru: {
      nav: {
        home: "Главная",
        about: "О нас"
      },
      home: {
        header: "Добро пожаловать в руководство Vue 3 I18n!",
        created_by: "Это руководство создано для вас компанией Lokalise."
      },
      about: {
        header: "О нас"
      }
    }
  }
  
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        
        const i18n = createI18n({
            locale: import.meta.env.VITE_DEFAULT_LOCALE,
            fallbackLocale: import.meta.env.VITE_FALLBACK_LOCALE,
            legacy: false,
            globalInjection: true,
            messages: messages,
            //messages: { tr, en },
            runtimeOnly: false,
            // set locale messages
            // If you need to specify other options, you can set other options
            // ...
          })

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(i18n)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
