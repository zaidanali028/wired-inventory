<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Config as ConfigModel;
use App\Models\Logo as LogoModel;
use Illuminate\Database\Eloquent\Factories\Factory;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */


    /**
     * Bootstrap any application services.
     *
     * @return void
     */


// public function register()
// {
//     Factory::guessFactoryNamesUsing(function ($class) {
//         return 'Database\\Factories\\' . class_basename($class) . 'Factory';
//     });
// }
    public function boot()
    {
        // USING THIS TO STORE STORE DETAILS THROUGH OUT THE APPLICATION

        // $shop_details=ConfigModel::all()->count()>=1?ConfigModel::all()->first()->toArray():[];
        // $small_logo=LogoModel::all()->count()>=1?LogoModel::where(['media_index'=>0])->first()->toArray():[];
        // $big_logo=LogoModel::all()->count()>=1?LogoModel::where(['media_index'=>1])->first()->toArray():[];

        // View::share('shop_details', $shop_details);
        // View::share('small_logo', $small_logo);
        // View::share('big_logo', $big_logo);
    }


}
