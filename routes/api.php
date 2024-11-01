<?php

use Illuminate\Http\Request;
use App\Services\CoachServices;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\serviceApiController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Api\synchronizationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/testAPI', [GoogleAuthController::class, 'test']);

// Route::middleware('auth:sanctum')->group(function () {
    Route::controller(serviceApiController::class)->group(function () {
        Route::get('/services', 'allServices');
        Route::get('/coaches', 'allCoaches');
        Route::post('/logout', 'logout'); // Logout route
        Route::get('/single/service/{id}', 'singleServiceShow');
        Route::get('/single/coach/{id}', 'singleCoachShow');
    });

    Route::controller(SearchController::class)->group(function () {
        Route::post('/dashboard/search', 'dashboardSearch');
        Route::post('/search/coaches', 'CoachesSearch');
        Route::post('/search/services', 'ServicesSearch');
        
    });

   //calls for synchronization
    Route::controller(synchronizationController::class)->group(function () {
        Route::get('/services/synchronization', 'servicesync');
        Route::get('/coaches/synchronization', 'coachesync');
        
    });


// });


Route::post('/login', [serviceApiController::class, 'login']);
Route::post('/register', [serviceApiController::class, 'createUser']);
// Route::post('/logout', [serviceApiController::class, 'logout']);

Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'googleRedirectapi'])->name('googleRedirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'googleCallbackApi'])->name('googleCallback');


Route::get('auth/facebook/redirect',[GoogleAuthController::class, 'redirectToFacebookApi'])->name('auth.facebook');
Route::get('auth/facebook/callback', [GoogleAuthController::class, 'handleFacebookCallbackApi']);



Route::get('auth/apple', [GoogleAuthController::class, 'redirectToApple']);
Route::match(['get', 'post'], 'auth/apple/callback', [GoogleAuthController::class, 'handleAppleCallback']);



Route::get('/universal-link/test', [GoogleAuthController::class, 'handleTest']);


    // Route::get('/dashboard', [serviceApiController::class, 'allServices'])->name('allCoachServices');


// Route::middleware(['auth:sanctum'])->group(function () {
    
// });

// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::get('/dashboard', function (Request $request) {
//         dd('Incoming request:', $request->all());
//     })->name('allCoachServices');
// });
