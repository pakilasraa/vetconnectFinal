<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //route for user managament
    Route::get(uri: '/users/index', action: [ProfileController::class, 'getAllUsers'])->name(name: 'users.index');
    Route::get(uri: '/users/create', action: [ProfileController::class, 'create'])->name(name: 'users.create');
    Route::post(uri: '/users/store', action: [ProfileController::class, 'store'])->name(name: 'users.store');

    //route for user management edit, update, delete
    Route::get(uri: '/users/{id}/edit', action: [ProfileController::class, 'editUser'])->name(name: 'users.edit');
    Route::put(uri: '/users/{id}', action: [ProfileController::class, 'updateUser'])->name(name: 'users.update');
    Route::delete(uri: '/users/{id}', action: [ProfileController::class, 'destroyUser'])->name(name: 'users.destroy');


    // Pet Management
    Route::resource('pets', \App\Http\Controllers\PetController::class);

    // Appointment Management
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);

    // Medical Records
    Route::resource('medical-records', \App\Http\Controllers\MedicalRecordController::class);

    // Vaccination Records
    Route::resource('vaccination-records', \App\Http\Controllers\VaccinationRecordController::class);

    // Activity Logs
    Route::get('activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');

    // Global Search
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
});

require __DIR__ . '/auth.php';
