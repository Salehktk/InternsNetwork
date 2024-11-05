<?php

use Spatie\FlareClient\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\GoogleServiceController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\synchronizationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return "Cleared";
});

Route::get('migrate', function () {
    Artisan::call('migrate');
    return "run successfully";
});

Route::get('privacy/page', function () {
      return view('privacy');
});
Route::get('data/deletion', function () {
      return view('privacy');
});

Route::get('migrate-seed', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');

    return "Migrations and seeders executed successfully";
});

Route::get('/.well-known/apple-app-site-association', function() {
    $path = public_path('.well-known/apple-app-site-association');
    
    if (File::exists($path)) {
        return response()->file($path, [
            'Content-Type' => 'application/json'
        ]);
    }

    return response()->json(['error' => 'File not found'], 404);
})->withoutMiddleware(['auth', 'csrf']);

Route::get('/', function () {
    return view('auth.login');
})->name('login');


Route::get('/logout', [GoogleServiceController::class, 'logout'])->name('logout');

//calls for synchronization
Route::controller(synchronizationController::class)->group(function () {
    Route::get('/services/synchronization', 'servicesync');
    Route::get('/coaches/synchronization', 'coachesync');
});
Auth::routes();

Route::group(['middleware' => ['auth', 'role:superadmin'], 'prefix' => 'superadmin'], function () {
 
    Route::get('/dashboard', [HomeController::class, 'AdminDashboard'])->name('admin.dashboard');
    //coaches
    Route::resource('coaches', CoachController::class);

    // services
    Route::resource('services', ServiceController::class);

});


Route::group(['middleware' => ['role:user']], function() {
    Route::get('/user/dashboard', [HomeController::class, 'dashboard'])->name('users.dashboard');
});

Route::controller(GoogleAuthController::class)->group(function () {
    Route::get('/auth/google/redirect',  'googleRedirect')->name('googleRedirect');
    Route::get('/auth/google/callback',  'googleCallback')->name('googleCallback');
    ////
    Route::get('auth/facebook/redirect', 'redirectToFacebook')->name('auth.facebook');
    Route::get('auth/facebook/callback',  'handleFacebookCallback');
    
    Route::get('auth/apple',  'redirectToApple');
    Route::match(['get', 'post'], 'auth/apple/callback',  'handleAppleCallback');

});