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

  {{-- メイン画像（あれば最初の1枚を大きく） --}}
  @if($post->image_paths)
    @php $first = json_decode($post->image_paths, true)[0]; @endphp
    <div class="post-card-image mb-4">
      <img
        src="{{ asset('storage/' . $first) }}"
        alt="投稿画像"
        class="w-full h-auto object-cover"
      >
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
        </button>
      </form>

      {{-- メッセージ（自分の投稿には表示しない） --}}
      <!-- @auth
        @if(auth()->id() !== $post->user_id)
          <button 
            type="button" 
            class="text-xl"
            @click="$dispatch('open-message-modal', { postId: {{ $post->id }} })"
          >💬</button>
        @endif
      @endauth -->
        @auth
            @if (auth()->id() !== $post->user_id)
                <x-message-modal :post="$post" />
            @endif
        @endauth
    </div>
  </div>

  {{-- 本文エリア --}}
  <div class="post-card-body mb-4">
    <p class="text-xs text-gray-500 mb-1">
      <!-- {{ optional($post->date)->format('Y.m.d') ?? '未入力' }} -->
      {{ $post->date ?? '未入力' }}
    </p>
    <h3 class="post-card-title mb-3">
      {{ Str::limit($post->title, 30) }}
    </h3>
    <p class="post-card-content text-sm text-gray-700 line-clamp-3">
      {{ $post->content }}
    </p>
  </div>

  {{-- 続きを読む --}}
  <div class="text-right">
    <a href="#"
       class="post-card-readmore text-sm hover:underline text-indigo-600">
      続きを読む
    </a>
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
