<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\API\User\Activity\ActivityController;
use App\Http\Controllers\v1\API\User\Auth\AuthController;

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
| User Routes
|--------------------------------------------------------------------------
| Here are all user API routes
*/

// Register route respective models
Route::prefix('')->group(base_path('routes/admin.php'));

Route::prefix('v1/user')->group(function() {

    // api/v1/user/auth User auth
    Route::prefix('auth')->name('auth.')->group(function() {
        Route::controller(AuthController::class)->group(function () {
            Route::post('register', 'register')->name('register');
            Route::post('login', 'login')->name('login');

        });

        // All route for logged users should go down here under this group
        Route::middleware(['auth:sanctum', 'api-user'])->group(function () {

            // Activity endpoints
            Route::prefix('activities')->name('activities.')->controller(ActivityController::class)->group(function() {
                Route::get('/', 'allActivities')->name('get-all');
                Route::get('/{id}', 'getActivity')->name('get-one');
            });
        });
    });
});
