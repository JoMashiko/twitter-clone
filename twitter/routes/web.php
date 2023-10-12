<?php

use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReplyController;
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
    Route::group(['prefix' => 'user/{id}', 'as' => 'user.'], function () {
        // ユーザー詳細画面の表示
        Route::get('/', [UserController::class, 'showUserInfo'])->name('show');
        // ユーザー編集画面の表示
        Route::get('/edit', [UserController::class, 'edit'])->name('edit');
        // ユーザー情報更新
        Route::put('/update', [UserController::class, 'update'])->name('update');
        // ユーザー削除
        Route::delete('/', [UserController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
        // ユーザー一覧
        Route::get('/', [UserController::class, 'getAllUsers'])->name('index');
        // フォロー
        Route::post('/follow/{id}', [UserController::class, 'follow'])->name('follow');
        // フォロー解除
        Route::post('/unfollow/{id}', [UserController::class, 'unfollow'])->name('unfollow');
        // フォロー一覧
        Route::get('/followed', [UserController::class, 'showFollowedUsers'])->name('followed');
        // フォロワー一覧
        Route::get('/follower', [UserController::class, 'showFollowerUsers'])->name('follower');
    });


    // ツイート
    Route::group(['prefix' => 'tweet', 'as' => 'tweet.'], function () {
        // ツイート画面の表示
        Route::get('/create', [TweetController::class, 'create'])->name('create');
        // ツイート保存
        Route::post('/store', [TweetController::class, 'store'])->name('store');
        // ツイート詳細画面の表示
        Route::get('/{id}', [TweetController::class, 'findByTweetId'])->name('show');
        //　ツイート編集画面の表示
        Route::get('/{id}/edit', [TweetController::class, 'edit'])->name('edit');
        // ツイート内容更新
        Route::put('/{id}/update', [TweetController::class, 'update'])->name('update');
        // ツイート削除
        Route::delete('/{id}/delete', [TweetController::class, 'delete'])->name('delete');
        //　いいね
        Route::post('/favorite', [FavoriteController::class, 'favorite'])->name('favorite');
        // いいね解除
        Route::post('/unfavorite', [FavoriteController::class, 'unfavorite'])->name('unfavorite');
    });

    // リプライ
    Route::group(['prefix' => 'tweet', 'as' => 'reply.'], function () {
        // リプライ保存
        Route::post('/{id}/store', [ReplyController::class, 'store'])->name('store');
        // リプライ更新
        Route::post('/{id}/updateReply', [ReplyController::class, 'update'])->name('update');
        // リプライ削除
        Route::delete('/{id}/deleteReply', [ReplyController::class, 'delete'])->name('delete');
    });

    // ツイート一覧
    Route::get('/tweets', [TweetController::class, 'getAllTweets'])->name('tweet.index');
});
