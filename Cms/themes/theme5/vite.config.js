import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'cms/themes/theme5/assets/css/theme.css',
                'cms/themes/theme5/assets/js/theme.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/themes/theme5',
        assetsDir: 'assets',
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
    resolve: {
        alias: {
            '@': '/resources/js',
            '~': '/node_modules',
        },
    },
});
