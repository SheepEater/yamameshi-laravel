<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ヤマメシ - 登山×料理</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen bg-cover bg-center" style="background-image: url('images/yamaimage.png');">

    <!-- ヘッダー -->
    <header class="w-full flex items-center justify-between px-8 py-4 bg-white bg-opacity-80 shadow-md fixed top-0 left-0 right-0">
        <!-- 左上：ロゴとメニュー -->
        <div class="flex items-center">
            <img src="{{ asset('images/yama-meshi-logo.png') }}" alt="ヤマメシ ロゴ" class="h-10 w-10 mr-3">
            <nav class="space-x-6">
                <a href="#" class="text-gray-700 font-semibold hover:text-green-600">ヤマメシとは？</a>
                <a href="{{ route('yama-meshi.create') }}" class="text-gray-700 font-semibold hover:text-green-600">投稿する</a>
            </nav>
        </div>

        <!-- 右上：認証ボタン -->
        <div class="flex space-x-4">
            @auth
                <a href="{{ route('yama-meshi.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg">
                    マイページ
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">
                        ログアウト
                    </button>
                </form>
            @else
                <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg">
                    新規登録
                </a>
                <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">
                    ログイン
                </a>
            @endauth
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex flex-col items-center justify-center min-h-screen pt-20">
        <!-- タイトル -->
        <h1 class="text-6xl font-bold text-white drop-shadow-lg">ヤマメシ</h1>
        <p class="text-lg text-white mt-2">登山の楽しみをシェアしよう！</p>

        <!-- 投稿一覧 -->
        <div class="w-full max-w-4xl bg-white bg-opacity-90 shadow-lg rounded-lg mt-8 p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">投稿一覧</h2>
            <div id="post-list">
                <!-- 投稿データは後ほど追加 -->
                <p class="text-gray-600">投稿はまだありません。</p>
            </div>
        </div>
    </main>

</body>
</html>
