<template>
    <div class="col-md-12 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between mt-3 mb-5">
            <h1>Médicos</h1>
            <button type="button" class="btn btn-primary new" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Novo</button>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Inserindo médico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col form-group" :class="{ 'form-group--error': $v.name.$error }">
                                    <input type="text" class="form-control" placeholder="Nome" aria-label="name" v-model="name">
                                    <div class="error mt-2" v-if="!$v.name.required">Campo obrigatório</div>
                                    <div class="error mt-2" v-if="!$v.name.minLength">Nome precisa ter no mínimo {{$v.name.$params.minLength.min}} letras.</div>
                                </div>
                                <div class="col">
                                    <input type="email" class="form-control" placeholder="E-mail" aria-label="email" v-model="email">
                                    <div class="error mt-2" v-if="!$v.email.required">Campo obrigatório</div>
                                    <div class="error mt-2" v-if="!$v.email.email">Este valor não é um e-mail válido.</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Telefone" aria-label="phone"  v-model="phone">
                                    <div class="error mt-2" v-if="!$v.phone.required">Campo obrigatório</div>
                                </div>
                            </div>
                            <div class="form-group form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="is_active" v-model="is_active">
                                <label class="form-check-label" for="is_active">Ativo?</label>
                            </div>

                            <div class="form-group mb-3">
                                <label for="profile_pic">Foto</label>
                                <input type="file" class="form-control-file" ref="profile_pic" id="profile_pic" @change="onFileChange">
                            </div>

                            <div class="row mb-3" v-if="imagePreview !== null">
                                <img class="imagePreview" :src="imagePreview" alt="avatar">
                                <button type="button" class="btn-close" aria-label="Close" @click="resetImage"></button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button class="btn btn-success" @click="submit">Salvar</button>
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
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="doctor in this.doctors.doctors" :key="doctor.id">
                <td>{{ doctor.id }}</td>
                <td>{{ doctor.name }}</td>
                <td>{{ doctor.email }}</td>
                <td>{{ doctor.phone }}</td>
                <td>EDIT | DEL</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    import { required, minLength, email } from 'vuelidate/lib/validators';

    export default {
        name: "DoctorComponent",

        data: function() {
            return {
                name: '',
                email: '',
                phone: '',
                is_active: true,
                profile_pic: null,
                imagePreview: null
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
            phone: {
                required
            }
        },

        computed: {
          ...mapState(['doctors'])
        },

        methods: {
            submit() {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    console.log('ERRO');
                } else {
                    console.log('OK');
                }
            },

            onFileChange(e) {
              if(!e) {
                return;
              }

              this.previewImage(e.target.files[0]);
            },

            previewImage(file) {
                let reader = new FileReader();

                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                    this.profile_pic = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            resetImage() {
                this.imagePreview = null;
                this.profile_pic = null;
                this.$refs.profile_pic.value=null;
            }
        },

        created() {
            this.$store.dispatch('getDoctors')
                    .then(res => {
                       this.$store.commit('SET_DOCTORS', res.data);
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

    .imagePreview {
        width: 200px;
        height: 170px;
        border-radius: 50%;
    }

    .error {
        color: red;
        font-size: 12px;
    }
</style>
