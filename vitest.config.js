import { defineConfig } from 'vitest/config';

export default defineConfig({
    test: {
        // ブラウザの DOM API を使うため jsdom を使用する
        environment: 'jsdom',
        include: ['resources/js/**/*.test.js'],
    },
});
