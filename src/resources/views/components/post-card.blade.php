@props(['post'])

<div class="bg-white shadow-md rounded-lg p-4 mb-6 space-y-3">
    <!-- ユーザー情報 -->
    <div class="flex items-center space-x-4">
        <img src="{{ asset('images/default-icon.png') }}" class="w-10 h-10 rounded-full" alt="ユーザーアイコン">
        <div>
            <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
            @if($post->user->gender || $post->user->age)
                <p class="text-sm text-gray-600">
                    @if($post->user->gender) 性別: {{ $post->user->gender }} @endif
                    @if($post->user->age) / 年齢: {{ $post->user->age }}歳 @endif
                </p>
            @endif
        </div>
    </div>

    <h3 class="text-xl font-bold text-gray-800">{{ $post->title }}</h3>
    <p class="text-sm text-gray-500">日付: {{ $post->date ?? '未入力' }}</p>
    <p class="text-gray-700">場所: {{ $post->place ?? '未入力' }}</p>
    <p class="text-gray-700">食べたもの: {{ $post->food ?? '未入力' }}</p>
    <p class="text-gray-700">備考: {{ $post->content ?? '未入力' }}</p>

    @if($post->image_paths)
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach(json_decode($post->image_paths, true) as $img)
                <img src="{{ asset('storage/' . $img) }}" class="w-40 h-40 object-cover rounded-md">
            @endforeach
        </div>
    @endif

    <!-- アクションボタン -->
    <div class="flex items-center justify-between mt-4">
        <!-- いいね -->
        <form method="POST" action="{{ route('posts.toggleLike', $post->id) }}">
            @csrf
            <button type="submit" class="flex items-center space-x-1">
                @auth
                    @if($post->isLikedBy(auth()->user()))
                        <span class="text-pink-500">❤️</span>
                    @else
                        <span class="text-gray-400">🤍</span>
                    @endif
                @endauth
                <span class="text-sm text-gray-600">{{ $post->likes_count }}</span>
            </button>
        </form>

        <!-- メッセージモーダル -->
        @auth
            @if (auth()->id() !== $post->user_id)
                <x-message-modal :post="$post" />
            @endif
        @endauth
        </div>
</div>
