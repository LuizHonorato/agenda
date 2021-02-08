<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AppointmentsAvailabilityController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;


Route::apiResources([
    'doctors' => DoctorController::class,
    'patients' => PatientController::class,
    'appointments' => AppointmentController::class,
    'users' => UsersController::class
]);

Route::get('doctor-availability-day', [AppointmentsAvailabilityController::class, 'index']);
