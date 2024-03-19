<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', \App\Http\Controllers\IndexController::class)->name('index');
// --------
// Authenticated (staff only)
// --------
Route::middleware('staff')->group(function () {
    Route::get('/feedbacks', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::delete('/feedbacks/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'destroy'])->name('feedbacks.destroy');
    Route::patch('feedbacks/{feedback}/restore', [\App\Http\Controllers\FeedbackController::class, 'restore'])->name('feedbacks.restore');
});
