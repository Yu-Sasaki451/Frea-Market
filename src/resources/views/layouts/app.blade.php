<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @yield('css')
</head>
<body>
    <header class="auth-header">
        <a href="/"><img class="header-logo" src="{{ asset('svg/logo.svg') }}" alt=""></a>
        <form action="/" method="get">
            <input class="header-utility__input" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="何をお探しですか？">
        </form>
        <nav class="header-utility__nav">
            @guest
                <a class="link-login" href="/login">ログイン</a>
            @endguest
            @auth
                <form action="/logout" method="post">
                    @csrf
                    <button class="logout__button">ログアウト</button>
                </form>
            @endauth
            <a class="link-mypage" href="/mypage">マイページ</a>
            <a class="link-sell" href="/sell">出品</a>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    
</body>
</html>