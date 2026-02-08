@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection


@section('content')
<main class="login">
    <form class="login-form" action="/login" method="post">
        @csrf
        <div class="login-form__inner">
            <h1 class="login-form__header">ログイン</h1>
            
            <label class="login-label">メールアドレス</label>
            <input class="login-input" type="text" name="email" value="{{ old('email') }}">
            <div class="form-error">
                        @error('email')
                        {{ $message }}
                        @enderror
            </div>

            <label class="login-label">パスワード</label>
            <input class="login-input" type="password" name="password">
            <div class="form-error">
                        @error('password')
                        {{ $message }}
                        @enderror
            </div>
        </div>
        <button class="login-button" type="submit">ログインする</button>
        <a class="link-auth" href="/register">会員登録はこちら</a>
    </form>
</main>

@endsection
