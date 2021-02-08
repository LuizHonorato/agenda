<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserFormRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    protected $usersRepository;

    public function __construct(UserRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function index()
    {
        $users = $this->usersRepository->all();

        return response()->json($users);
    }

    public function store(StoreUpdateUserFormRequest $request)
    {
        try {
            $data = $request->all();

            $data['password'] = Hash::make($data['password']);

            $user = $this->usersRepository->store($data);

            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->usersRepository->findById($id);

            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado.'], 404);
            }

            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(StoreUpdateUserFormRequest $request, $id)
    {
        try {
            $data = $request->all();

            $user = $this->usersRepository->findById($id);

            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado.'], 404);
            }

            $user = $this->usersRepository->update($id, $data);

            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->usersRepository->findById($id);

            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado.'], 404);
            }

            $user = $this->usersRepository->delete($id);

            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
