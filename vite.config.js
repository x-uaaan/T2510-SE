import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['api/resources/js/app.js', 'api/resources/js/event-create.js'],
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
    resolve: {
        alias: {
            '@': '/api/resources/js',
        },
    },
    build: {
        // CRITICAL CHANGE HERE: Output directly to api/public
        outDir: 'api/public', // Changed from 'api/public/build'
        emptyOutDir: true, // This will clear 'api/public' before build, be careful if you have other files there
        rollupOptions: {
            input: 'api/resources/js/app.js',
        },
        // Optionally, define assetsDir to ensure files go into a subfolder like 'assets'
        assetsDir: 'assets', // This means files will be in api/public/assets
    },
});