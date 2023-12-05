<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoreController;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/', [IssueController::class, 'index'])->name('default');
    Route::resource('issues', IssueController::class);
    Route::put('issues/assign-engineer/{id}', [App\Http\Controllers\IssueController::class, 'AssignEngineer'])->name('issues.assign');
    Route::get('/home', [IssueController::class, 'index'])->name('home');
    Route::get('/logs/calendar', [LogsController::class, 'calendarView'])->name('logs.calendar');
    Route::resource('logs', LogsController::class)->except('delete');
    Route::delete('/logs/{id}/delete', [LogsController::class, 'destroy'])->name('logs.delete');

    /// Admin only Routes
    Route::group([
        'prefix' => 'admin',
       // 'middleware' => ['role:admin'],
    ], function () {

        Route::resource('stores', StoreController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('employees', EmployeeController::class);
        Route::put('employees/password/reset/{id}', [App\Http\Controllers\EmployeeController::class, 'resetpass'])->name('employees.reset');

    });
});

Auth::routes();

