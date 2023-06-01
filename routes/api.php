<?php

use Illuminate\Support\Facades\Route;
use Modernmcguire\Overwatch\Http\Controllers\OverwatchController;
use Modernmcguire\Overwatch\Http\Controllers\OverwatchHorizonStatsController;
use Modernmcguire\Overwatch\Http\Controllers\OverwatchHorizonStatusController;

Route::post('/overwatch', OverwatchController::class)->name('overwatch');
Route::post('/overwatch/horizon/stats', OverwatchHorizonStatsController::class)->name('overwatch.horizon.stats');
Route::post('/overwatch/horizon/status', OverwatchHorizonStatusController::class)->name('overwatch.horizon.status');
