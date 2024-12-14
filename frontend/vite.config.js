import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
    },
  },
  server: {
    proxy: {
      '/api': 'http://localhost:8000',
    }
  },
  test: {
    globals: true,
    setupFiles: './src/tests/setup.js',
    environment: 'jsdom', 
    transformMode: {
      web: [/\.[jt]sx$/],
    },
  },
});