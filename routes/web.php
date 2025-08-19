<?php


use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Doctors\DoctorController;

use App\Http\Controllers\PatientController;
use App\Http\Controllers\CheckupController;

use App\Http\Controllers\DashboardController;


use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreatmentSessionController;
use App\Http\Controllers\SessionInstallmentController;
use App\Http\Controllers\GeneralSettingController;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionDetailController;

use App\Http\Controllers\PaymentOutstandingController;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeSalaryController;

use App\Http\Controllers\SessionTimeController;


Auth::routes();


Route::post('/sessions/{id}/complete', [SessionTimeController::class, 'markCompleted'])->name('sessions.complete');
Route::delete('/sessions/{id}', [SessionTimeController::class, 'destroy'])->name('sessions.destroy');


// Employees
Route::get('employees', [EmployeeController::class, 'index']);
Route::get('employees/create', [EmployeeController::class, 'create']);
Route::post('employees', [EmployeeController::class, 'store']);

// Salaries
Route::get('salaries', [EmployeeSalaryController::class, 'index']);
Route::get('salaries/create', [EmployeeSalaryController::class, 'create']);
Route::post('salaries', [EmployeeSalaryController::class, 'store']);


Route::post('/salaries/{id}/pay', [EmployeeSalaryController::class, 'markAsPaid'])->name('salaries.pay');
// For modal-based salary mark as paid with adjustments
Route::post('/salaries/mark-paid', [EmployeeSalaryController::class, 'markPaidWithAdjustment'])->name('salaries.markPaid');







Route::get('/dashboard', [DashboardController::class, 'index'])
    // ->middleware(['auth']) // Remove if not using auth
     ->name('dashboard');

Route::get('/payments/outstandings', [\App\Http\Controllers\PaymentOutstandingController::class, 'index']);


// Show form to add a new session datetime (for ➕ icon)
Route::get('/treatment-sessions/{session_id}/add-entry', [TreatmentSessionController::class, 'addEntryForm'])->name('treatment-sessions.add-entry');

// Handle form POST to store new session datetime
Route::post('/treatment-sessions/{session_id}/store-entry', [TreatmentSessionController::class, 'storeEntry'])->name('treatment-sessions.store-entry');


Route::get('/session-details/create/{session}', [SessionDetailController::class, 'create'])->name('session-details.create');
Route::get('/sessions', [SessionController::class, 'index'])->name('sessions.index');


Route::get('/settings/general', [GeneralSettingController::class, 'index'])->name('settings.index');
Route::post('/settings/general', [GeneralSettingController::class, 'update'])->name('settings.update');


Route::get('/checkups/print/{id}', [CheckupController::class, 'printSlip'])->name('checkups.print');

Route::get('general-settings', [GeneralSettingController::class, 'index'])->name('general-settings.index');
Route::get('general-settings/{id}/edit', [GeneralSettingController::class, 'edit'])->name('general-settings.edit');
Route::put('general-settings/{id}/update', [GeneralSettingController::class, 'update'])->name('general-settings.update');


Route::get('/installments/create/{session_id}', [SessionInstallmentController::class, 'create'])->name('installments.create');
Route::post('/installments/store', [SessionInstallmentController::class, 'store'])->name('installments.store');


Route::get('/treatment-sessions', [TreatmentSessionController::class, 'index'])->name('treatment-sessions.index');
Route::get('/treatment-sessions/create', [TreatmentSessionController::class, 'create'])->name('treatment-sessions.create');
Route::post('/treatment-sessions', [TreatmentSessionController::class, 'store'])->name('treatment-sessions.store');

// Mark session complete (manual doctor name)
Route::post('/sessions/{id}/complete', [TreatmentSessionController::class, 'markCompleted'])->name('sessions.complete');

Route::get('/treatment-sessions/{id}/edit', [TreatmentSessionController::class, 'edit'])->name('treatment-sessions.edit');
Route::put('/treatment-sessions/{id}', [TreatmentSessionController::class, 'update'])->name('treatment-sessions.update');
Route::delete('/treatment-sessions/{id}', [TreatmentSessionController::class, 'destroy'])->name('treatment-sessions.destroy');
Route::get('/treatment-sessions/{id}', [TreatmentSessionController::class, 'show'])->name('treatment-sessions.show');




Route::get('/checkups', [CheckupController::class, 'index'])->name('checkups.index');
Route::get('/checkups/create', [CheckupController::class, 'create']);
// Checkup ID ke sath session create karne ka route
Route::get('/treatment-sessions/create/{checkup}', [TreatmentSessionController::class, 'createWithCheckup'])
    ->name('treatment-sessions.createWithCheckup');


Route::post('/checkups', [CheckupController::class, 'store']);
Route::get('/checkups/{id}/edit', [CheckupController::class, 'edit']);
Route::put('/checkups/{id}', [CheckupController::class, 'update']);
Route::delete('/checkups/{id}', [CheckupController::class, 'destroy']);
Route::get('/checkups/{id}', [CheckupController::class, 'show']);



Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
Route::post('/doctors/store', [DoctorController::class, 'store'])->name('doctors.store');
Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('doctors.update');
Route::get('/doctors/{id}/availability', [DoctorController::class, 'availability'])->name('doctors.availability');
Route::get('/doctors/{id}/performance', [DoctorController::class, 'performance'])->name('doctors.performance');



Route::get('/patients', [PatientController::class, 'index']);
Route::get('/patients/create', [PatientController::class, 'create']);
Route::post('/patients', [PatientController::class, 'store']);
Route::get('/patients/{id}/edit', [PatientController::class, 'edit']);
Route::put('/patients/{id}', [PatientController::class, 'update']);
Route::get('/patients/{id}', [PatientController::class, 'show']);
Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('{any}', [HomeController::class, 'root'])->where('any', '.*');


