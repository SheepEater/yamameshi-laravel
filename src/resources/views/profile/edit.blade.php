<x-app-layout>
    <x-header />

    <div class="max-w-4xl mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6 text-center">プロフィール編集</h2>
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- プロフィールアイコン -->
            <div>
                <label for="icon">アイコン画像</label>
                <img src="{{ Auth::user()->icon_path
                    ? asset('storage/' . Auth::user()->icon_path)
                    : asset('images/default-icon.png') }}" alt="ユーザーアイコン" class="mt-2 w-16 h-16 rounded-full">
                <input type="file" name="icon" id="icon" class="mt-1 block w-full border rounded p-2">    
            </div>

            <!-- 名前 -->
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">名前</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full border rounded-md p-2" required autofocus>
            </div>

            <!-- 性別 -->
            <div>
                <label for="gender" class="block font-medium text-sm text-gray-700">性別</label>
                <select id="gender" name="gender" class="mt-1 block w-full border rounded-md p-2">
                    <option value="">選択してください</option>
                    <option value="男性" {{ old('gender', $user->gender) === '男性' ? 'selected' : '' }}>男性</option>
                    <option value="女性" {{ old('gender', $user->gender) === '女性' ? 'selected' : '' }}>女性</option>
                    <option value="その他" {{ old('gender', $user->gender) === 'その他' ? 'selected' : '' }}>その他</option>
                </select>
            </div>

            <!-- 生年月日 -->
            <div>
                <x-forms.birth-date :birthDate="$user->birth_date" />
            </div>

            <!-- メールアドレス -->
            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">メールアドレス</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                    class="mt-1 block w-full border rounded-md p-2" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    保存する
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg">
                アカウント削除
            </button>
        </form>

    </div>
</x-app-layout>
