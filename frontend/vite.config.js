import vue from '@vitejs/plugin-vue';

export default {
  plugins: [vue()],
  server: {
    proxy: {
      '/api': 'http://localhost:8000',
    }
  }
};