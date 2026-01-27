@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/mypage_edit.css')}}">
@endsection

@section('content')
<div class="mypage">
    <form class="mypage-form" action="/mypage/profile" method="post" enctype="multipart/form-data">
        @csrf
        <h2 class="mypage-form__header">プロフィール設定</h2>
        <div class="mypage-form__image">
            <div class="image-preview" id="imagePreview">
            @if(!empty($user->image_path)) <img src="{{ asset('storage/'.$user->image_path) }}" alt=""> @endif
            </div>
            <input class="image-input" type="file" name="image" id="image-input" accept="image/*"> <label class="image-button" for="image-input">画像を選択する</label>
        </div>
        <label class="mypage-form__label" for="">ユーザー名</label>
        <input class="mypage-form__input" type="text">

        <label class="mypage-form__label" for="">郵便番号</label>
        <input class="mypage-form__input" type="text">

        <label class="mypage-form__label" for="">住所</label>
        <input class="mypage-form__input" type="text">

        <label class="mypage-form__label" for="">建物名</label>
        <input class="mypage-form__input" type="text">

        <button class="mypage-form__button" type="submit">更新する</button>
    </form>
</div>

@endsection