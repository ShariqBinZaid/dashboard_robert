<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EmergencySettingsController;
use App\Http\Controllers\FakeCallSettingsController;
use App\Http\Controllers\FakeTextSettingsController;
use App\Http\Controllers\PanicSettingsController;
use App\Http\Controllers\SubscriptionsController;
use App\Models\FakeTextSettings;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
// Route::post('generateotp', [ApiController::class, 'generateotp']);
// Route::post('phoneotp', [ApiController::class, 'phoneotp']);


Route::middleware('auth:api')->group(function () {

    Route::controller(ApiController::class)->group(function () {
        Route::post('generateotp', 'generateotp')->name('user.generateotp');
        Route::post('phoneotp', 'phoneotp')->name('user.phoneotp');
        Route::post('changepassword', 'changepassword')->name('user.changepassword');
        Route::post('registerupdate', 'registerupdate')->name('user.registerupdate');
        Route::post('registerdelete/{id}', 'registerdelete')->name('user.registerdelete');
        Route::post('searchUser', 'searchUser')->name('user.searchUser');
        Route::post('search', 'search')->name('user.search');
        Route::post('searchTour', 'searchTour')->name('user.searchTour');
    });

    Route::controller(CategoriesController::class)->group(function () {
        Route::post('categories', 'store')->name('user.categories');
        Route::get('getcategories', 'getcategories')->name('user.getcategories');
    });


    Route::controller(EmergencySettingsController::class)->group(function () {
        Route::post('emergency', 'store')->name('user.categories');
        Route::get('getemergency', 'getemergency')->name('user.getemergency');
    });


    Route::controller(FakeTextSettingsController::class)->group(function () {
        Route::post('faketext', 'store')->name('user.faketext');
        Route::get('getfaketext', 'getfaketext')->name('user.getfaketext');
    });


    Route::controller(FakeCallSettingsController::class)->group(function () {
        Route::post('fakecall', 'store')->name('user.fakecall');
        Route::get('getfakecall', 'getfakecall')->name('user.getfakecall');
    });


    Route::controller(PanicSettingsController::class)->group(function () {
        Route::post('panic/update', 'store');
        Route::get('panic/details', 'getpanic');
        Route::post('panic/toggle', 'panicToggle');
    });


    Route::controller(SubscriptionsController::class)->group(function () {
        Route::post('subscriptions', 'store')->name('user.subscriptions');
        Route::get('getsubscriptions', 'getsubscriptions')->name('user.getsubscriptions');
    });
});
