import './bootstrap';

import { createApp } from 'vue';

import store from './store/index.js'
import App from './layouts/App.vue';
import router from './router';

createApp(App)
.use(router)
.use(store)
.mount("#app");
