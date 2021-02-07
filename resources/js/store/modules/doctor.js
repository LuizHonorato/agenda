import axios from 'axios';

axios.defaults.baseURL = 'http://localhost/api';

const state = {
    doctors: [],
}

const actions = {
    getDoctors({commit}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/doctors')
                .then(res => resolve(res))
                .catch(err => reject(err));
        });
    }
}

const mutations = {
    SET_DOCTORS (state, doctors) {
        state.doctors = doctors
    },
}

export default {
    state,
    actions,
    mutations
}
