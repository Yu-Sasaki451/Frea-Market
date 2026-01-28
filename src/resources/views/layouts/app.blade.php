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
        <img class="header-logo" src="{{ asset('svg/logo.svg') }}" alt="">
        <form action="">
            <input class="header-utility__input" type="text" placeholder="何かお探しですか？">
        </form>
        <nav class="header-utility__nav">
            <form action="/logout" method="post">
                @csrf
                <button class="logout__button">ログアウト</button>
            </form>
            <a class="link-mypage" href="/mypage">マイページ</a>
            <a class="link-sell" href="/sell">出品</a>
        </nav>
    </header>
    @yield('content')
</body>
</html>