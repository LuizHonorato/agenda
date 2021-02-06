<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateAppointmentFormRequest;
use App\Repositories\Contracts\AppointmentRepositoryInterface;
use Exception;

class AppointmentController extends Controller
{
    protected $appointmentsRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentsRepository)
    {
        $this->appointmentsRepository = $appointmentsRepository;
    }

    public function index()
    {
        $appointments = $this->appointmentsRepository->all();

        return response()->json($appointments);
    }

    public function store(StoreUpdateAppointmentFormRequest $request)
    {
        try {
            $data = $request->all();

            $appointment = $this->appointmentsRepository->store($data);

            return response()->json($appointment);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $appointment = $this->appointmentsRepository->findById($id);

            if (!$appointment) {
                return response()->json(['error' => 'Agendamento não encontrado.'], 404);
            }

            return response()->json($appointment);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(StoreUpdateAppointmentFormRequest $request, $id)
    {
        try {
            $data = $request->all();

            $appointment = $this->appointmentsRepository->findById($id);

            if (!$appointment) {
                return response()->json(['error' => 'Agendamento não encontrado.'], 404);
            }

            $appointment = $this->appointmentsRepository->update($id, $data);

            return response()->json($appointment);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $appointment = $this->appointmentsRepository->findById($id);

            if (!$appointment) {
                return response()->json(['error' => 'Agendamento não encontrado.'], 404);
            }

            $appointment = $this->appointmentsRepository->delete($id);

            return response()->json($appointment);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
