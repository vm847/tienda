<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/hola', function () {
    return '¡Hola desde Docker!';
});

Route::get('/productos', [ProductoController::class, 'index']);
