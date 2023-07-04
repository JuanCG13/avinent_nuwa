import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
const path = require('path')
import laravelTranslations from 'vite-plugin-laravel-translations';


export default defineConfig({
    resolve:{
        alias:{
          '@images' : path.resolve(__dirname, './resources/images')
        },
    },
    plugins: [
        laravelTranslations({
            // # TBC: To include JSON files
            includeJson: true,
            // # Declare: namespace (string|false)
            namespace: true,
        }),
        laravel({
            input: 'resources/sass/app.scss',
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
