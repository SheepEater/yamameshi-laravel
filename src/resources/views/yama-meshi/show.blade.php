<x-app-layout>
    <x-header />

    <div class="py-6 max-w-4xl mx-auto space-y-6">
        <!-- 戻るボタン -->
        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:underline">
            ← 投稿一覧に戻る
        </a>

        <!-- 投稿詳細 -->
        <div class="bg-white shadow-lg rounded-lg p-6 space-y-4">
            {{-- ユーザー情報 --}}
            <div class="flex items-center space-x-4">
                <img src="{{ $post->user->icon_path ? asset('storage/'.$post->user->icon_path) : asset('images/default-icon.png') }}"
                    class="w-12 h-12 rounded-full object-cover" alt="アイコン">
                <div>
                    <p class="font-semibold">{{ $post->user->name }}</p>
                    <p class="text-xs text-gray-500">ID #{{ $post->user->id }}</p>
                </div>
            </div>

            {{-- タイトル／日付 --}}
            <div>
                <h1 class="text-2xl font-bold">{{ $post->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $post->date ?? '日付未設定' }}</p>
            </div>

            {{-- 画像ギャラリー --}}
            @if(!empty($post->image_paths))
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($post->image_paths as $img)
                <img src="{{ asset('storage/'.$img) }}"
                    class="w-full h-64 object-cover rounded" alt="投稿画像">
                @endforeach
            </div>
            @endif

            {{-- メタ情報（場所・食べもの） --}}
            <div class="flex space-x-6 text-gray-600">
                <div class="flex items-center space-x-1">
                    <img src="{{ asset('images/icons/place.png') }}" class="w-5 h-5" />
                    <span>{{ $post->place ?? '場所未設定' }}</span>
                </div>
                <div class="flex items-center space-x-1">
                    <img src="{{ asset('images/icons/food.png') }}" class="w-5 h-5" />
                    <span>{{ $post->food ?? '食べもの未設定' }}</span>
                </div>
            </div>

            {{-- レシピ --}}
            @if(!empty($post->ingredients))
            <div>
                <h2 class="font-semibold mb-2">レシピ</h2>
                <ul class="list-disc list-inside">
                    @foreach($post->ingredients as $ing)
                    <li>{{ $ing }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- パッキングリスト --}}
            @if(!empty($post->packing_items))
            <div>
                <h2 class="font-semibold mb-2">パッキングリスト</h2>
                <ul class="list-decimal list-inside">
                    @foreach($post->packing_items as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- 本文 --}}
            @if($post->content)
            <div class="whitespace-pre-wrap text-gray-700">
                {{ $post->content }}
            </div>
            @endif

            {{-- アクションボタン（いいね・メッセージなど） --}}
            <div class="flex items-center space-x-4 pt-4 border-t">
                {{-- いいね数だけ表示 --}}
                <div class="flex items-center space-x-1">
                    <form method="POST" action="{{ route('posts.toggleLike', $post->id) }}">
                        @csrf
                        <button type="submit" class="text-xl">
                            @auth
                            @if($post->isLikedBy(auth()->user()))
                            <span class="text-red-500">
                                <img src="{{ asset('images/icons/fav-filled.png') }}" alt="いいね" class="icon icon--like" />
                            </span>
                            @else
                            <span class="text-gray-400">
                                <img src="{{ asset('images/icons/fav-outline.png') }}" alt="いいね" class="icon icon--like" />
                            </span>
                            @endif
                            @else
                            <span class="text-gray-400">
                                <img src="{{ asset('images/icons/fav-outline.png') }}" alt="いいね" class="icon icon--like" />
                            </span>
                            @endauth
                            {{-- ここでカウントを表示 --}}
                            <span class="text-sm text-gray-600">{{ $post->likes_count }}</span>
                        </button>
                    </form>
                </div>
                {{-- メッセージ数 --}}
                <div class="text-gray-600 text-sm">
                    💬 {{ $post->messages->count() }} 件のメッセージ
                </div>
            </div>
        </div>

        <!-- コメント一覧 -->
        @if($post->messages->isNotEmpty())
        <div class="bg-white shadow rounded-lg p-4 space-y-3">
            <h3 class="font-semibold">この投稿へのメッセージ</h3>
            <ul class="space-y-2">
                @foreach($post->messages as $msg)
                <li class="text-sm">
                    <span class="font-bold">{{ $msg->sender->name }}：</span>
                    {{ $msg->content }}
                    <span class="text-xs text-gray-500 ml-2">{{ $msg->created_at->format('Y/m/d H:i') }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
</x-app-layout>