import {createPinia} from "pinia";
import {createPersistedStatePlugin} from 'pinia-plugin-persistedstate-2'
import VueConfetti from 'vue-confetti'

require('./bootstrap');
import {createApp} from 'vue';

import Home from "./pages/Home.vue";
import Admin from "./pages/Admin.vue";

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

window.Vapor = require('laravel-vapor');
const app = createApp({});
const pinia = createPinia();
pinia.use(createPersistedStatePlugin());
app.use(pinia);

app.use(ElementPlus)
app.use(VueConfetti);

app.mixin({
    methods: {
        asset: window.Vapor.asset
    }
});

// Load Components
app.component('Home', Home);
app.component('Admin', Admin);

app.mount('#app');

