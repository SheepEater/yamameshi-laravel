<!-- resources/views/legal/terms.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>利用規約 | {{ config('app.name', 'ヤマメシ') }}</title>

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    @vite('resources/js/app.js')
</head>
<body class="font-sans bg-gray-100 text-gray-900">
    <x-header />

    <main class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
            <h1 class="text-3xl font-bold mb-6">利用規約</h1>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第1条（適用）</h2>
                <p>本規約は、本サービス「{{ config('app.name', 'ヤマメシ') }}」の利用に関する条件を定めるものです。ユーザーは本規約に同意した上で利用してください。</n            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第2条（利用登録）</h2>
                <p>利用者は、所定の登録フォームで必要事項を入力し、登録を完了するものとします。運営者が登録を承認した時点で利用契約が成立します。</p>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第3条（禁止事項）</h2>
                <ul class="list-disc list-inside">
                    <li>法令または公序良俗に反する行為</li>
                    <li>他のユーザーや第三者の権利を侵害する行為</li>
                    <li>不正アクセスやサービス運営を妨害する行為</li>
                    <li>その他運営者が不適切と判断する行為</li>
                </ul>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第4条（免責事項）</h2>
                <p>運営者は、本サービスの提供にあたり、ユーザーが被った損害について一切の責任を負いません。サービスの中断、中止、変更についても同様です。</p>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第5条（規約の変更）</h2>
                <p>運営者は必要に応じて本規約を変更することができ、変更後はウェブサイト上に表示した時点で効力を発生します。</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold mb-2">第6条（準拠法・裁判管轄）</h2>
                <p>本規約の準拠法は日本法とし、本サービスに関して紛争が生じた場合、東京地方裁判所を第一審の専属管轄裁判所とします。</p>
            </section>
        </div>
    </main>

    <x-footer />
</body>
</html>
