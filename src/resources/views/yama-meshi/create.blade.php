<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">投稿を作成</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('yama-meshi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
                    <input type="text" name="title" id="title" class="mt-1 p-2 block w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">内容</label>
                    <textarea name="content" id="content" class="mt-1 p-2 block w-full border rounded-md"></textarea>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">画像</label>
                    <input type="file" name="image" id="image" class="mt-1 p-2 block w-full border rounded-md">
                </div>

                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                    投稿する
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
