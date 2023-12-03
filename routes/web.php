<?php

use App\Http\Controllers\IssueController;
use App\Http\Controllers\LogsController;
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
    Route::get('/',[LogsController::class, 'index'])->name('default');
    Route::resource('issues', IssueController::class);
    Route::get('/home', [LogsController::class, 'index'])->name('home');
    Route::get('/logs/calendar', [LogsController::class, 'calendarView'])->name('logs.calendar');
    Route::resource('logs', LogsController::class)->except('delete');
    Route::delete('/logs/{id}/delete', [LogsController::class, 'destroy'])->name('logs.delete');
});

Auth::routes();

