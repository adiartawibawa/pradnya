<?php

use App\Http\Livewire\Post\View;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Post
    Route::prefix('post')->group(function () {
        Route::view('/', 'blogs.post.all-post')->name('post');
        Route::view('/create', 'blogs.post.create-post')->name('post.create');
        Route::get('/view/{slug}', View::class)->name('post.view');
    });
});
