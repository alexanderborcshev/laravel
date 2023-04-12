import { createApp } from 'vue';
import { VueMasonryPlugin } from 'vue-masonry/src/masonry.plugin';
import App from './App.vue';
import router from './router';
import store from './store';
import VueInputMask from './helpers/vue-inputmask';

createApp(App)
    .use(store)
    .use(router)
    .use(VueInputMask)
    .use(VueMasonryPlugin)
    .mount('#app');
