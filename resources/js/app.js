require('./bootstrap');

import {createApp} from 'vue';
import store from './store';

const initApp = () => {
    // Register top level components

    createApp({
        data() {
            return {
                message: "Initial App"
            }
        }
    })
        .use(store)
        .mount('#app');
};

initApp();
