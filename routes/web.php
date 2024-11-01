<?php

use Spatie\FlareClient\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoogleServiceController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\synchronizationController;
use App\Http\Controllers\SheetCoachServiceController;



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


Route::get('/import-services-sheet', [SheetCoachServiceController::class, 'importServicesheetDirectly']);

// Route::get('/', [CoachServicesController::class, 'index'])->name('home');

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
    if (Auth::check()) {
        return redirect()->route('serviceShow');  
    }
    
    return view('auth.login');
})->name('login');


Route::group(['middleware' => 'auth'], function () {
    // Route::get('superadmin/service/show', [ServiceController::class, 'show'])->name('serviceShow');
   
});



Route::get('/logout', [GoogleServiceController::class, 'logout'])->name('logout');
// Route::get('/import-services', [SheetCoachServiceController::class, 'importServicesheet'])->name('importServicesheet');

//calls for synchronization
Route::controller(synchronizationController::class)->group(function () {
    Route::get('/services/synchronization', 'servicesync');
    Route::get('/coaches/synchronization', 'coachesync');
});
Auth::routes();

Route::group(['middleware' => ['auth', 'role:superadmin'], 'prefix' => 'superadmin' ], function () {

    Route::get('/import-coach', [SheetCoachServiceController::class, 'importCoachsheet'])->name('importCoachsheet');
    
    Route::get('/all/service/header', [SheetCoachServiceController::class, 'AllserviceImport'])->name('AllserviceImport');
    Route::get('/service/show', [SheetCoachServiceController::class, 'serviceShow'])->name('serviceShow');
    Route::get('/coach/show', [SheetCoachServiceController::class, 'coachShow'])->name('coachShow');
    Route::get('/services-sheet', [SheetCoachServiceController::class, 'servicePiot'])->name('servicePiot');


});


Route::group(['middleware' => ['role:user']], function() {
    Route::get('/user/dashboard', [HomeController::class, 'dashboard'])->name('users.dashboard');
});




Route::get('/auth/google/redirect', [GoogleAuthController::class, 'googleRedirect'])->name('googleRedirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'googleCallback'])->name('googleCallback');


////
Route::get('auth/facebook/redirect',[GoogleAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [GoogleAuthController::class, 'handleFacebookCallback']);


Route::get('auth/apple', [GoogleAuthController::class, 'redirectToApple']);
Route::match(['get', 'post'], 'auth/apple/callback', [GoogleAuthController::class, 'handleAppleCallback']);