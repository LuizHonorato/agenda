<template>
    <div class="col-md-12 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between mt-3 mb-5">
            <h1>Agendamentos</h1>
            <button type="button" class="btn btn-primary new" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Novo</button>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">{{ this.update ? 'Atualizando' : 'Inserindo' }} agendamento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" v-model="id">

                            <div class="row mb-2">
                                <div class="form-group">
                                    <label for="selectDoctors">Paciente</label>
                                    <select v-model="selectedPatient" class="form-control" id="selectedPatient">
                                        <option v-for="patient in this.patients.patients" :key="patient.id" v-bind:value="{id: patient.id}">
                                            {{ patient.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="form-group">
                                    <label for="selectDoctors">Médicos</label>
                                    <select v-model="selectedDoctor" class="form-control" id="selectDoctors">
                                        <option v-for="doctor in this.doctors.doctors" :key="doctor.id" v-bind:value="{id: doctor.id}">
                                            {{ doctor.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2" v-if="this.selectedDoctor && this.selectedDoctor.id !== null">
                                <label>Data e hora</label>
                                <div class="col d-flex form-group">
                                    <vc-date-picker :min-date="new Date()" v-model="date" @dayclick="onDateChangeHandler">
                                        <template v-slot="{ inputValue, inputEvents }">
                                            <input
                                                class="bg-white border px-2 py-1 rounded form-control"
                                                :value="inputValue"
                                                v-on="inputEvents"
                                            />
                                        </template>
                                    </vc-date-picker>
                                    <select v-model="selectedHour" class="form-control ml-3">
                                        <option v-for="availability in this.doctorAvailability" :key="availability.hour" :disabled="!availability.available"  v-bind:value="{hour: availability.hour}">
                                            {{ availability.hour }}
                                        </option>
                                    </select>
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
                            <p>Você realmente deseja excluir este agendamento sistema?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" @click="deleteAppointment(id)">Excluir</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <table id="table_id" class="display">
            <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Consulta realizada?</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="appointment in this.appointments.appointments" :key="appointment.id">
                <td>{{ appointment.id }}</td>
                <td>{{ format(new Date(appointment.appointmentdate), 'dd/MM/yyyy HH:mm') }}</td>
                <td>{{ appointment.patient.name }}</td>
                <td>{{ appointment.doctor.name }}</td>
                <td>{{ appointment.completed ? 'Sim' : 'Não' }}</td>
                <td>
                    <i class="bi bi-pencil-square mr-3 action" @click="edit(appointment.id)"></i>
                    <i class="bi bi-trash action" @click="openModalDelete(appointment.id)"></i>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import {email, minLength, required} from "vuelidate/lib/validators";
    import { format } from 'date-fns'
    import {mapState} from "vuex";

export default {
    name: "AppointmentComponent",

    data: function() {
        return {
            id: '',
            selectedDoctor: {
                id: null
            },
            selectedPatient: {
                id: null
            },
            selectedHour: {
                hour: null
            },
            doctorAvailability: [],
            date: new Date(),
            errors: false,
            update: false,
            format
        }
    },

    validations: {

    },

    computed: {
        ...mapState(['appointments', 'doctors', 'patients'])
    },

    watch: {
        selectedDoctor () {
            if (this.selectedDoctor && this.selectedDoctor.id !== null) {
                this.onDateChangeHandler();
            }
        }
    },

    methods: {
        getAppointments() {
            this.$store.dispatch('getAppointments')
                .then(res => {
                    this.$store.commit('SET_APPOINTMENTS', res.data);
                })
                .catch(err => console.log(err));
        },

        getDoctors() {
            this.$store.dispatch('getDoctors')
                .then(res => {
                    this.$store.commit('SET_DOCTORS', res.data);
                })
                .catch(err => console.log(err));
        },

        getPatients() {
            this.$store.dispatch('getPatients')
                .then(res => {
                    this.$store.commit('SET_PATIENTS', res.data);
                })
                .catch(err => console.log(err));
        },

        onDateChangeHandler() {
            const formattedDate = format(new Date(this.date), 'yyyy-MM-dd');

            this.$store.dispatch('getDoctorAvailability', {
                doctor_id: this.selectedDoctor.id,
                date: formattedDate
            }).then(res => {
                this.doctorAvailability = res.data;
            })
                .catch(err => console.log(err));
        },

        submit() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                this.errors = true;
            } else {
                let action = this.update ? 'updateAppointment' : 'storeAppointment';

                const formattedDate = `${format(new Date(this.date), 'yyyy-MM-dd')} ${this.selectedHour.hour}`;

                const appointmentdate = format(new Date(formattedDate), 'yyyy-MM-dd HH:mm');

                this.$store.dispatch(action, {
                    id: this.id,
                    doctor_id: this.selectedDoctor.id,
                    patient_id: this.selectedPatient.id,
                    appointmentdate
                })
                    .then(() => {
                        this.getAppointments();

                        $('#staticBackdrop').modal('hide');
                        this.reset();
                    })
            }
        },

        edit(id) {
            let _this = this;
            this.$store.dispatch('getAppointment', id)
                .then(res => {
                    console.log(res);
                    this.id = res.data.id;
                    this.selectedDoctor.id = res.data.doctor_id;
                    this.selectedPatient.id = res.data.patient_id;
                    this.date = res.data.appointmentdate;
                    this.selectedHour.hour = format(new Date(res.data.appointmentdate), 'HH:mm');

                    this.onDateChangeHandler();

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

        deleteAppointment(id) {
            this.$store.dispatch('deleteAppointment', id)
                .then(res => {
                    $('#deleteModal').modal('hide');
                    this.getAppointments();
                    this.id = '';
                })
                .catch(err => {
                    console.log(err);
                });
        },

        reset() {
            this.id = '';
            this.selectedDoctor = {
                id: null
            };
            this.selectedPatient = {
                id: null
            };
            this.selectedHour = {
                hour: null
            };
            this.doctorAvailability = [];
            this.date = new Date();
        },

    },

    created() {
        this.$store.dispatch('getAppointments')
            .then(res => {
                this.$store.commit('SET_APPOINTMENTS', res.data);
            })
            .then(() => {
                $('#table_id').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                    }
                });
            })
            .catch(err => console.log(err));

        this.getDoctors();
        this.getPatients();
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

    .action {
        cursor: pointer;
    }
</style>
