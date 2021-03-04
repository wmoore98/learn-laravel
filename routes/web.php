<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use App\Mail\BlogPostAdded;
use App\Mail\CommentPostedMarkdown;
use App\Models\BlogPost;
use App\Models\Comment;
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
Route::resource('users.comments', UserCommentController::class)->only(['store']);

Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

// Route::get('mailable/{comment}', function(Comment $comment) {
//   return new CommentPostedMarkdown($comment);
// });

Route::get('mailable/{blogPost}', function(BlogPost $blogPost) {
  return new BlogPostAdded($blogPost);
});

Auth::routes();

Route::get('/test', function () {
  $posts = BlogPost::take(10)->get();
  foreach($posts as $post) {
    echo $post->user->email;
  }

  // $collection = collect([1, 2, 3, 4, 5]);

$posts->map(function ($item, $key) {
    echo $key;
});

});