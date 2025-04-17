@props(['post'])

<div x-data="{ open: false }" class="inline-block">
    <!-- 💬 ボタン -->
    <button @click="open = true"
        class="text-blue-500 hover:underline">
        💬 メッセージを送る
    </button>

    <!-- モーダル本体 -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <div @click.away="open = false" class="bg-white w-full max-w-md p-6 rounded shadow-lg relative">
            <!-- 閉じる -->
            <button @click="open = false"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

            <h2 class="text-xl font-semibold mb-4">{{ $post->user->name }} さんにメッセージを送る</h2>

            <form method="POST" action="{{ route('messages.send') }}">
                @csrf
                <input type="hidden" name="to_user_id" value="{{ $post->user->id }}">
                <input type="hidden" name="post_id" value="{{ $post->id }}">

                <textarea name="message" rows="4" class="w-full border p-2 rounded" placeholder="メッセージを入力..."></textarea>

                <div class="mt-4 text-right">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        送信
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
