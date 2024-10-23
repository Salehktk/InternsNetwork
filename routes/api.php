<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\serviceApiController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\CoachServicesController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Services\CoachServices;





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
Route::get('/dashboard', [serviceApiController::class, 'allServices'])->name('allCoachServices');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
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


Route::middleware('auth:sanctum')->post('/logout', [serviceApiController::class, 'logout']);

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
