<?php

use Illuminate\Support\Facades\Route;
use Modernmcguire\Overwatch\Overwatch;

// todo: security
Route::get('/overwatch', [Overwatch::class, 'index'])->name('overwatch');
