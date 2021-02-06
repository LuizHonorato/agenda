<?php


namespace App\Repositories\Contracts;


interface AppointmentRepositoryInterface
{
    public function findDoctorAppointmentAvailabilityInDay($doctor_id, $date);
}
