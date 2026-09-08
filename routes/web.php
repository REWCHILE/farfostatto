<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RequestsController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - FARFO'S TATTOO
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portafolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/sobre-mi', [AboutController::class, 'index'])->name('about');
Route::get('/contacto', [ContactController::class, 'index'])->name('contact');

// Booking routes
Route::get('/reserva', [BookingController::class, 'index'])->name('booking');
Route::post('/reserva', [BookingController::class, 'store'])->name('booking.store');
Route::get('/reserva/confirmacion', [BookingController::class, 'success'])->name('booking.success');

// API Calendar endpoint
Route::get('/api/calendar/reserved-days', [BookingController::class, 'apiReservedDays'])->name('api.reserved-days');

// Admin Authentication
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Requests
    Route::get('/requests', [RequestsController::class, 'index'])->name('requests');
    Route::post('/requests/{id}/approve', [RequestsController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{id}/reject', [RequestsController::class, 'reject'])->name('requests.reject');

    // Agenda
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
    Route::post('/agenda/confirm-deposit/{id}', [AgendaController::class, 'confirmDeposit'])->name('agenda.confirm-deposit');
    Route::post('/agenda/release/{id}', [AgendaController::class, 'release'])->name('agenda.release');
    Route::post('/agenda/create-block', [AgendaController::class, 'createBlock'])->name('agenda.create-block');

    // Placeholders for remaining sidebar routes
    Route::get('/clients', function () {
        return redirect()->route('admin.requests')->with('info', 'Módulo de clientes integrado en Solicitudes.');
    })->name('clients');

    Route::get('/portfolio', function () {
        return redirect()->route('portfolio');
    })->name('portfolio');

    Route::get('/settings', function () {
        return redirect()->route('admin.dashboard')->with('info', 'Ajustes del sistema configurados en .env y base de datos.');
    })->name('settings');
});
