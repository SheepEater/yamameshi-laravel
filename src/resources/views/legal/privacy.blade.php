<!-- resources/views/legal/privacy.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>プライバシーポリシー | {{ config('app.name', 'ヤマメシ') }}</title>

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    @vite('resources/js/app.js')
</head>
<body class="font-sans bg-gray-100 text-gray-900">
    <x-header />

    <main class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
            <h1 class="text-3xl font-bold mb-6">プライバシーポリシー</h1>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第1条（個人情報の定義）</h2>
                <p>本プライバシーポリシーにおける「個人情報」とは、個人に関する情報であって、氏名、メールアドレス、IPアドレス等の特定の個人を識別できるものを指します。</p>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第2条（個人情報の収集方法）</h2>
                <p>ユーザーが登録フォームやお問い合わせフォームを通じて自発的に提供する情報により収集します。また、サービス利用時のログ情報やCookie情報を取得する場合があります。</p>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第3条（個人情報の利用目的）</h2>
                <ul class="list-disc list-inside">
                    <li>会員登録の管理および本人確認のため</li>
                    <li>サービス提供・運営のため</li>
                    <li>お問い合わせ対応のため</li>
                    <li>サービス改善や新機能開発のための分析・マーケティングのため</li>
                    <li>法令遵守および権利保護のため</li>
                </ul>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第4条（第三者提供）</h2>
                <p>収集した個人情報は、業務委託先に業務の一部を委託する場合を除き、本人の同意なく第三者に提供しません。</p>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第5条（Cookie等の使用）</h2>
                <p>当サービスでは、Cookieおよび類似技術を使用してユーザーの利便性向上およびサイト分析を行います。Cookieの無効化はブラウザ設定により可能ですが、一部機能が制限される場合があります。</p>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第6条（安全管理措置）</h2>
                <p>個人情報への不正アクセス、漏えい、紛失、改ざん等を防止するため、技術的および組織的な安全管理措置を講じます。</p>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第7条（開示・訂正・利用停止等の手続）</h2>
                <p>ユーザーから自己の個人情報の開示、訂正、利用停止等の請求があった場合、本人確認のうえ合理的な期間内に対応します。手続き方法はお問い合わせフォームからご連絡ください。</p>
            </section>

            <section class="mb-6">
                <h2 class="text-xl font-semibold mb-2">第8条（プライバシーポリシーの変更）</h2>
                <p>本ポリシーは、法令改正やサービス向上のため随時変更されることがあります。変更後は本ページにて通知し、掲載時点で効力を生じます。</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold mb-2">第9条（お問い合わせ先）</h2>
                <p>本ポリシーに関するお問い合わせは、<a href="{{ route('contact') }}" class="text-blue-600 hover:underline">お問い合わせフォーム</a>からご連絡ください。</p>
            </section>
        </div>
    </main>

    <x-footer />
</body>
</html>
