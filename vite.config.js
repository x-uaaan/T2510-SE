// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    build: {
        outDir: 'api/public/build',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: undefined
            }
        }
    },
    plugins: [
        laravel({
            input: [
                'api/resources/css/app.css',
                'api/resources/js/app.js',
            ],
            refresh: true,
            buildDirectory: 'build',
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
    server: {
        host: '0.0.0.0',
        port: 5173,
    },
});