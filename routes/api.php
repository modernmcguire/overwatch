<?php

use Illuminate\Support\Facades\Route;
use Modernmcguire\Overwatch\Overwatch;

Route::post('/overwatch', [Overwatch::class, 'index'])->name('overwatch');
