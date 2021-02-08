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
    },

    getDoctor({commit}, id) {
        return new Promise((resolve, reject) => {
            axios
                .get(`/doctors/${id}`)
                .then(res => resolve(res))
                .catch(err => reject(err));
        });
    },

    getDoctorAvailability({}, data) {
        return new Promise((resolve, reject) => {
            axios
                .get('/doctor-availability-day', {
                    params: {
                        doctor_id: data.doctor_id,
                        date: data.date
                    }
                })
                .then(res => resolve(res))
                .catch(err => reject(err));
        });
    },

    storeDoctor({dispatch}, doctor) {
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
        formData.append('is_active', doctor.is_active);

        return new Promise((resolve, reject) => {
            axios.post('/doctors', formData, config)
                .then(res => resolve())
                .catch(err => reject(err.response));
        });
    },

    updateDoctor({dispatch}, doctor) {
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
        formData.append('is_active', doctor.is_active);
        formData.append('_method', 'PUT');

        return new Promise((resolve, reject) => {
            axios.post(`/doctors/${doctor.id}`, formData, config)
                .then(data => resolve())
                .catch(err => reject(err.response));
        });
    },

    deleteDoctor({dispatch}, id) {
        return new Promise((resolve, reject) => {
            axios.delete(`/doctors/${id}`)
                .then(data => resolve(data))
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
