<?php


namespace App\Repositories\Core\Eloquent;


use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;

class AppointmentEloquentRepository extends BaseEloquentRepository implements AppointmentRepositoryInterface
{
    public function entity()
    {
        return Appointment::class;
    }

    public function findDoctorAppointmentAvailabilityInDay($doctor_id, $date)
    {
        return $this->entity->select(['appointmentdate'])
                         ->where('doctor_id', $doctor_id)
                         ->whereDate('appointmentdate', $date)
                         ->get();
    }
}
