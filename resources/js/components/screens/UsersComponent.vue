<template>
    <div class="col-md-12 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between mt-3 mb-5">
            <h1>Usuários</h1>
            <button type="button" class="btn btn-primary new" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Novo</button>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">{{ this.update ? 'Atualizando' : 'Inserindo' }} usuário</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" v-model="id">
                            <div class="row mb-3">
                                <div class="col form-group" :class="{ 'form-group--error': $v.name.$error }">
                                    <input type="text" class="form-control" placeholder="Nome" aria-label="name" v-model="name">
                                    <div v-if="this.errors">
                                        <div class="error mt-2" v-if="!$v.name.required">Campo obrigatório</div>
                                        <div class="error mt-2" v-if="!$v.name.minLength">Nome precisa ter no mínimo {{$v.name.$params.minLength.min}} letras.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <input type="email" class="form-control" placeholder="E-mail" aria-label="email" v-model="email">
                                    <div v-if="this.errors">
                                        <div class="error mt-2" v-if="!$v.email.required">Campo obrigatório</div>
                                        <div class="error mt-2" v-if="!$v.email.email">Este valor não é um e-mail válido.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col form-group" :class="{ 'form-group--error': $v.name.$error }">
                                    <input type="password" class="form-control" placeholder="Senha" aria-label="password" v-model="password">
                                    <div v-if="this.errors">
                                        <div class="error mt-2" v-if="!$v.password.required">Campo obrigatório</div>
                                        <div class="error mt-2" v-if="!$v.password.minLength">Senha precisa ter no mínimo {{$v.password.$params.minLength.min}} caracteres.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button class="btn btn-success" @click="submit">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Excluir</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Você realmente deseja excluir este usuário do sistema?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" @click="deleteUser(id)">Excluir</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <table id="table_id" class="display">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in this.users.users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <i class="bi bi-pencil-square mr-3 action" @click="edit(user.id)"></i>
                    <i class="bi bi-trash action" @click="openModalDelete(user.id)"></i>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {email, minLength, required} from "vuelidate/lib/validators";
import {mapState} from "vuex";

export default {
    name: "UsersComponent",

    data: function() {
        return {
            id: '',
            name: '',
            email: '',
            password: '',
            errors: false,
            update: false,
        }
    },

    validations: {
        name: {
            required,
            minLength: minLength(3)
        },
        email: {
            required,
            email
        },

        password: {
            required,
            minLength: minLength(6)
        }
    },

    computed: {
        ...mapState(['users'])
    },

    methods: {
        getUsers() {
            this.$store.dispatch('getUsers')
                .then(res => {
                    this.$store.commit('SET_USERS', res.data);
                })
                .catch(err => console.log(err));
        },

        submit() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                this.errors = true;
            } else {
                let action = this.update ? 'updateUser' : 'storeUser';

                this.$store.dispatch(action, {
                    id: this.id,
                    name: this.name,
                    email: this.email,
                    password: this.password
                })
                    .then(() => {
                        this.getUsers();

                        $('#staticBackdrop').modal('hide');
                        this.reset();
                    })
            }
        },

        edit(id) {
            let _this = this;
            this.$store.dispatch('getUser', id)
                .then(res => {
                    this.id = res.data.id;
                    this.name = res.data.name;
                    this.email = res.data.email;
                    this.password = res.data.password;

                    this.update = true;
                    $('#staticBackdrop').modal('show');
                })
                .catch(err => {
                    console.log(err);
                });
        },

        openModalDelete(id) {
            this.id = id;
            $('#deleteModal').modal('show');
        },

        deleteUser(id) {
            this.$store.dispatch('deleteUser', id)
                .then(res => {
                    $('#deleteModal').modal('hide');
                    this.getPatients();
                    this.id = '';
                })
                .catch(err => {
                    console.log(err);
                });
        },

        reset() {
            this.id = '';
            this.name = '';
            this.email = '';
            this.password = '';
        },
    },

    created() {
        this.$store.dispatch('getUsers')
            .then(res => {
                this.$store.commit('SET_USERS', res.data);
            })
            .then(() => {
                $('#table_id').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                    }
                });
            })
            .catch(err => console.log(err));
    }
}
</script>

<style scoped>
    .new {
        min-width: 7rem;
        font-size: 1rem;
        font-weight: bold;
    }

    .error {
        color: red;
        font-size: 12px;
    }

    .action {
        cursor: pointer;
    }
</style>
