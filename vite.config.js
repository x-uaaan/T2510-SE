// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    build: {
        outDir: 'api/public/build',
        emptyOutDir: true,
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/chunk-[name].js`,
                assetFileNames: (assetInfo) => {
                    const extType = assetInfo.name.split('.').at(1);
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
                        return `assets/img/[name].[ext]`;
                    }
                    if (/css/i.test(extType)) {
                        return `assets/css/[name].[ext]`;
                    }
                    return `assets/[name].[ext]`;
                }
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
});