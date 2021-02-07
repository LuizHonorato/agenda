require('./bootstrap');

window.Vue = require('vue').default;
import Vuex from 'vuex';
// import dt from 'datatables.net';
import router from './router';
import store from './store';
import Vuelidate from 'vuelidate';
import VueMask from 'v-mask';

Vue.use(Vuex);
Vue.use(Vuelidate);
Vue.use(VueMask);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = new Vue({
    el: '#app',
    router,
    store
});
