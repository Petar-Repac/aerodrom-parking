<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/news', [NewsController::class, 'index']);

Route::get('/news/{id}', [NewsController::class, 'show']);
