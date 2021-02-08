<?php

namespace App\Providers;

use App\Repositories\Contracts\AppointmentRepositoryInterface;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use App\Repositories\Contracts\PatientRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Core\Eloquent\AppointmentEloquentRepository;
use App\Repositories\Core\Eloquent\DoctorEloquentRepository;
use App\Repositories\Core\Eloquent\PatientEloquentRepository;
use App\Repositories\Core\Eloquent\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            DoctorRepositoryInterface::class,
            DoctorEloquentRepository::class
        );

        $this->app->bind(
            PatientRepositoryInterface::class,
            PatientEloquentRepository::class
        );

        $this->app->bind(
            AppointmentRepositoryInterface::class,
            AppointmentEloquentRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserEloquentRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
