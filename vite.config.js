import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
mix.react('resources/js/app.js', 'public/js');s

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
