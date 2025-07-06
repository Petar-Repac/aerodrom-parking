<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/o-nama', function () {
    return view('about');
})->name('about');

Route::get('/kontakt', function () {
    return view('contact');
})->name('contact');

Route::post('/kontakt', [ContactController::class, 'send'])->name('contact.send');


Route::get('/cenovnik', function () {
    return view('pricing');
})->name('pricing');

// News
Route::get('/blog', [NewsController::class, 'index'])->name('news');
Route::get('/blog/tag/{tag}', [NewsController::class, 'filterByTag'])->name('news.tag');
Route::get('/blog/{slug}', [NewsController::class, 'single'])->name('news.single');


Route::fallback(function () {
    return response()->view('page-not-found', [], 404);
});
