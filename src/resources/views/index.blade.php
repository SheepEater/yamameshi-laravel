<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ヤマメシ - 登山×料理</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/js/app.js')
</head>
<body x-data="{ showTop: false }" @scroll.window="showTop = window.pageYOffset > 200" class="body">
    <!-- ヘッダー -->
    <x-header />
    <div class="top-container">
        <form method="GET" action="{{ route('home') }}" class="search-form mb-6">
            {{-- キーワード --}}
            <div class="col-span-1 sm:col-span-3 lg:col-span-2">
                <input
                type="text"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="キーワード検索"
                class="w-full border rounded p-2"
                >
            </div>

            {{-- 日付From --}}
            <div>
                <input
                type="date"
                name="date_from"
                value="{{ request('date_from') }}"
                class="w-full border rounded p-2"
                >
            </div>

            {{-- 日付To --}}
            <div>
                <input
                type="date"
                name="date_to"
                value="{{ request('date_to') }}"
                class="w-full border rounded p-2"
                >
            </div>

            {{-- 送信ボタン --}}
            <div class="col-span-1 sm:col-span-3 lg:col-span-1">
                <button
                type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold p-2 rounded"
                >絞り込む</button>
            </div>
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
                <strong>{{ request('keyword') }}</strong>」の検索結果：{{ $posts->total() }}件
            </p>
        @endif
        
        <p class="text-lg text-white mt-2">ヤマで食べたご飯をシェアしよう！</p>
        
        <!-- 投稿一覧 -->
        <div class="w-full max-w-4xl post-list-wrapper">
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
        class="scroll-top fixed bottom-8 right-8"
        aria-label="トップに戻る"
    >
        ↑
    </button>
</body>
</html>
