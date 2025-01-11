<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\LeaseAgreementController;
use Spatie\Permission\Middlewares\RoleMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SiteServiceProviderController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AccommodationController;
use Illuminate\Http\Request;


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

// Service provider assignment
Route::post('/sites/{siteId}/assign', [SiteServiceProviderController::class, 'assign'])
    ->name('sites.assign');
Route::get('/service-providers', [SiteServiceProviderController::class, 'search']);

Route::post('/sites/{siteId}/unassign', [SiteServiceProviderController::class, 'unassign'])
    ->name('sites.unassign');

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
Route::resource('/lease-agreements', LeaseAgreementController::class);
Route::resource('/invoices', InvoiceController::class);
Route::resource('/tickets', TicketController::class);
// In routes/web.php or routes/api.php

/*This setup will create a RESTful API for managing tickets with endpoints like:

    GET /tickets - List all tickets
    POST /tickets - Create a new ticket
    GET /tickets/{ticket} - Show a specific ticket
    PUT /tickets/{ticket} - Update a specific ticket
    DELETE /tickets/{ticket} - Delete a specific ticket
*/

Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'printInvoice'])->name('invoices.print');

Route::get('/accommodations', [AccommodationController::class, 'index'])->name('accommodations.index');


Route::get('/applications', [ApplicationController::class, 'index'])->middleware('role:landlord');
Route::post('/applications/{applicationId}/update', [ApplicationController::class, 'update']);



Route::get('/lease-agreements/{id}/print', [LeaseAgreementController::class, 'print'])
    ->name('lease-agreements.print');

Route::post('/applications/{siteId}', [ApplicationController::class, 'applyForAccommodation'])->name('applications.apply');

require __DIR__ . '/auth.php';
