@extends('auth.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/index.css') }}">
@endsection

@section('header-utility')
<form action="/logout" method="post">
    @csrf
    <button class="logout__button">ログアウト</button>
</form>
@endsection

@section('content')

@endsection