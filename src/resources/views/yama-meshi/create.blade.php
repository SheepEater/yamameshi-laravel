<x-app-layout>
    <x-header />
    <h2 class="text-xl font-semibold text-gray-800 text-center mt-6">投稿を作成</h2>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
            <form method="POST" action="{{ route('yama-meshi.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- タイトル -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">タイトル <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required class="mt-1 p-2 w-full border rounded-md" placeholder="例：山ごはんでほっこり！">
                </div>

                <!-- 行った場所 -->
                <div>
                    <label for="place" class="block text-sm font-medium text-gray-700">行った場所</label>
                    <input type="text" name="place" id="place" class="mt-1 p-2 w-full border rounded-md" placeholder="例：富士山 八合目">
                </div>

                <!-- 食べたもの -->
                <div>
                    <label for="food" class="block text-sm font-medium text-gray-700">食べたもの</label>
                    <input type="text" name="food" id="food" class="mt-1 p-2 w-full border rounded-md" placeholder="例：山ごはんカレー、カップラーメン">
                </div>

                <!-- 日付（カレンダー＋直接入力） -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">日付</label>
                    <input
                        type="date"
                        name="date"
                        id="date"
                        class="mt-1 p-2 w-full border rounded-md"
                        placeholder="yyyy-mm-dd"
                        onfocus="this.showPicker && this.showPicker()"
                    >
                </div>

                <!-- 画像（複数） -->
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700">画像をアップロード（複数可）</label>
                    <input type="file" name="images[]" id="images" multiple class="mt-1 p-2 w-full border rounded-md">
                </div>

                <!-- 備考 -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">備考</label>
                    <textarea name="content" id="content" rows="4" class="mt-1 p-2 w-full border rounded-md" placeholder="食べたもの、行った場所、天気など自由に書いてください"></textarea>
                </div>

                <!-- ボタン -->
                <div class="flex justify-between items-center pt-4">
                    <!-- 戻るボタン -->
                    <a href="{{ url()->previous() }}"
                       class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                        戻る
                    </a>

                    <!-- 投稿ボタン -->
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg">
                        投稿する
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
