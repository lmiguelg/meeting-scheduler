<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\MeetingController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group( function(){

    
    Route::resource('meeting', MeetingController::class)->except([
        'edit', 'create']);

    Route::resource('meeting/registration', RegistrationController::class)->only([
        'store', 'destroy'
    ]);

    Route::post('user', [AuthController::class, 'store']);

    Route::post('user/signin', [AuthController::class, 'signin']);
});
