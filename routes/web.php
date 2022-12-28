<?php
// https://preview.themeforest.net/item/revel-ecommerce-multi-vendor-multipurpose-html-template/full_screen_preview/39607470?_ga=2.119932235.2128217863.1666533585-796281154.1666533585&_gac=1.211928736.1666533585.EAIaIQobChMIst2CmcD2-gIVBhoGAB26bgFfEAAYASAAEgLPZvD_BwE
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Front\indexController;
use App\Models\Config as ConfigModel;
use App\Models\Admin as AdminModel;



// laravel version was 8.75


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::namespace('App\Http\Controllers\Front')->group(function(){

//     Route::get('/','indexController@index');
//     });

Route::get('/', function () {
    if(ConfigModel::all()->count()<=0 && AdminModel::all()->count()<=0){
        // new client and app needs configuration
return redirect('/config-shop');

    }else{
return redirect('/admin/dashboard');


    }
    // return view('welcome');
});




// Route::get('/','adminController@index');
Route::prefix('/')->namespace('App\Http\Controllers\Admin')->group(function(){
    Route::get('config-shop','adminController@index');

});

//Clear App cache:
Route::get('/ref', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('clear-compiled');
    Artisan::call('config:clear');
    Artisan::call('config:cache');

    return 'Project Refreshed Successfully!!!';
});


require __DIR__.'/auth.php';



Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){

    Route::match(['get','post'],'login','adminController@login');
    Route::get('logout','adminController@logout');


    Route::group(['middleware'=>['admin']],function(){
        Route::get('/linkstorage', function () {
            Artisan::call('storage:link');
            dd('Storage link :)');
        });
        Route::get('dashboard','adminController@dashboard');
        Route::get('pos','adminController@pos');
        Route::get('orders','adminController@orders');
        Route::get('expenses','adminController@expenses');
        Route::get('employee-management','employeesController@employee_management');
        Route::get('admin-management','adminController@admin_management');
        Route::get('supplier-management','adminController@supplier_management');
        Route::get('salary-management','adminController@salary_management');
        Route::get('all-salaries','adminController@all_salaries');
        Route::get('customers-management','adminController@customers_management');



        Route::post('check-current-password','adminController@check_current_password');
        Route::get('view-vendor-details/{vendor_id}','adminController@view_vendor_details');
        Route::get('change-admin-status/{admin_id}/{current_status}','adminController@change_admin_status');
        Route::match(['get','post'],'update-password','adminController@update_password');
        Route::match(['get','post'],'update-details','adminController@update_details');
        Route::match(['get','post'],'update-vendor-details/{slug}','adminController@update_vendor_details');

         Route::get('categories','mainCateogriesController@main_categories');

        // products route
        Route::get('products','productsController@products');
        Route::get('change-section-status/{section_id}/{current_status}','sectionsController@change_section_status');
        Route::get('get-section-data/{section_id}','sectionsController@get_section_data');
        Route::post('update-section','sectionsController@update_section');

    });


}

);








