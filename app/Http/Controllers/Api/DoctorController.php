<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateDoctorFormRequest;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    protected $doctorsRepository;

    public function __construct(DoctorRepositoryInterface $doctorsRepository)
    {
        $this->doctorsRepository = $doctorsRepository;
    }

    public function index()
    {
        $doctors = $this->doctorsRepository->all();

        return response()->json($doctors);
    }

    public function store(StoreUpdateDoctorFormRequest $request)
    {
        try {
            $data = $request->all();

            if($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
                $name = md5($request->name . time());
                $extension = $request->profile_pic->extension();


                $nameFile = "{$name}.{$extension}";
                $data['profile_pic'] = $nameFile;
                $upload = $request->profile_pic->storeAs('doctors', $nameFile);

                if(!$upload) {
                    return response()->json(['error' => 'Falha ao armazenar a imagem.'], 500);
                }
            } else {
                $data['profile_pic'] = null;
            }

            if (isset($data['is_active'])) {
                if ($data['is_active'] == true) {
                    $data['is_active'] = 1;
                } else {
                    $data['is_active'] = 0;
                }
            }

            $doctor = $this->doctorsRepository->store($data);

            return response()->json($doctor);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $doctor = $this->doctorsRepository->findById($id);

            if (!$doctor) {
                return response()->json(['error' => 'Médico não encontrado.'], 404);
            }

            return response()->json($doctor);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(StoreUpdateDoctorFormRequest $request, $id)
    {
        try {
            $data = $request->all();

            $doctor = $this->doctorsRepository->findById($id);

            if (!$doctor) {
                return response()->json(['error' => 'Médico não encontrado.'], 404);
            }

            if($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
                $name = md5($request->name . time());
                $extension = $request->profile_pic->extension();

                if($doctor->profile_pic) {
                    if(Storage::exists("doctors/{$doctor->profile_pic}")) {
                        Storage::delete("doctors/{$doctor->profile_pic}");
                    }
                }

                $nameFile = "{$name}.{$extension}";
                $data['profile_pic'] = $nameFile;
                $upload = $request->profile_pic->storeAs('doctors', $nameFile);

                if(!$upload) {
                    return response()->json(['error' => 'Falha ao armazenar a imagem.'], 500);
                }
            }

            if (isset($data['is_active'])) {
                if ($data['is_active'] == true) {
                    $data['is_active'] = 1;
                } else {
                    $data['is_active'] = 0;
                }
            }

            $doctor = $this->doctorsRepository->update($id, $data);

            return response()->json($doctor);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $doctor = $this->doctorsRepository->findById($id);

            if (!$doctor) {
                return response()->json(['error' => 'Médico não encontrado.'], 404);
            }

            if($doctor->profile_pic) {
                if(Storage::exists("doctors/{$doctor->profile_pic}")) {
                    Storage::delete("doctors/{$doctor->profile_pic}");
                }
            }

            $doctor = $this->doctorsRepository->delete($id);

            return response()->json($doctor);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
