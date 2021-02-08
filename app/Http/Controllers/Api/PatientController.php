<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePatientFormRequest;
use App\Repositories\Contracts\PatientRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    protected $patientsRepository;

    public function __construct(PatientRepositoryInterface $patientsRepository)
    {
        $this->patientsRepository = $patientsRepository;
    }

    public function index()
    {
        $patients = $this->patientsRepository->all();

        return response()->json($patients);
    }

    public function store(StoreUpdatePatientFormRequest $request)
    {
        try {
            $data = $request->all();

            if($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
                $name = md5($request->name . time());
                $extension = $request->profile_pic->extension();


                $nameFile = "{$name}.{$extension}";
                $data['profile_pic'] = $nameFile;
                $upload = $request->profile_pic->storeAs('patients', $nameFile);

                if(!$upload) {
                    return response()->json(['error' => 'Falha ao armazenar a imagem.'], 500);
                }
            } else {
                $data['profile_pic'] = null;
            }

            $patient = $this->patientsRepository->store($data);

            return response()->json($patient);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $patient = $this->patientsRepository->findById($id);

            if (!$patient) {
                return response()->json(['error' => 'Paciente não encontrado.'], 404);
            }

            return response()->json($patient);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(StoreUpdatePatientFormRequest $request, $id)
    {
        try {
            $data = $request->all();

            $patient = $this->patientsRepository->findById($id);

            if (!$patient) {
                return response()->json(['error' => 'Paciente não encontrado.'], 404);
            }

            if($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
                $name = md5($request->name . time());
                $extension = $request->profile_pic->extension();

                if($patient->profile_pic) {
                    if(Storage::exists("patients/{$patient->profile_pic}")) {
                        Storage::delete("patients/{$patient->profile_pic}");
                    }
                }

                $nameFile = "{$name}.{$extension}";
                $data['profile_pic'] = $nameFile;
                $upload = $request->profile_pic->storeAs('patients', $nameFile);

                if(!$upload) {
                    return response()->json(['error' => 'Falha ao armazenar a imagem.'], 500);
                }
            } else {
                if ($patient->profile_pic) {
                    if(Storage::exists("patients/{$patient->profile_pic}")) {
                        Storage::delete("patients/{$patient->profile_pic}");
                    }
                }

                $data['profile_pic'] = null;
            }

            $patient = $this->patientsRepository->update($id, $data);

            return response()->json($patient);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $patient = $this->patientsRepository->findById($id);

            if (!$patient) {
                return response()->json(['error' => 'Paciente não encontrado.'], 404);
            }

            if($patient->profile_pic) {
                if(Storage::exists("patients/{$patient->profile_pic}")) {
                    Storage::delete("patients/{$patient->profile_pic}");
                }
            }

            $patient = $this->patientsRepository->delete($id);

            return response()->json($patient);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
