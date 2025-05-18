<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', \App\Http\Controllers\Admin\DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoriesController::class)->names('categories')->except('show');
    Route::resource('/tags', \App\Http\Controllers\Admin\TagsController::class)->names('tags')->except('show');
    Route::resource('/posts', \App\Http\Controllers\Admin\PostsController::class)->names('posts')->except('show');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
