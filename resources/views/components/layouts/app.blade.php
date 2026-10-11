<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-black">
    <header
        class="flex items-center justify-between gap-4 bg-black px-4 py-4 sm:px-8"
    >
        <a href="{{ route('home') }}" class="block w-fit">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="{{ config('app.name') }}"
                class="h-9 max-w-full object-contain"
            />
        </a>
        {{-- ログイン・会員登録・メール認証の案内の画面では、リンクの先がどれもこれらの画面に戻るため、ナビゲーションを表示しない --}}
        @unless (request()->routeIs('login', 'register', 'verification.notice'))
            <nav class="flex shrink-0 items-center gap-4 text-white sm:gap-6">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="cursor-pointer">ログアウト</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}">ログイン</a>
                @endguest

                <a href="{{ route('profile.show') }}">マイページ</a>
            </nav>
        @endunless
    </header>
    <main>{{ $slot }}</main>
</body>
</html>
