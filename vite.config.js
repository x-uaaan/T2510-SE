import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/js/event-create.js'],
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
    build: {
        // Ensure this aligns with Laravel's public path
        outDir: 'public/build', // This is a common setup for Vite with Laravel
        emptyOutDir: true,
        rollupOptions: {
            input: 'resources/js/app.js',
        },
    },
});
