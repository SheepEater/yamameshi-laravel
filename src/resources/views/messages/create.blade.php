<!-- ※このページもう使わない -->

<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">{{ $user->name }} さんにメッセージを送る</h2>

        <form method="POST" action="{{ route('messages.send') }}">
            @csrf
            <input type="hidden" name="to_user_id" value="{{ $user->id }}">

            <textarea name="message" rows="5" class="w-full border p-2 rounded-md" placeholder="メッセージを入力"></textarea>

            <div class="mt-4 text-right">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    送信
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
