<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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

// Route::get('/', function () {
//   return view('home.index', []);
// })->name('home.index');

// Route::get('/contact', function () {
//   return view('home.contact');
// })->name('home.contact');

// Route::view('/', 'home.index')
//   ->name('home.index');
// Route::view('/contact', 'home.contact')
//   ->name('home.contact');

// Route::get('/', ['App\Http\Controllers\HomeController@home']);
Route::get('/', [HomeController::class, 'home'])
  ->name('home.index');

Route::get('/contact', [HomeController::class, 'contact'])
  ->name('home.contact');

Route::get('/about', AboutController::class)
  ->name('home.about');

$posts = [
  1 => [
    'title' => 'Intro to Laravel',
    'content' => 'This is a short intro to Laravel',
    'is_new' => true,
    'has_comments' => true
  ],
  2 => [
    'title' => 'Intro to PHP',
    'content' => 'This is a short intro to PHP',
    'is_new' => false
  ],
  3 => [
    'title' => 'Intro to Golang',
    'content' => 'This is a short intro to Golang',
    'is_new' => false
  ]
];

// Route::resource('posts', PostController::class)->except(['index', 'show']);
// Route::resource('posts', PostController::class)->only(['index', 'show']);
Route::resource('posts', PostController::class);

// Route::get('/posts', function () use ($posts) {
//   // compact($posts) === ['posts' => $posts])
//   dd((int) request()->query('page', 1));
//   // dd((int) request()->input('page', 1));
//   // return request()->all();
//   return view('posts.index', ['posts' => $posts]);

// })->name('posts.index');

// Route::get('/posts/{id}', function ($id) use ($posts) {
//   abort_if(!isset($posts[$id]), 404);

//   return view('posts.show', ['post' => $posts[$id]]);
// })
//   // ->where([
//   //     'id' => '[0-9]+'
//   // ])
//   ->name('posts.show');

Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
  return 'Posts from ' . $daysAgo . ' days ago';
})->name('posts.recent.index')->middleware('auth');


Route::prefix('/fun')->name('fun.')->group(function () use($posts) {

  Route::get('responses', function () use ($posts){
    return response($posts, 201)
      ->header('Content-Type', 'application/json')
      ->cookie('MY_COOKIE', 'Oreo', 60);
  })->name('responses');
  
  Route::get('redirect', function () {
    return redirect('/contact');
  })->name('redirect');
  
  Route::get('back', function () {
    return back();
  })->name('back');
  
  Route::get('named-route', function () {
    return redirect()->route('posts.show', ['id' => 1]);
  })->name('named-route');
  
  Route::get('away', function () {
    return  redirect()->away('https://google.com');
  })->name('away');
  
  Route::get('json', function () use ($posts) {
    return  response()->json($posts);
  })->name('json');
  
  Route::get('download', function () {
    return  response()->download(public_path('/sample.jpg'), 'sample.jpg');
  })->name('download');

});

Auth::routes();
