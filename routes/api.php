<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
use Illuminate\Support\Facades\Route;


Route::apiResources([
    'doctors' => DoctorController::class,
    'patients' => PatientController::class,
    'appointments' => AppointmentController::class
]);
