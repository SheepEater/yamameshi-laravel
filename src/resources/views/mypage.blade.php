<x-app-layout>
    <!-- ヘッダー -->
    <x-header />

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
        <div x-data="{ tab: '{{ request('tab', 'posts') }}' }" x-cloak class="mt-8">
            <!-- タブ切り替えボタン -->
            <div class="flex justify-center space-x-4 mb-6">
                <button @click="tab = 'posts'; history.replaceState(null, '', '?tab=posts')" 
                    class="px-4 py-2 rounded-lg"
                    :class="tab === 'posts' ? 'bg-blue-500 text-white' : 'bg-gray-200'">
                    自分の投稿
                </button>
                <button @click="tab = 'likes'; history.replaceState(null, '', '?tab=likes')" 
                    class="px-4 py-2 rounded-lg"
                    :class="tab === 'likes' ? 'bg-blue-500 text-white' : 'bg-gray-200'">
                    いいね一覧
                </button>
            </div>

            <!-- 自分の投稿一覧 -->
            <div x-show="tab === 'posts'">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">自分の投稿</h2>
                @forelse ($posts as $post)
                    <x-post-card :post="$post" />
                @empty
                    <p>投稿はまだありません。</p>
                @endforelse
            </div>

            <!-- いいね一覧 -->
            <div x-show="tab === 'likes'">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">いいねした投稿</h2>
                @forelse ($likedPosts as $like)
                    @if($like->post)
                        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                            <h3 class="text-xl font-bold text-gray-800">{{ $like->post->title }}</h3>
                            <p>{{ $like->post->content }}</p>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">この投稿は削除されました。</p>
                    @endif
                @empty
                    <p>いいねした投稿はありません。</p>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
