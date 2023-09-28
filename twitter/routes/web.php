<?php

use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Route as RoutingRoute;

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
    Route::prefix('user/{id}')->group(function () {
        // ユーザー詳細画面の表示
        Route::get('/', [UserController::class, 'findByUserId'])->name('user.show');
        // ユーザー編集画面の表示
        Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
        // ユーザー情報更新
        Route::put('/update', [UserController::class, 'update'])->name('user.update');
        // ユーザー削除
        Route::delete('/', [UserController::class, 'delete'])->name('user.delete');
    });

    Route::prefix('users')->group(function () {
        // ユーザー一覧
        Route::get('/', [UserController::class, 'getAllUsers'])->name('user.index');
        // フォロー
        Route::post('/follow/{id}', [UserController::class, 'follow'])->name('user.follow');
        // フォロー解除
        Route::post('/unfollow/{id}', [UserController::class, 'unfollow'])->name('user.unfollow');
        // フォロー一覧
        Route::get('/followed', [UserController::class, 'showFollowedUsers'])->name('user.followed');
        // フォロワー一覧
        Route::get('/follower', [UserController::class, 'showFollowerUsers'])->name('user.follower');
    });


    // ツイート
    Route::prefix('tweet')->group(function () {
        // ツイート画面の表示
        Route::get('/create', [TweetController::class, 'create'])->name('tweet.create');
        // ツイート保存
        Route::post('/store', [TweetController::class, 'store'])->name('tweet.store');
        // ツイート詳細画面の表示
        Route::get('/{id}', [TweetController::class, 'findByTweetId'])->name('tweet.show');
        //　ツイート編集画面の表示
        Route::get('/{id}/edit', [TweetController::class, 'edit'])->name('tweet.edit');
        // ツイート内容更新
        Route::put('/{id}/update', [TweetController::class, 'update'])->name('tweet.update');
        // ツイート削除
        Route::delete('/{id}/delete', [TweetController::class, 'delete'])->name('tweet.delete');
    });
});

// ツイート一覧
Route::get('/tweets', [TweetController::class, 'getAllTweets'])->name('tweet.index');
