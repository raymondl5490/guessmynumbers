require('./bootstrap');
import { createApp } from 'vue';

import store from './store';
import Home from "./pages/Home.vue";

const app = createApp({});

// Load Components
app.component('Home', Home);

app.use(store);
app.mount('#app');

