<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UnauthorizedController;
use App\Http\Controllers\VaccinationRecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/not-authorized', UnauthorizedController::class)
    ->middleware('auth')
    ->name('not-authorized');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        $verified = $request->query('verified');
        $query = $verified !== null ? ['verified' => $verified] : [];

        if ($user->isPetOwner()) {
            return redirect()->route('client.dashboard', $query);
        }
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard', $query);
        }

        return redirect()->route('not-authorized');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    Route::get('/users/index', [ProfileController::class, 'getAllUsers'])->name('users.index');
    Route::get('/users/create', [ProfileController::class, 'create'])->name('users.create');
    Route::post('/users/store', [ProfileController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [ProfileController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [ProfileController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [ProfileController::class, 'destroyUser'])->name('users.destroy');

    Route::resource('pets', PetController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('medical-records', MedicalRecordController::class);
    Route::resource('vaccination-records', VaccinationRecordController::class);

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
});

Route::middleware(['auth', 'verified', 'role:pet_owner'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

    Route::resource('pets', PetController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::resource('medical-records', MedicalRecordController::class)->only(['index']);
    Route::resource('vaccination-records', VaccinationRecordController::class)->only(['index']);
});

require __DIR__.'/auth.php';
