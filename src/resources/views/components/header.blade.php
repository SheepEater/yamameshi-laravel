<header x-data="{ navOpen: false }" class="site-header">
  <div class="site-header__left">
    <!-- ロゴ -->
    <a href="{{ route('home') }}" class="site-header__logo">
      <img src="{{ asset('images/yamameshi-logo.png') }}" alt="ヤマメシ ロゴ">
    </a>

    <!-- デスクトップ用ナビ -->
    <nav class="site-header__nav hidden sm:flex">
      <a href="{{ route('about') }}" class="site-header__nav-link">ヤマメシとは？</a>
      <a href="{{ route('yama-meshi.create') }}" class="site-header__nav-link">投稿する</a>
    </nav>
  </div>

  <div class="site-header__right">
    <!-- モバイル：ハンバーガー -->
    <button
      @click="navOpen = !navOpen"
      class="site-header__hamburger sm:hidden"
      aria-label="メニューを開く"
    >☰</button>

    @auth
      <!-- デスクトップ：アバターボタン -->
      <button
        @click="navOpen = !navOpen"
        class="site-header__avatar-btn hidden sm:block"
        aria-label="ユーザーメニューを開く"
      >
        <img src="{{ Auth::user()->icon_path 
            ? asset('storage/' . Auth::user()->icon_path) 
            : asset('images/default-icon.png') }}"
             alt="ユーザーアイコン">
      </button>
    @else
      <!-- デスクトップ：ログイン・会員登録ボタン -->
      <div class="site-header__btn-group hidden sm:flex">
        <a href="{{ route('register') }}" class="site-header__btn">新規会員</a>
        <a href="{{ route('login') }}"    class="site-header__btn">ログイン</a>
      </div>
    @endauth
  </div>

  {{-- モバイル用ドロワー --}}
  <div
    x-show="navOpen"
    @click.away="navOpen = false"
    x-cloak
    x-transition
    class="site-header__mobile-menu sm:hidden"
  >
    <nav class="flex flex-col">
      <a href="{{ route('about') }}" class="site-header__nav-link py-2">ヤマメシとは？</a>
      <a href="{{ route('yama-meshi.create') }}" class="site-header__nav-link py-2">投稿する</a>

      @auth
        <a href="{{ route('mypage') }}" class="site-header__nav-link py-2">マイページ</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="site-header__nav-link site-header__nav-link--danger py-2 text-left">
            ログアウト
          </button>
        </form>
      @else
        <a href="{{ route('register') }}" class="site-header__nav-link py-2">新規会員</a>
        <a href="{{ route('login') }}" class="site-header__nav-link py-2">ログイン</a>
      @endauth
    </nav>
  </div>

  {{-- デスクトップ用ドロップダウン --}}
  @auth
  <div
    x-show="navOpen"
    @click.away="navOpen = false"
    x-cloak
    x-transition
    class="site-header__dropdown hidden sm:block"
  >
    <a href="{{ route('mypage') }}" class="site-header__dropdown-link">マイページ</a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit"
              class="site-header__dropdown-link site-header__dropdown-link--danger">
        ログアウト
      </button>
    </form>
  </div>
  @endauth
</header>
