<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">投稿一覧</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            @if($posts->isEmpty())
                <p class="text-gray-600">投稿はまだありません。</p>
            @else
                @foreach($posts as $post)
                    <div class="bg-gray-100 shadow rounded-lg p-4 mb-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $post->title }}</h3>
                        <p class="text-gray-700 mt-2">{{ $post->content }}</p>
                        @if($post->image_path)
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="mt-2 w-full max-w-xs rounded-lg">
                        @endif
                        <p class="text-sm text-gray-500 mt-2">投稿日: {{ $post->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>