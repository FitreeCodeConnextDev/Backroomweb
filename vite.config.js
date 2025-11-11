import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/vendor_tab.js',
            'resources/js/card_promo.js',
        ]),

        tailwindcss(),

    ],
    resolve: {
        alias: {
            '$': 'jQuery'
        },
    },
});
