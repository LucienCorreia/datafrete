<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/registros', 301);

Route::resource('/registros', App\Http\Controllers\RegistroController::class);

Route::post('/registros/importar', [App\Http\Controllers\RegistroController::class, 'importar'])->name('registros.import');
