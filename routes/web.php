<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, 'home'])
  ->name('home.index');

Route::get('/contact', [HomeController::class, 'contact'])
  ->name('home.contact');

Route::get('/secret', [HomeController::class, 'secret'])
  ->name('home.secret')
  ->middleware('can:home.secret');

Route::get('/about', AboutController::class)
  ->name('home.about');

Route::resource('posts', PostController::class);

Route::get('/posts/tag/{id}', [PostTagController::class, 'index'])
  ->name('posts.tags.index');

Route::resource('posts.comments', PostCommentController::class)->only(['store']);

Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

Auth::routes();
