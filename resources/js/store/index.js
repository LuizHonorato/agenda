import Vue from 'vue';
import Vuex from 'vuex';
import doctors from './modules/doctor';

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        doctors
    }
});

export default store;
