import axios from 'axios';

axios.defaults.baseURL = 'http://localhost/api';

const state = {
    users: [],
}

const actions = {
    getUsers({commit}) {
        return new Promise((resolve, reject) => {
            axios
                .get('/users')
                .then(res => resolve(res))
                .catch(err => reject(err));
        });
    },

    getUser({commit}, id) {
        return new Promise((resolve, reject) => {
            axios
                .get(`/users/${id}`)
                .then(res => resolve(res))
                .catch(err => reject(err));
        });
    },

    storeUser({dispatch}, user) {
        return new Promise((resolve, reject) => {
            axios.post('/users', {
                name: user.name,
                email: user.email,
                password: user.password
            }).then(res => resolve())
                .catch(err => reject(err.response));
        });
    },

    updateUser({dispatch}, user) {
        return new Promise((resolve, reject) => {
            axios.post(`/users/${doctor.id}`, {
                name: user.name,
                email: user.email,
                password: user.password
            })
                .then(data => resolve())
                .catch(err => reject(err.response));
        });
    },

    deleteUser({dispatch}, id) {
        return new Promise((resolve, reject) => {
            axios.delete(`/users/${id}`)
                .then(data => resolve(data))
                .catch(err => reject(err));
        });
    }
}

const mutations = {
    SET_USERS (state, users) {
        state.users = users
    },
}

export default {
    state,
    actions,
    mutations
}
