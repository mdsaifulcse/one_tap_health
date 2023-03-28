<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use View,AUth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer( // for left nav --------------
            [
                'admin.layout.top-nav',
                'admin.layout.left-nav',
            ],
            function ($view)
            {
                $authUser=auth::user();
                $view->with(['authUser'=>$authUser]);
            });

        JsonResource::withoutWrapping();
    }
}
