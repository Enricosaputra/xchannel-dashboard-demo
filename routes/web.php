<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\ScheduleSlotController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\StationController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

Route::get('/locale/{locale}', function (string $locale) {
    session(['locale' => $locale]);

    return back();
})->whereIn('locale', SetLocale::LOCALES)->name('locale');

Route::resource('stations', StationController::class);
Route::resource('slots', ScheduleSlotController::class)->except('show');
Route::resource('shows', ShowController::class)->except('show');
Route::resource('hosts', HostController::class)->except('show');

// Light endpoint for health checks.
Route::get('/up', fn () => response('ok'))->name('up');
