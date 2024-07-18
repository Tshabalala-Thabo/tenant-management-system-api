<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\RoomController;
use Spatie\Permission\Middlewares\RoleMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;

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
    return view('auth.login');
});

// Route for viewing sites
Route::middleware(['auth'])->group(function () {
    Route::get('/sites', [SiteController::class, 'index'])->name('sites.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
// In web.php
Route::get('/rooms/{siteId}', [RoomController::class, 'getRoomsBySite'])->name('rooms.bySite');
Route::put('/rooms/{room}', [RoomController::class, 'update']);

// web.php
Route::get('/tenants', [UserController::class, 'getTenantsByLandlord'])->name('tenants.index');
Route::get('/tenants/profile/{id}', [UserController::class, 'show'])->name('tenants.show');

// Please implement this approach across all controllers and routes
Route::resource('tickets', TicketController::class);
/*This setup will create a RESTful API for managing tickets with endpoints like:

    GET /tickets - List all tickets
    POST /tickets - Create a new ticket
    GET /tickets/{ticket} - Show a specific ticket
    PUT /tickets/{ticket} - Update a specific ticket
    DELETE /tickets/{ticket} - Delete a specific ticket
*/
    
require __DIR__ . '/auth.php';
