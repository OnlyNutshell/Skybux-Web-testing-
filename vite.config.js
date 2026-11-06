import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [ 
                    'resources/css/app.css',
                    'resources/js/app.js',
                    'resources/js/page/home.js',
                    'resources/js/page/checkout.js',
                    'resources/js/page/payment.js',
                ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
