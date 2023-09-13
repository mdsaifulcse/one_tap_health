<?php

namespace App\Providers;

use App\Models\Doctor;
use App\Models\DoctorAppointment;
use App\Models\Hospital;
use App\Models\TestOrder;
use Illuminate\Support\ServiceProvider;
use View,Auth,Session;

class AdminDashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*',
            function ($view)
            {
                $countActiveDoctor=Doctor::countActiveDoctor();
                $countInactiveDoctor=Doctor::countInactiveDoctor();

                $countActiveHospital=Hospital::countActiveHospital();
                $countInactiveHospital=Hospital::countInactiveHospital();

                $countPendingTestOrder=TestOrder::countPendingTestOrder();
                $countPaidTestOrder=TestOrder::countPaidTestOrder();

                $countPaidAppointment=DoctorAppointment::countPaidAppointment();
                $countPendingAppointment=DoctorAppointment::countPendingAppointment();


                $view->with([
                    // Doctor---------
                    'countActiveDoctor' => $countActiveDoctor,
                    'countInactiveDoctor'=>$countInactiveDoctor,
                    // Hospital-----------
                    'countActiveHospital' => $countActiveHospital,
                    'countInactiveHospital'=>$countInactiveHospital,
                    // Test Order
                    'countPaidTestOrder'=>$countPaidTestOrder,
                    'countPendingTestOrder' => $countPendingTestOrder,
                    // Test Order
                    'countPaidAppointment' => $countPaidAppointment,
                    'countPendingAppointment'=>$countPendingAppointment,
                ]);
            });
    }
}
