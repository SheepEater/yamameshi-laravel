<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ヤマメシ - 登山×料理</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/home.css'])
</head>
<body class="min-h-screen bg-cover bg-center">

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
        <h1 class="page-title">ヤマメシ</h1>
        <p class="text-lg text-white mt-2">ヤマで食べたご飯をシェアしよう！</p>

        <!-- 投稿一覧 -->
        <div class="w-full max-w-4xl bg-white bg-opacity-90 shadow-lg rounded-lg mt-8 p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">投稿一覧</h2>

            <div id="post-list">
                @if($posts->isEmpty())
                    <p class="text-gray-600">投稿はまだありません。</p>
                @else
                    @foreach($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach

                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>

</body>
</html>
