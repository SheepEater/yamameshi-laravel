import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: true,          // これで 0.0.0.0 でバインド
        port: 5174,
        hmr: {
            host: 'localhost', // 自分のPCで開くときは 'localhost'
            port: 5174,        // Viteのポート 5173から5174に変更した
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/home.css',
            ],
            refresh: true,
        }),
    ],
});
