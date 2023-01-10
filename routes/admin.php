<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\API\Admin\Activity\ActivityController;
use App\Http\Controllers\v1\API\Admin\Auth\AuthController;

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

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Here are all admin API routes
*/

Route::prefix('v1/admin')->group(function() {

    // api/v1/admin/auth Admin auth
    Route::prefix('auth')->name('auth.')->group(function() {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login')->name('login');

        });

        // All route for logged admins should go down here under this group
        Route::middleware(['auth:sanctum', 'api-admin'])->group(function () {

            // Activity endpoints
            Route::prefix('activities')->name('activities.')->controller(ActivityController::class)->group(function() {
                Route::get('/', 'allActivities')->name('get-all');
                Route::post('/', 'addNew')->name('add-new');
                Route::get('/{id}', 'getActivity')->name('get-one');
                Route::put('/{id}', 'updateActivity')->name('update');
                Route::delete('/{id}', 'deleteActivity')->name('delete');
                Route::post('/{id}/image', 'uploadImage')->name('upload-image');
                Route::delete('/{id}/image', 'deleteImage')->name('delete-image');
            });
        });
    });
});
