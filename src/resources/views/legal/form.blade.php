<!-- resources/views/contact/form.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>お問い合わせ | {{ config('app.name', 'ヤマメシ') }}</title>

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    @vite('resources/js/app.js')
</head>
<body class="font-sans bg-gray-100 text-gray-900">
    <x-header />

    <main class="py-12">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
            <h1 class="text-3xl font-bold mb-6">お問い合わせ</h1>

            <form method="POST" action="{{ route('contact.send') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700">お名前</label>
                    <input id="name" name="name" type="text" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded"
                        value="{{ old('name') }}">
                    @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700">メールアドレス</label>
                    <input id="email" name="email" type="email" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded"
                        value="{{ old('email') }}">
                    @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label for="message" class="block text-gray-700">お問い合わせ内容</label>
                    <textarea id="message" name="message" rows="5" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end">
                    <x-primary-button>送信</x-primary-button>
                </div>
            </form>
        </div>
    </main>

    <x-footer />
</body>
</html>
