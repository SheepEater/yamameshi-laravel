<x-app-layout>
    <x-header />
    <h2 class="text-xl font-semibold text-center mt-6">投稿を編集</h2>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
            <form method="POST" action="{{ route('yama-meshi.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- タイトル -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">タイトル <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" id="title" maxlength="30" required class="mt-1 p-2 w-full border rounded-md">
                </div>

                <!-- 行った場所 -->
                <div>
                    <label for="place" class="block text-sm font-medium text-gray-700">行った場所</label>
                    <input type="text" name="place" value="{{ old('place', $post->place) }}" id="place" maxlength="30" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <!-- 食べたもの -->
                <div>
                    <label for="food" class="block text-sm font-medium text-gray-700">食べたもの</label>
                    <input type="text" name="food" value="{{ old('food', $post->food) }}" id="food" maxlength="30" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <!-- 日付（カレンダー＋直接入力） -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">日付</label>
                    <input
                        type="date"
                        name="date"
                        value="{{ old('date', $post->date) }}"
                        id="date"
                        class="mt-1 p-2 w-full border rounded-md"
                        onfocus="this.showPicker && this.showPicker()"
                    >
                </div>

                <!-- 画像（複数） -->
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700">画像をアップロード（複数可）</label>
                    {{-- 既存画像があればサムネイルで表示 --}}
                    @php $images = $post->image_paths ?? []; @endphp
                    @if(count($images) > 0)
                        <div class="mt-2 grid grid-cols-3 gap-2">
                        @foreach($images as $img)
                            <div class="w-24 h-24 overflow-hidden rounded-md border">
                            <img
                                src="{{ asset('storage/' . $img) }}"
                                alt="既存画像"
                                class="w-full h-full object-cover"
                            >
                            </div>
                        @endforeach
                        </div>
                    @endif
                    <input type="file" name="images[]" id="images" multiple class="mt-1 p-2 w-full border rounded-md">
                </div>


                {{-- 材料リスト --}}
                <div x-data="{ items: {{ json_encode(old('ingredients', $post->ingredients ?? [''])) }} }">
                    <label class="block font-medium">材料リスト</label>
                    <template x-for="(item, idx) in items" :key="idx">
                        <div class="flex items-center mb-2 space-x-2">
                            <input
                                type="text"
                                :name="`ingredients[${idx}]`"
                                x-model="items[idx]"
                                class="flex-1 border rounded p-2"
                                placeholder="例：米 100g"
                            >
                            <button type="button" @click="items.splice(idx,1)" class="text-red-500">×</button>
                        </div>
                    </template>
                    <button type="button" @click="items.push('')" class="text-green-600 hover:underline">
                        ＋ 材料を追加
                    </button>
                </div>

                {{-- パッキングリスト --}}
                <div x-data="{ pack: {{ json_encode(old('packing_items', $post->packing_items ?? [''])) }} }" class="mt-4">
                    <label class="block font-medium">パッキングリスト</label>
                    <template x-for="(it, i) in pack" :key="i">
                        <div class="flex items-center mb-2 space-x-2">
                            <input
                                type="text"
                                :name="`packing_items[${i}]`"
                                x-model="pack[i]"
                                class="flex-1 border rounded p-2"
                                placeholder="例：バーナー"
                            >
                            <button type="button" @click="pack.splice(i,1)" class="text-red-500">×</button>
                        </div>
                    </template>
                    <button type="button" @click="pack.push('')" class="text-green-600 hover:underline">
                        ＋ アイテムを追加
                    </button>
                </div>


                <!-- 備考 -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">備考(200文字以内)</label>
                    <textarea name="content" id="content" maxlength="200" rows="4" class="mt-1 p-2 w-full border rounded-md">{{ old('content', $post->content) }}</textarea>
                </div>

                <!-- ボタン -->
                <div class="flex justify-between items-center pt-4">
                    <!-- 戻るボタン -->
                    <a href="{{ url()->previous() }}"
                       class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                        戻る
                    </a>

                    <!-- 保存ボタン -->
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg">
                        更新する
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
