<x-app-layout>
    <x-header />
    <h2 class="text-xl font-semibold text-center mt-6">投稿を作成</h2>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
            <form method="POST" action="{{ route('yama-meshi.store') }}" enctype="multipart/form-data" x-data="{
                showPlace: false,
                showFood: false,
                showDate: false,
                items: {{ json_encode(old('ingredients', $post->ingredients ?? [])) }},
                pack:  {{ json_encode(old('packing_items', $post->packing_items ?? [])) }} }"
            >
                @csrf
                @method(isset($post) ? 'PUT' : 'POST')
                <!-- タイトル -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">タイトル <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" maxlength="30" required class="mt-1 p-2 w-full border rounded-md" placeholder="例：山ごはんでほっこり！(30文字以内)">
                </div>

                <!-- 行った場所 -->
                <div class="mb-4">
                    <button 
                        type="button"
                        @click="showPlace = !showPlace"
                        class="flex items-center justify-between w-full bg-gray-100 p-2 rounded"
                    >
                        <span>行った場所</span>
                        <span x-text="showPlace ? '−' : '+'"></span>
                    </button>
                    <div x-show="showPlace" x-cloak class="mt-2">
                        <input
                            type="text"
                            name="place"
                            value="{{ old('place', $post->place ?? '') }}"
                            maxlength="30"
                            class="w-full border rounded p-2"
                            placeholder="例：富士山 八合目"
                        >
                    </div>
                </div>

                <!-- 食べたもの -->
                <div class="mb-4">
                    <button 
                        type="button"
                        @click="showFood = !showFood"
                        class="flex items-center justify-between w-full bg-gray-100 p-2 rounded"
                    >
                        <span>食べたもの</span>
                        <span x-text="showFood ? '−' : '+'"></span>
                    </button>
                    <div x-show="showFood" x-cloak class="mt-2">
                        <input
                            type="text"
                            name="food"
                            value="{{ old('food', $post->food ?? '') }}"
                            maxlength="30"
                            class="w-full border rounded p-2"
                            placeholder="例：山ごはんカレー"
                        >
                    </div>
                </div>

                <!-- 日付（カレンダー＋直接入力） -->
                <div class="mb-4">
                    <button 
                        type="button"
                        @click="showDate = !showDate"
                        class="flex items-center justify-between w-full bg-gray-100 p-2 rounded"
                    >
                        <span>日付</span>
                        <span x-text="showDate ? '−' : '+'"></span>
                    </button>
                    <div x-show="showDate" x-cloak class="mt-2">
                        <input
                            type="date"
                            name="date"
                            value="{{ old('date') }}"
                            class="w-full border rounded p-2"
                            onfocus="this.showPicker && this.showPicker()"
                        >
                    </div>
                </div>

                <!-- 画像（複数） -->
                {{-- 画像アップロード＆プレビュー --}}
                <div
                    x-data="{
                        previewUrl: '{{ isset($post) && !empty($post->image_paths) ? asset('storage/'.$post->image_paths[0]) : '' }}',
                        trigger() {
                        this.$refs.file.click();
                        },
                        add(event) {
                        const file = event.target.files[0];
                        if (!file) return;
                        this.previewUrl = URL.createObjectURL(file);
                        },
                        remove() {
                        this.previewUrl = '';
                        this.$refs.file.value = null;
                        }
                    }"
                    class="mb-6 relative"
                    >
                    <label class="block text-sm font-medium text-gray-700 mb-2">画像をアップロード</label>

                    <!-- プレビュー or ＋アイコン -->
                    <div
                        @click="trigger()"
                        class="cursor-pointer w-32 h-32 border border-gray-300 rounded-md flex items-center justify-center overflow-hidden relative"
                    >
                        <template x-if="previewUrl">
                        <img
                            :src="previewUrl"
                            class="w-full h-full object-cover"
                            alt="プレビュー画像"
                        />
                        </template>
                        <template x-if="!previewUrl">
                        <span class="text-3xl text-gray-400">＋</span>
                        </template>

                        <!-- キャンセルボタン -->
                        <button
                        x-show="previewUrl"
                        @click.stop="remove()"
                        class="absolute top-1 right-1 bg-white bg-opacity-75 rounded-full p-1 text-red-600 hover:bg-opacity-100"
                        >&times;</button>
                    </div>

                    <!-- 隠しファイル入力 -->
                    <input
                        type="file"
                        x-ref="file"
                        name="images[]"
                        accept="image/*"
                        class="hidden"
                        @change="add($event)"
                    />
                </div>

                {{-- 材料リスト --}}
                <div class="mb-6">
                    <label class="block font-medium mb-2">材料リスト（任意）</label>
                    <template x-for="(item, idx) in items" :key="idx">
                    <div class="flex items-center space-x-2 mb-2">
                        <input
                        type="text"
                        :name="`ingredients[${idx}]`"
                        x-model="items[idx]"
                        class="flex-1 border rounded p-2"
                        placeholder="例：米 100g"
                        >
                        <button type="button" @click="items.splice(idx,1)" class="text-red-500">削除</button>
                    </div>
                    </template>
                    <button
                    type="button"
                    @click="items.push('')"
                    class="text-sm text-green-600 hover:underline"
                    >
                    ＋ 材料を追加
                    </button>
                </div>

                {{-- パッキングリスト --}}
                <div class="mb-6">
                    <label class="block font-medium mb-2">パッキングリスト（任意）</label>
                    <template x-for="(it, i) in pack" :key="i">
                    <div class="flex items-center space-x-2 mb-2">
                        <input
                        type="text"
                        :name="`packing_items[${i}]`"
                        x-model="pack[i]"
                        class="flex-1 border rounded p-2"
                        placeholder="例：バーナー"
                        >
                        <button type="button" @click="pack.splice(i,1)" class="text-red-500">削除</button>
                    </div>
                    </template>
                    <button
                    type="button"
                    @click="pack.push('')"
                    class="text-sm text-green-600 hover:underline"
                    >
                    ＋ アイテムを追加
                    </button>
                </div>


                <!-- 備考 -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">備考(200文字以内)</label>
                    <textarea name="content" id="content" maxlength="200" rows="4" class="mt-1 p-2 w-full border rounded-md" placeholder="食べたもの、行った場所、天気など自由に書いてください"></textarea>
                </div>

                <!-- ボタン -->
                <div class="flex justify-between items-center pt-4">
                    <!-- 戻るボタン -->
                    <a href="{{ url()->previous() }}"
                       class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                        戻る
                    </a>

                    <!-- 投稿ボタン -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-300 rounded">戻る</a>
                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded">
                            {{ isset($post) ? '更新する' : '投稿する' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
