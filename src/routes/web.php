<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\YamaMeshiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
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

// Route::get('/', function () {
//     $posts = YamaMeshiPost::with(['user', 'likes', 'messages'])->withCount('likes')->latest()->paginate(10);
//     return view('index', compact('posts')); // `index.blade.php` に `$posts` を渡す
// })->name('home');



Route::get('/', [YamaMeshiController::class, 'search'])
    ->name('home');

Route::get('/about', function () {
    return view('about'); // about.blade.php ビューを返す
})->name('about'); // 任意の名前をつけておく（ここでは 'about'）



// 認証が必要なルート
Route::middleware(['auth'])->group(function () {
    // 投稿関連
    Route::get('/yama-meshi', [YamaMeshiController::class, 'index'])->name('yama-meshi.index'); // 投稿一覧
    Route::get('/yama-meshi/create', [YamaMeshiController::class, 'create'])->name('yama-meshi.create'); // 投稿作成
    Route::post('/yama-meshi', [YamaMeshiController::class, 'store'])->name('yama-meshi.store'); // 投稿保存

    // マイページ
    Route::get('mypage', [UserController::class, 'mypage'])->name('mypage');


    // 編集画面を表示
    Route::get('/yama-meshi/{post}/edit', [YamaMeshiController::class, 'edit'])
    ->name('yama-meshi.edit');
    // 更新処理
    Route::put('/yama-meshi/{post}', [YamaMeshiController::class, 'update'])
    ->name('yama-meshi.update');
    // 削除処理
    Route::delete('/yama-meshi/{post}', [YamaMeshiController::class, 'destroy'])
    ->name('yama-meshi.destroy');


    // プロフィール編集
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // いいね機能
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.toggleLike');

    // メッセージ送信
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
});

// 詳細ページのルート
Route::get('/yama-meshi/{post}', [YamaMeshiController::class, 'show'])
    ->name('yama-meshi.show');

require __DIR__.'/auth.php';
