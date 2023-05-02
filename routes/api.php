<?php

use Illuminate\Support\Facades\Route;
use Modernmcguire\Overwatch\Http\Controllers\OverwatchController;

Route::post('/overwatch', OverwatchController::class)->name('overwatch');
