<?php


namespace App\Repositories\Core\Eloquent;


use App\Models\Doctor;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;

class DoctorEloquentRepository extends BaseEloquentRepository implements DoctorRepositoryInterface
{
    public function entity()
    {
        return Doctor::class;
    }
}
