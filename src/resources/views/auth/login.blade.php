@extends('auth.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection


@section('content')
<main class="login">
    <form class="login-form" action="/login" method="post">
        <div class="login-form__inner">
            <h2 class="login-form__header">ログイン</h2>
            
            <label class="login-label">メールアドレス</label>
            <input class="login-input" type="text" name="email" value="{{ old('email') }}">
            <div class="form-error">
                バリデーション実装後にやる
                        {{-- @error('password')
                        {{ $message }}
                        @enderror --}}
            </div>

            <label class="login-label">パスワード</label>
            <input class="login-input" type="password" name="password">
            <div class="form-error">
                バリデーション実装後にやる
                        {{-- @error('password')
                        {{ $message }}
                        @enderror --}}
            </div>
        </div>
        <button class="login-button" type="submit">ログインする</button>
        <a class="link-auth" href="/register">会員登録はこちら</a>
    </form>
</main>

@endsection