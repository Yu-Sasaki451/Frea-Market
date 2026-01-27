@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection


@section('content')
<main class="register">
    <form class="register-form" action="/register" method="post">
        @csrf
        <div class="register-form__inner">
            <h2 class="register-form__header">会員登録</h2>
            <label class="register-label">ユーザー名</label>
            <input class="register-input" type="text" name="name" value="{{ old('name') }}">
            <div class="form-error">
                        @error('name')
                        {{ $message }}
                        @enderror
            </div>

            <label class="register-label">メールアドレス</label>
            <input class="register-input" type="text" name="email" value="{{ old('email') }}">
            <div class="form-error">
                        @error('email')
                        {{ $message }}
                        @enderror
            </div>

            <label class="register-label">パスワード</label>
            <input class="register-input" type="password" name="password">
            <div class="form-error">
                        @error('password')
                        {{ $message }}
                        @enderror
            </div>

            <label class="register-label">確認用パスワード</label>
            <input class="register-input" type="password" name="password_confirmation">
            <div class="form-error">
                        @error('password')
                        {{ $message }}
                        @enderror
            </div>
        </div>
        <button class="register-button" type="submit">登録する</button>
        <a class="link-auth" href="/login">ログインはこちら</a>
    </form>
</main>

@endsection