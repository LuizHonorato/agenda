<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateAppointmentAvailabilityFormRequest;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use Carbon\Carbon;
use Exception;

class AppointmentsAvailabilityController extends Controller
{
    protected $appointmentsRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentsRepository)
    {
        $this->appointmentsRepository = $appointmentsRepository;
    }

    public function index(StoreUpdateAppointmentAvailabilityFormRequest $request)
    {
        try {
            $data = $request->all();

            $appointments = $this->appointmentsRepository->findDoctorAppointmentAvailabilityInDay($data['doctor_id'], $data['date']);

            $hourStart = 8;

            $hourStop = $hourStart + 10;

            $eachHourDay = array();

            for ($i = $hourStart; $i <= $hourStop; $i++) {
                $hourStart = $hourStart < 10 ? '0' . $hourStart : $hourStart;
                $hour = $hourStart . ':00';
                array_push($eachHourDay, $hour);
                $hourStart += 1;
            }

            $availability = array();

            foreach ($eachHourDay as $hour) {
                $hourDay = Carbon::parse($data['date'] . $hour);

                $hasAppointmentInHour = array_reduce($appointments->toArray(), function ($result, $item) use($hourDay, $data) {
                    $appointmentdate = Carbon::parse($item['appointmentdate']);
                    $appointmentdate = $appointmentdate->modify('-3 hours');

                    return $appointmentdate->toTimeString() == $hourDay->toTimeString();
                });

                array_push($availability, ['hour' => $hour, 'available' => !$hasAppointmentInHour && !$hourDay->isPast()]);
            }

            return response()->json($availability);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
