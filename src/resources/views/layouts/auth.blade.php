<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="auth-header">
        <div class="header__inner">
            <img class="svg-logo" src="{{ asset('svg/logo.svg') }}" alt="">
        </div>
    </header>
    @yield('content')
</body>
</html>