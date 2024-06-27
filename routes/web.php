<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use Spatie\Permission\Middlewares\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/tenants', function () {
    return view('tenants');
})->middleware(['auth'])->name('tenants');

// Route::get('/sites', function () {
//     return view('sites');
// })->middleware(['auth'])->name('sites');

//Route::post('sites/create', [LandlordSiteController::class, 'create'])->name('sites.create');


// Route::middleware(['auth', 'landlord'])->group(function () {
//     // Route::get('sites/create', [LandlordSiteController::class, 'create'])->name('sites.create');
   // Route::post('sites', [LandlordSiteController::class, 'store'])->name('sites.store');
// });

// Route for viewing sites
Route::middleware(['auth'])->group(function () {
    Route::get('/sites', [SiteController::class, 'index'])->name('sites.index');
});

// Route for creating sites
Route::middleware(['auth', 'role:landlord'])->group(function () {
    Route::get('/create', [SiteController::class, 'create'])->name('sites.create');
    Route::post('/sites', [SiteController::class, 'store'])->name('sites.store');
    Route::get('/sites/view/{id}', [SiteController::class, 'view_site'])->name('sites.view');
});

require __DIR__ . '/auth.php';
