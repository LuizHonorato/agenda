import Vue from 'vue';
import VueRouter from 'vue-router';
import App from '../components/App';
import Doctor from '../components/screens/DoctorComponent';
import Patient from "../components/screens/PatientComponent";
import Appointment from "../components/screens/AppointmentComponent";
import User from "../components/screens/UsersComponent";

Vue.use(VueRouter);

const routes = [
    {path: '/', component: App,
        children: [
            {
                path: '/agendamentos',
                name: 'Appointment',
                component: Appointment,
            },
            {
                path: '/medicos',
                name: 'Doctor',
                component: Doctor
            },
            {
                path: '/pacientes',
                name: 'Patient',
                component: Patient
            },
            {
                path: '/usuarios',
                name: 'User',
                component: User
            }
        ]
    }
];

const router = new VueRouter({
    routes
});

export default router;
