import axios from 'axios';

axios.defaults.baseURL = 'http://localhost/api';

const state = {
    patients: [],
}

const actions = {
    getPatients({commit}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/patients')
                .then(res => resolve(res))
                .catch(err => reject(err));
        });
    },

    getPatient({commit}, id) {
        return new Promise((resolve, reject) => {
            axios
                .get(`/patients/${id}`)
                .then(res => resolve(res))
                .catch(err => reject(err));
        });
    },

    storePatient({dispatch}, doctor) {
        const config = {
            headers: {
                'Content-Type' : 'multipart/form-data'
            }
        };

        let formData = new FormData();
        formData.append('name', doctor.name);
        formData.append('email', doctor.email);
        formData.append('phone', doctor.phone);
        formData.append('profile_pic', doctor.profile_pic);

        return new Promise((resolve, reject) => {
            axios.post('/patients', formData, config)
                .then(res => resolve())
                .catch(err => reject(err.response));
        });
    },

    updatePatient({dispatch}, doctor) {
        const config = {
            headers: {
                'Content-Type' : 'multipart/form-data'
            }
        };

        let formData = new FormData();
        formData.append('name', doctor.name);
        formData.append('email', doctor.email);
        formData.append('phone', doctor.phone);
        formData.append('profile_pic', doctor.profile_pic);
        formData.append('_method', 'PUT');

        return new Promise((resolve, reject) => {
            axios.post(`/patients/${doctor.id}`, formData, config)
                .then(data => resolve())
                .catch(err => reject(err.response));
        });
    },

    deletePatient({dispatch}, id) {
        return new Promise((resolve, reject) => {
            axios.delete(`/patients/${id}`)
                .then(data => resolve(data))
                .catch(err => reject(err));
        });
    }
}

const mutations = {
    SET_PATIENTS (state, patients) {
        state.patients = patients
    },
}

export default {
    state,
    actions,
    mutations
}
