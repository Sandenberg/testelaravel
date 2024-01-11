<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload-form', [ContactController::class, 'showForm'])->name('upload.form');
Route::post('/upload', [ContactController::class, 'upload']);
Route::post('/schedule-mass-notification', [ContactController::class, 'scheduleMassNotification']);
Route::get('/cancel-schedule/{id}', [ContactController::class, 'cancelSchedule'])->name('cancel.schedule');
Route::get('/edit-schedule/{id}', [ContactController::class, 'editSchedule']);
