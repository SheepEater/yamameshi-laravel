<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- メールアドレス（必須） -->
        <div>
            <x-input-label for="email">
                メールアドレス <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- パスワード（必須） -->
        <div class="mt-4">
            <x-input-label for="password">
                パスワード <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- パスワード再入力（必須） -->
        <div class="mt-4">
            <x-input-label for="password_confirmation">
                パスワードを再入力 <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- 名前（必須） -->
        <div class="mt-4">
            <x-input-label for="name">
                名前 <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- 性別（任意） -->
        <div class="mt-4">
            <x-input-label :value="'性別（任意）'" />
            <div class="flex items-center space-x-4 mt-2">
                <label class="flex items-center">
                    <input type="radio" name="gender" value="male" class="form-radio">
                    <span class="ml-2">男性</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="female" class="form-radio">
                    <span class="ml-2">女性</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="gender" value="other" class="form-radio">
                    <span class="ml-2">その他</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- 年齢（任意） -->
        <div class="mt-4">
            <x-input-label for="age" :value="'年齢（任意）'" />
            <x-text-input id="age" class="block mt-1 w-full" type="number" name="age"
                :value="old('age')" min="0" />
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>

        <!-- ボタンエリア -->
        <div class="flex items-center justify-between mt-6">
            <a href="{{ url()->previous() }}"
               class="text-sm text-gray-600 hover:text-gray-900 underline">
                戻る
            </a>

            <x-primary-button class="ml-4">
                登録する
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
