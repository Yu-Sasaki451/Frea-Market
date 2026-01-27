@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header-utility')
<div class="header-utility--center">
    <input type="text" placeholder="何かお探しですか？">
</div>
<div class="header-utility--right">
    <form action="/logout" method="post">
        @csrf
        <button class="logout__button">ログアウト</button>
    </form>
    <a href="/mypage">マイページ</a>
    <a href="">出品</a>
</div>
@endsection

@section('content')

@endsection