<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

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

// ホームページにアクセスしたらログインページにリダイレクト
Route::get('/', function () {
    return redirect('/login');
});

// 認証ルート
Auth::routes();

// 認証済みユーザー向けのルートグループ
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // ダッシュボードページルート
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    // ホームページルート
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // 投稿一覧ページルート
    Route::get('/index', [PostController::class, 'index'])->name('index');
    // 投稿作成フォームページルート
    Route::get('/create-form', [PostController::class, 'createForm']);
    // 投稿作成処理ルート
    Route::post('/post/create', [PostController::class, 'create']);
    // 投稿更新フォームページルート
    Route::get('post/{id}/update-form', [PostController::class, 'updateForm']);
    // 投稿更新処理ルート
    Route::post('/post/update', [PostController::class, 'update']);
    // 投稿削除処理ルート
    Route::get('/post/delete/{id}', [PostController::class, 'delete']);
    // 投稿検索処理ルート
    Route::post('/search', [PostController::class, 'search'])->name('search');
});

// ログアウトルート
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
