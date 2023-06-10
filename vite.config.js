import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
const path = require('path')

export default defineConfig({
    resolve:{
        alias:{
          '@images' : path.resolve(__dirname, './resources/images')
        },
    },
    plugins: [
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
