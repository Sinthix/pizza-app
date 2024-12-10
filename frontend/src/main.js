import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import i18n from './i18n';
import router from './router';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

createApp(App).use(router).use(i18n).mount('#app')
