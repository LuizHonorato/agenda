import Vue from 'vue';
import Vuex from 'vuex';
import doctors from './modules/doctor';
import patients from './modules/patient';

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        doctors,
        patients
    }
});

export default store;
