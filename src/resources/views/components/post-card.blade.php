@props(['post'])

<div class="post-card">
    {{-- ヘッダー --}}
    <div class="post-card-header flex items-center space-x-3 mb-4">
        <img
        src="{{ $post->user->icon_path 
            ? asset('storage/' . $post->user->icon_path) 
            : asset('images/default-icon.png') }}"
        alt="ユーザーアイコン"
        class="w-10 h-10 rounded-full object-cover"
        >
        <span class="font-semibold">{{ $post->user->name }}</span>
    </div>
    
    <h3 class="post-card-title mb-3">
        {{ Str::limit($post->title, 30) }}
    </h3>
    <p class="text-xs text-gray-500 mb-1">
        {{ $post->date  }}
        <!-- {{ $post->date ?? '未入力' }} -->
    </p>

    {{-- 投稿画像 --}}
    @if (!empty($post->image_paths))
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach ($post->image_paths as $img)
                <div class="post-card-image mb-4">
                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
    @endif
        

    {{-- メタ情報＋アクション --}}
    <div class="post-card-meta flex items-center justify-between mb-4">
    <div class="flex items-center space-x-6">
        {{-- 食べたもの --}}
        <div class="flex items-center space-x-1 text-sm text-gray-600">
            <img src="{{ asset('images/icons/food.png') }}" alt="食べたもの" class="icon icon--food"/>
            <span>{{ $post->food }}</span>
        </div>
        {{-- 場所 --}}
        <div class="flex items-center space-x-1 text-sm text-gray-600">
            <img src="{{ asset('images/icons/place.png') }}" alt="場所" class="icon icon--place"/>
            <span>{{ $post->place }}</span>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        {{-- いいね --}}
        <form method="POST" action="{{ route('posts.toggleLike', $post->id) }}">
            @csrf
            <button type="submit" class="text-xl">
                @auth
                    @if($post->isLikedBy(auth()->user()))
                        <span class="text-red-500">
                            <img src="{{ asset('images/icons/fav-filled.png') }}" alt="いいね" class="icon icon--like"/>
                        </span>
                    @else
                        <span class="text-gray-400">
                            <img src="{{ asset('images/icons/fav-outline.png') }}" alt="いいね" class="icon icon--like"/>
                        </span>
                    @endif
                @else
                    <span class="text-gray-400">
                        <img src="{{ asset('images/icons/fav-outline.png') }}" alt="いいね" class="icon icon--like"/>
                    </span>
                @endauth
                {{-- ここでカウントを表示 --}}
                <span class="text-sm text-gray-600">{{ $post->likes_count }}</span>
            </button>
        </form>

        {{-- メッセージ（自分の投稿には表示しない） --}}
        @auth
            <x-message-modal :post="$post" />
        @endauth
    </div>
    </div>


    {{-- レシピ --}}
    @isset($post->ingredients)
        @if(count($post->ingredients))
            <div class="mt-4">
                <h4 class="font-semibold">レシピ</h4>
                <ul class="list-disc list-inside text-sm text-gray-700">
                    @foreach($post->ingredients as $ing)
                        <li>{{ $ing }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endisset

    {{-- パッキングリスト --}}
    @isset($post->packing_items)
        @if(count($post->packing_items))
            <div class="mt-4">
                <h4 class="font-semibold">パッキングリスト</h4>
                <ul class="list-decimal list-inside text-sm text-gray-700">
                    @foreach($post->packing_items as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endisset


    {{-- 本文エリア --}}
    <div class="post-card-body mb-4"
        x-data="{
        expanded: false,
        isTruncated: false
        }"
        x-init="$nextTick(() => {
        const el = $refs.content;
        // scrollHeight が clientHeight を超えていれば折り返し発生中
        isTruncated = el.scrollHeight > el.clientHeight;
        })"
    >

        <!-- <p class="text-xs text-gray-500 mb-1">
        {{ $post->date ?? '未入力' }}
        </p> -->
        <!-- <h3 class="post-card-title mb-3">
        {{ Str::limit($post->title, 30) }}
        </h3> -->
        <p
            x-ref="content"
            :class="expanded ? 'post-card-content expanded' : 'post-card-content'"
            class="text-sm text-gray-700 mb-2"
        >{{ $post->content }}
        </p>

        <button
            x-show="isTruncated && !expanded"
            @click="expanded = true"
            class="text-sm text-indigo-600 hover:underline"
        >
            続きを読む
        </button>
        <button
            x-show="expanded"
            @click="expanded = false"
            class="text-sm text-gray-600 hover:underline"
        >
            閉じる
        </button>

    </div>

    <!-- メッセージ一覧 -->
    @if($post->messages && $post->messages->isNotEmpty())
        <div class="mt-4 bg-gray-50 p-3 rounded border border-gray-200">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">この投稿へのメッセージ</h4>
            <ul class="space-y-2">
                @foreach($post->messages as $msg)
                    <li class="text-sm text-gray-800">
                        <span class="font-bold">{{ $msg->sender->name }}</span>
                        {{ $msg->content }}
                        <span class="text-xs text-gray-500 ml-2">{{ $msg->created_at->format('Y/m/d H:i') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
