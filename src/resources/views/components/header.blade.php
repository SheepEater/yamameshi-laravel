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
            <a href="{{ route('mypage') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg">
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
