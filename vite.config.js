import { defineConfig } from 'vite';
import css from '@tailwindcss/vite';

export default defineConfig({
    plugins: [css()],
    build: {
        outDir: 'public/build',
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                styles: 'resources/css/app.css',
            },
            output: {
                entryFileNames: 'assets/[name].js',
                chunkFileNames: 'assets/[name].js',
                assetFileNames: 'assets/[name].[ext]',
            },
        },
    },
});
