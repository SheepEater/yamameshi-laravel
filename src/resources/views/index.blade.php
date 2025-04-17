<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ヤマメシ - 登山×料理</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen bg-cover bg-center" style="background-image: url('images/yamaimage.png');">

    <!-- ヘッダー -->
    <x-header />

    <!-- メインコンテンツ -->
    <main class="flex flex-col items-center justify-center min-h-screen pt-20">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <!-- タイトル -->
        <h1 class="text-6xl font-bold text-white drop-shadow-lg">ヤマメシ</h1>
        <p class="text-lg text-white mt-2">ヤマで食べたご飯をシェアしよう！</p>

        <!-- 投稿一覧 -->
        <div class="w-full max-w-4xl bg-white bg-opacity-90 shadow-lg rounded-lg mt-8 p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">投稿一覧</h2>

            <div id="post-list">
                @if($posts->isEmpty())
                    <p class="text-gray-600">投稿はまだありません。</p>
                @else
                    @foreach($posts as $post)
                        <div class="bg-white shadow-md rounded-lg p-4 mb-6 space-y-3">
                            <!-- ユーザー情報 -->
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('images/default-icon.png') }}" class="w-10 h-10 rounded-full" alt="ユーザーアイコン">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                                    @if($post->user->gender || $post->user->age)
                                        <p class="text-sm text-gray-600">
                                            @if($post->user->gender) 性別: {{ $post->user->gender }} @endif
                                            @if($post->user->age) / 年齢: {{ $post->user->age }}歳 @endif
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- 投稿データ -->
                            <p class="text-sm text-gray-500">日付: {{ $post->date ?? '未入力' }}</p>
                            <p class="text-gray-700">場所: {{ $post->place ?? '未入力' }}</p>
                            <p class="text-gray-700">食べたもの: {{ $post->food ?? '未入力' }}</p>
                            <p class="text-gray-700">備考: {{ $post->content ?? '未入力' }}</p>

                            <!-- タイトル表示　 -->
                            <h3 class="text-xl font-bold text-gray-800">{{ $post->title }}</h3>

                            <!-- 画像表示 -->
                            @if($post->image_paths)
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach(json_decode($post->image_paths, true) as $img)
                                        <img src="{{ asset('storage/' . $img) }}" class="w-40 h-40 object-cover rounded-md">
                                    @endforeach
                                </div>
                            @endif

                            <!-- アクションボタン -->
                            <div class="flex items-center justify-between mt-4">
                                <!-- いいね -->
                                <form method="POST" action="{{ route('posts.toggleLike', $post->id) }}">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-1">
                                        @auth
                                            @if($post->isLikedBy(auth()->user()))
                                                <span class="text-pink-500">❤️</span>
                                            @else
                                                <span class="text-gray-400">🤍</span>
                                            @endif
                                        @endauth
                                        <span class="text-sm text-gray-600">{{ $post->likes_count }}</span>
                                    </button>
                                </form>

                                <!-- メッセージ -->
                                <!-- Alpine.js を使ったメッセージ送信モーダル -->
                                <div x-data="{ open: false }" class="inline-block">
                                    <!-- 💬 ボタン -->
                                    <button @click="open = true"
                                        class="text-blue-500 hover:underline">
                                        💬 メッセージを送る
                                    </button>

                                    <!-- モーダル本体 -->
                                    <div
                                        x-show="open"
                                        x-transition
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                    >
                                        <div @click.away="open = false" class="bg-white w-full max-w-md p-6 rounded shadow-lg relative">
                                            <!-- 閉じる -->
                                            <button @click="open = false"
                                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

                                            <h2 class="text-xl font-semibold mb-4">{{ $post->user->name }} さんにメッセージを送る</h2>

                                            <form method="POST" action="{{ route('messages.send') }}">
                                                @csrf
                                                <input type="hidden" name="to_user_id" value="{{ $post->user->id }}">
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">

                                                <textarea name="message" rows="4" class="w-full border p-2 rounded" placeholder="メッセージを入力..."></textarea>

                                                <div class="mt-4 text-right">
                                                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                                        送信
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- メッセージ一覧 -->
                            @if($post->messages && $post->messages->isNotEmpty())
                                <div class="mt-4 bg-gray-50 p-3 rounded border border-gray-200">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">この投稿へのメッセージ</h4>
                                    <ul class="space-y-2">
                                        @foreach($post->messages as $msg)
                                            <li class="text-sm text-gray-800">
                                                <span class="font-bold">{{ $msg->sender->name }}</span>：
                                                {{ $msg->content }}
                                                <span class="text-xs text-gray-500 ml-2">{{ $msg->created_at->format('Y/m/d H:i') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>

</body>
</html>
