<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index']);


Route::get('/about-us', function () {
    return view('about');
});
Route::get('/contact', function () {
    return view('contact');
});
Route::get('/pricing', function () {
    return view('pricing');
});

// News
Route::get('/blog', [NewsController::class, 'index'])->name('news');
Route::get('/blog/tag/{tag}', [NewsController::class, 'filterByTag'])->name('news.tag');
Route::get('/blog/{slug}', [NewsController::class, 'single'])->name('news.single');


Route::fallback(function () {
    return response()->view('page-not-found.blade.php', [], 404);
});
