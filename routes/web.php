<?php

use App\Http\Controllers\TweetsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FavoritesController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

// ログイン状態
Route::group(['middleware' => 'auth'], function () {

    // ユーザ関連
    Route::resource('users', UsersController::class, ['only' => ['index', 'show', 'edit', 'update']]);

    // フォロー/フォロー解除を追加
    Route::post('users/{user}/follow', [UsersController::class, 'follow'])->name('follow');
    Route::delete('users/{user}/unfollow', [UsersController::class, 'unfollow'])->name('unfollow');

    // ツイート関連
    Route::resource('tweets', TweetsController::class, ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);

    // コメント関連
    Route::resource('comments', CommentsController::class, ['only' => ['store']]);

    // いいね関連
    Route::resource('favorites', FavoritesController::class, ['only' => ['store', 'destroy']]);

    Route::post('/like', [FavoritesController::class, 'like'])->name('like');
});
