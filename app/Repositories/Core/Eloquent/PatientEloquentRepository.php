<?php


namespace App\Repositories\Core\Eloquent;


use App\Models\Patient;
use App\Repositories\Contracts\PatientRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;

class PatientEloquentRepository extends BaseEloquentRepository implements PatientRepositoryInterface
{
    public function entity()
    {
        return Patient::class;
    }
}
