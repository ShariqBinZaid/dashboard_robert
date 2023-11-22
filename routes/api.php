<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EmergencySettingsController;
use App\Http\Controllers\FakeCallSettingsController;
use App\Http\Controllers\FakeTextSettingsController;
use App\Http\Controllers\PanicSettingsController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\TextInboxController;
use App\Http\Controllers\EmergencyMessageTemplatesController;
use App\Http\Controllers\EmergencyMessageSettingsController;

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
Route::post('verify', [ApiController::class, 'verify']);

Route::middleware('auth:api')->group(function () {

    Route::controller(ApiController::class)->group(function () {
        Route::post('changepassword', 'changepassword')->name('user.changepassword');
        Route::post('registerupdate', 'registerupdate')->name('user.registerupdate');
        Route::post('registerdelete/{id}', 'registerdelete')->name('user.registerdelete');
        Route::post('user/update/fcm', 'fcmid');
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
        Route::post('faketext/update', 'store');
        Route::get('faketext/details', 'details');
        Route::get('faketext/toggle', 'generateSMS');
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

    Route::controller(TextInboxController::class)->group(function() {
        Route::get('text/inbox', 'loadInbox');
        Route::get('text/inbox/threads/{name}', 'loadThreads');
    });

    Route::controller(EmergencyMessageTemplatesController::class)->group(function () {
        Route::post('template/store', 'store');
        Route::get('template/list', 'list');
        Route::get('template/details/{id}', 'details');
        Route::get('template/delete/{id}', 'delete');
    });

    Route::controller(EmergencyMessageSettingsController::class)->group(function () {
        Route::post('emergency/settings/update', 'update');
        Route::get('emergency/settings/details', 'details');
        Route::post('emergency/settings/add/schedule', 'addSchedule');
        Route::get('emergency/settings/toggle/schedule/{id}', 'toggleRepeatSchedule');
        Route::get('emergency/settings/toggle', 'toggleService');
    });
});
