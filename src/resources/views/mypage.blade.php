<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">マイページ</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <!-- ユーザー情報 -->
        <div class="bg-white shadow-md rounded-lg p-6 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('images/default-icon.png') }}" alt="ユーザーアイコン" class="h-16 w-16 rounded-full mr-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>

            <!-- ログアウト・アカウント削除 -->
            <div class="flex space-x-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">
                        ログアウト
                    </button>
                </form>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg">
                        アカウント削除
                    </button>
                </form>
            </div>
        </div>

        <!-- いいね一覧 -->
        <div class="mt-6">
            <a href="#" class="block text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg">
                いいね一覧を見る
            </a>
        </div>

        <!-- 自身の投稿一覧 -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">自分の投稿</h2>
            <div id="post-list">
                @if($posts->isEmpty())
                    <p class="text-gray-600">投稿はまだありません。</p>
                @else
                    @foreach($posts as $post)
                        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                            <h3 class="text-xl font-bold text-gray-800">{{ $post->title }}</h3>
                            <p class="text-gray-700">{{ $post->content }}</p>
                            @if($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}" class="mt-2 w-full max-w-xs">
                            @endif
                            <p class="text-sm text-gray-500">投稿日: {{ $post->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
