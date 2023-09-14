<?php

use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 認証済み
Route::group(['middleware' => 'auth'], function () {

    // マイページ
    Route::prefix('user/{id}')->group(function() {
        // ユーザー詳細画面の表示
        Route::get('/', [UserController::class, 'findByUserId'])->name('user.show');
        // ユーザー編集画面の表示
        Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
        // ユーザー情報更新
        Route::put('/update', [UserController::class, 'update'])->name('user.update');
        // ユーザー削除
        Route::delete('/', [UserController::class, 'delete'])->name('user.delete');
    });

    // ユーザー一覧
    Route::get('/users', [UserController::class, 'getAllUsers'])->name('user.index');

    // ツイート
    Route::prefix('tweet')->group(function() {
        // ツイート画面の表示
        Route::get('/create', [TweetController:: class, 'create'])->name('tweet.create');
        // ツイート保存
        Route::post('/store', [TweetController:: class, 'store'])->name('tweet.store');
        // ツイート詳細画面の表示
        Route::get('/{id}', [TweetController:: class, 'findByTweetId'])->name('tweet.show');
    });
});

// ツイート一覧
Route::get('/tweets', [TweetController:: class, 'getAllTweets'])->name('tweet.index');