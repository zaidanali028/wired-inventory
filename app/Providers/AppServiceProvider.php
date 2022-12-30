<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Config as ConfigModel;


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
        // USING THIS TO STORE STORE DETAILS THROUGH OUT THE APPLICATION

        $shop_details=ConfigModel::all()->first()->toArray();

        View::share('shop_details', $shop_details);
    }
}
