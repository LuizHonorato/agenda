import Vue from 'vue';
import Vuex from 'vuex';
import doctors from './modules/doctor';
import patients from './modules/patient';
import appointments from './modules/appointment';
import users from './modules/user';

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        doctors,
        patients,
        appointments,
        users
    }
});

export default store;
