<x-app-layout>
    <x-header />
    <h2 class="text-xl font-semibold text-center mt-6">投稿を編集</h2>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
            <form method="POST" action="{{ route('yama-meshi.update', $post) }}" enctype="multipart/form-data" 
                x-data="{
                    items: @json(old('ingredients', $post->ingredients)),
                    pack:  @json(old('packing_items', $post->packing_items)),
                    previewUrl: @json(!empty($post->image_paths) ? asset('storage/'.$post->image_paths[0]) : '')
                }"
            >
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
                        value="{{ old('date', $post->date->format('Y-m-d')) }}"
                        id="date"
                        class="mt-1 p-2 w-full border rounded-md"
                        onfocus="this.showPicker && this.showPicker()"
                    >
                </div>

                <!-- 画像（複数） -->
                {{-- 画像アップロード＆プレビュー（単一画像） --}}
                <div
                    x-data="{
                        // 初期プレビュー：既存画像があれば表示
                        previewUrl: '{{ isset($post) && !empty($post->image_paths) ? asset('storage/' . $post->image_paths[0]) : '' }}',
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
                    class="mb-6"
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
