<x-app-layout>
    <!-- ヘッダー -->
    <x-header />

    <div class="py-6 max-w-4xl mx-auto">
        <!-- ユーザー情報 -->
        <div class="bg-white shadow-md rounded-lg p-6 flex justify-between items-center">
            <div class="flex items-center">
            <img src="{{ asset('storage/' . $user->icon_path) }}" class="mt-2 w-16 h-16 rounded-full">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>          
            <!-- ログアウト・アカウント削除 -->
            <div class="flex flex-col space-y-4 items-end">
                <!-- 仮でstyleを使用！！　bg-orange-600　、というやりかたが適応できなかったため -->
                <style>
                    .force-orange {
                        background-color: #ea580c !important; /* Tailwindの bg-orange-600 */
                        color: white !important;
                    }
                </style>
                <a href="{{ route('profile.edit') }}" class="force-orange font-bold py-2 px-4 rounded border border-black rounded-lg">プロフィール編集</a>

                <!-- <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg">
                        アカウント削除
                    </button>
                </form> -->
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
                        <x-post-card :post="$like->post" />
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
