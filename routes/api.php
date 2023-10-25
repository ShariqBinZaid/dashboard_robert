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
Route::post('generateotp', [ApiController::class, 'generateotp']);
Route::post('phoneotp', [ApiController::class, 'phoneotp']);

Route::controller(ApiController::class)->group(function () {
    Route::post('userupdate', 'userupdate')->name('user.userupdate');
    Route::post('changepassword', 'changepassword')->name('user.changepassword');
    Route::post('updateregister', 'updateregister')->name('user.updateregister');
    Route::post('registerdelete/{id}', 'registerdelete')->name('user.registerdelete');
    Route::post('vendordashboard', 'vendordashboard')->name('user.vendordashboard');
    Route::post('searchUser', 'searchUser')->name('user.searchUser');
    Route::post('searchLoc', 'searchLoc')->name('user.searchLoc');
    Route::post('search', 'search')->name('user.search');
    Route::post('searchTour', 'searchTour')->name('user.searchTour');
});

Route::middleware('auth:api')->group(function () {
});
