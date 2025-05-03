{{-- src/resources/views/components/header.blade.php --}}
<header class="site-header">
  <div class="site-header__left">
    <a href="{{ route('home') }}" class="site-header__logo">
      <img src="{{ asset('images/yamameshi-logo.png') }}" alt="ヤマメシ ロゴ">
    </a>
    <nav class="site-header__nav">
      <a href="{{ route('about') }}" class="site-header__nav-link">ヤマメシとは？</a>
      <a href="{{ route('yama-meshi.create') }}" class="site-header__nav-link">投稿する</a>
    </nav>
  </div>

  <div class="site-header__right" x-data="{ open: false }">
    @auth
      <button @click="open = !open" class="site-header__avatar-btn">
        <img
          src="{{ Auth::user()->icon_path
            ? asset('storage/' . Auth::user()->icon_path)
            : asset('images/default-icon.png') }}"
          alt="ユーザーアイコン"
        >
      </button>
      <div x-show="open" @click.away="open = false" class="site-header__dropdown">
        <a href="{{ route('mypage') }}" class="site-header__dropdown-link">マイページ</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="site-header__dropdown-link site-header__dropdown-link--danger">
            ログアウト
          </button>
        </form>
      </div>
    @else
      <div class="site-header__btn-group">
        <a href="{{ route('register') }}" class="site-header__btn">新規会員</a>
        <a href="{{ route('login') }}"    class="site-header__btn">ログイン</a>
      </div>
    @endauth
  </div>
</header>
