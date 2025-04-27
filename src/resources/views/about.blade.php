<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ヤマメシ - とは</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gray-100">

    <!-- ヘッダー -->
    <header class="w-full bg-orange-400 text-white py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/yama-meshi-logo-small.png') }}" alt="ヤマメシ ロゴ" class="w-12 h-12">
                <h1 class="ml-3 text-2xl font-bold">YAMA-MESHI</h1>
            </a>
            <nav class="space-x-4">
                <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg">新規登録</a>
                <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">ログイン</a>
            </nav>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="bg-[#E7CEB8] py-12">
        <div class="max-w-7xl mx-auto px-6">
            <!-- ヘッダーセクション -->
            <section class="text-center mb-12">
                <img src="{{ asset('images/yama-about-main.png') }}" alt="山の画像" class="w-full h-64 object-cover rounded-lg shadow-md mb-6">
                <h2 class="text-3xl font-bold text-gray-800">ヤマメシとは？</h2>
                <p class="text-xl text-gray-600 mt-4">アウトドアでの食事やレシピを共有しよう！</p>
            </section>

            <!-- 目的セクション -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <div class="p-6 bg-white rounded-lg shadow-lg flex items-center space-x-4">
                    <div class="bg-orange-300 p-3 rounded-full">
                        <i class="fas fa-utensils text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">お気に入りのご飯を共有する</h3>
                        <p class="text-gray-600">自分のお気に入りの山メシレシピをシェアしよう。</p>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-lg shadow-lg flex items-center space-x-4">
                    <div class="bg-orange-300 p-3 rounded-full">
                        <i class="fas fa-hiking text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">アウトドアのレシピを知る</h3>
                        <p class="text-gray-600">他のユーザーのアウトドアレシピを参考にしてみよう。</p>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-lg shadow-lg flex items-center space-x-4">
                    <div class="bg-orange-300 p-3 rounded-full">
                        <i class="fas fa-camera-retro text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">思い出を記録する</h3>
                        <p class="text-gray-600">山での食事の写真とともに思い出をシェア。</p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- フッター -->
    <footer class="bg-orange-400 text-white py-4">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2025 Yama-Meshi All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
