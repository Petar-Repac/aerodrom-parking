<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;


Route::get('/blog', [BlogController::class, 'index']);

Route::get('/blog/{id}', [BlogController::class, 'show']);

Route::get('/', [HomeController::class, 'index']);
