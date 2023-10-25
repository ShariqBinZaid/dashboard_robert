<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;


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
});
