<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\RoomController;
use Spatie\Permission\Middlewares\RoleMiddleware;
use App\Http\Controllers\UserController;

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

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/tenants', function () {
    return view('tenants');
})->middleware(['auth'])->name('tenants');


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

// Route for rooms
Route::middleware(['auth', 'role:landlord'])->group(function () {
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
});

Route::get('/users', [UserController::class, 'search']);
Route::post('/rooms/{room}/assign', [RoomController::class, 'assignUser']);
Route::put('/rooms/{roomId}/remove-tenant', [RoomController::class, 'removeTenant'])->name('rooms.remove-tenant');
// Route to delete room
Route::delete('/rooms/{roomId}', [RoomController::class, 'destroy'])->name('rooms.destroy');


require __DIR__ . '/auth.php';
