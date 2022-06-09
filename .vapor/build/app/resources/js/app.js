import {createPinia} from "pinia/dist/pinia";
import {createPersistedStatePlugin} from 'pinia-plugin-persistedstate-2'

require('./bootstrap');
import {createApp} from 'vue';

import Home from "./pages/Home.vue";

const app = createApp({});
const pinia = createPinia();
pinia.use(createPersistedStatePlugin());
app.use(pinia);

// Load Components
app.component('Home', Home);

app.mount('#app');

