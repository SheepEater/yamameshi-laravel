<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ヤマメシ - 登山×料理</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/home.css', 'resources/css/components/post-card.css'
    ,'resources/css/components/header.css'])
</head>
<body x-data="{ showTop: false }" @scroll.window="showTop = window.pageYOffset > 200" class="body">
    <!-- ヘッダー -->
    <x-header />
    <div class="top-container">
        <form action="{{ route('posts.search') }}" method="GET" class="search-form">
            <input type="text" name="keyword" placeholder="投稿を検索する..." value="{{ request('keyword') }}" />
            <button type="submit">検索</button>
        </form>
    </div>

    <!-- メインコンテンツ -->
    <main class="flex flex-col items-center justify-center min-h-screen pt-20">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(request('keyword'))
            <p class="mb-4 text-gray-600">
                「<strong>{{ request('keyword') }}</strong>」の検索結果：{{ $posts->total() }}件
            </p>
        @endif
        <!-- <h1 class="page-title">ヤマメシ</h1>たいとる -->
        <p class="text-lg text-white mt-2">ヤマで食べたご飯をシェアしよう！</p>
        
        <!-- 投稿一覧 -->
         <!-- bg-white →bg-noneにした -->
        <div class="w-full max-w-4xl bg-none bg-opacity-90 shadow-lg rounded-lg mt-8 p-6">
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
    {{-- トップに戻るボタン --}}
    <button
        x-show="showTop"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-8 right-8 bg-[#00244A] text-white p-3 rounded-full shadow-lg transition-opacity duration-300"
        style="display: none;"
        aria-label="トップに戻る"
    >
        ↑
    </button>
</body>
</html>
