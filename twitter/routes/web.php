<?php

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

# マイページ
Route::prefix('user/{id}')->group(function() {
    // ユーザー詳細画面の表示
    Route::get('/', [UserController::class, 'findByUserId'])->name('user.show');
    // ユーザー編集画面の表示
    Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
    // ユーザー情報更新
    Route::put('/update', [UserController::class, 'update'])->name('user.update');
    // ユーザー削除
    Route::delete('/',[UserController::class, 'delete'])->name('user.delete');
});// ユーザー一覧Route::get('/users', [UserController::class, 'getAll'])->name('user.index');