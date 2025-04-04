<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YamaMeshiController;
use App\Http\Controllers\UserController;
use App\Models\YamaMeshiPost;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $posts = YamaMeshiPost::orderBy('created_at', 'desc')->get(); // 投稿を取得
    return view('index', compact('posts')); // `index.blade.php` に `$posts` を渡す
});

// **1️⃣ 投稿関連**
Route::middleware(['auth'])->group(function () {
    Route::get('/yama-meshi', [YamaMeshiController::class, 'index'])->name('yama-meshi.index'); // 投稿一覧
    Route::get('/yama-meshi/create', [YamaMeshiController::class, 'create'])->name('yama-meshi.create'); // 投稿作成
    Route::post('/yama-meshi', [YamaMeshiController::class, 'store'])->name('yama-meshi.store'); // 投稿保存
    Route::get('mypage', [UserController::class, 'mypage'])->name('mypage');
});

// ....
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
