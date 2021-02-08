import axios from 'axios';

axios.defaults.baseURL = 'http://localhost/api';

const state = {
    appointments: [],
}

const actions = {
    getAppointments({commit}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/appointments')
                .then(res => resolve(res))
                .catch(err => reject(err));
        });
    },

    getAppointment({commit}, id) {
        return new Promise((resolve, reject) => {
            axios
                .get(`/appointments/${id}`)
                .then(res => resolve(res))
                .catch(err => reject(err));
        });
    },

    storeAppointment({dispatch}, appointment) {
        return new Promise((resolve, reject) => {
            axios.post('/appointments', {
                doctor_id: appointment.doctor_id,
                patient_id: appointment.patient_id,
                appointmentdate: appointment.appointmentdate
            })
                .then(res => resolve())
                .catch(err => reject(err.response));
        });
    },

    updateAppointment({dispatch}, appointment) {
        return new Promise((resolve, reject) => {
            axios.post(`/appointments/${doctor.id}`, {
                doctor_id: appointment.doctor_id,
                patient_id: appointment.patient_id,
                appointmentdate: appointment.appointmentdate
            })
                .then(data => resolve())
                .catch(err => reject(err.response));
        });
    },

    deleteAppointment({dispatch}, id) {
        return new Promise((resolve, reject) => {
            axios.delete(`/appointments/${id}`)
                .then(data => resolve(data))
                .catch(err => reject(err));
        });
    }
}

const mutations = {
    SET_APPOINTMENTS (state, appointments) {
        state.appointments = appointments
    },
}

export default {
    state,
    actions,
    mutations
}
