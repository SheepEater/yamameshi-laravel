<!-- ヘッダー -->
<header class="w-full flex items-center justify-between px-8 py-2 bg-white bg-opacity-80 shadow-md">
    <!-- 左上：ロゴとメニュー -->
    <div class="flex items-center">
        <a href="{{ route('home') }}" class="inline-block">
            <img src="{{ asset('images/yama-meshi-logo-small.png') }}" alt="ヤマメシ ロゴ" class="w-9 h-9 object-contain">
        </a>
        <nav class="space-x-6">
            <a href="#" class="text-gray-700 font-semibold hover:text-green-600">ヤマメシとは？</a>
            <a href="{{ route('yama-meshi.create') }}" class="text-gray-700 font-semibold hover:text-green-600">投稿する</a>
        </nav>
    </div>

    <!-- 右上：ユーザーメニュー -->
    <div class="relative" x-data="{ open: false }">
        @auth
            <button @click="open = !open" class="focus:outline-none">
                <img src="{{ asset('images/default-icon.png') }}" alt="ユーザーアイコン" class="h-9 w-9 rounded-full">
            </button>

            <!-- ドロップダウンメニュー -->
            <div
                x-show="open"
                @click.away="open = false"
                class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <a href="{{ route('mypage') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap">
                    マイページ
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 whitespace-nowrap">
                        ログアウト
                    </button>
                </form>
            </div>
        @else
            <div class="flex space-x-2">
                <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-1 px-3 rounded-lg">
                    新規登録
                </a>
                <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-3 rounded-lg">
                    ログイン
                </a>
            </div>
        @endauth
    </div>
</header>
