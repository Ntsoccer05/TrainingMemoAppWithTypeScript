import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css'],
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
  server: {
    host: true,
    hmr: {
      host: 'localhost'
    },
    // ホットリロード設定
    watch: {
        usePolling: true
    }
  },
  resolve: {
    alias: {
      '@': '/resources/js',
    },
  },
});