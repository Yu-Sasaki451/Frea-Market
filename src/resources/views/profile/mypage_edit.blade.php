@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/mypage_edit.css')}}">
<link rel="stylesheet" href="{{ asset('css/validate.css') }}">
@endsection

@section('content')
<div class="mypage">
    <form class="mypage-form" action="/mypage/profile" method="post" enctype="multipart/form-data">
        @csrf
        <h1 class="mypage-form__header">プロフィール設定</h1>
        <div class="mypage-form__image">
            <div class="mypage-form__image-row">
                <div class="image-preview" id="imagePreview">
                @if(!empty($profile->image)) <img src="{{ asset('storage/'.$profile->image) }}" alt=""> @endif
                </div>
                <div class="image-action">
                    <input class="image-input" type="file" name="image" id="image-input" accept="image/*">
                    <label class="image-button" for="image-input">画像を選択する</label>
                    <div class="validate-error">
                        @error('image','profile')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <label class="mypage-form__label" for="">ユーザー名</label>
        <input class="mypage-form__input" type="text" name="name" value="{{ old('name', $profile->name ?? '') }}">
        <div class="validate-error">
                @error('name','profile')
                {{ $message }}
                @enderror
        </div>

        <label class="mypage-form__label" for="">郵便番号</label>
        <input class="mypage-form__input" type="text" name="post_code" value="{{ old('post_code', $profile->post_code ?? '') }}">
        <div class="validate-error">
                @error('post_code','profile')
                {{ $message }}
                @enderror
        </div>

        <label class="mypage-form__label" for="">住所</label>
        <input class="mypage-form__input" type="text" name="address" value="{{ old('address', $profile->address ?? '') }}">
        <div class="validate-error">
                @error('address','profile')
                {{ $message }}
                @enderror
        </div>

        <label class="mypage-form__label" for="">建物名</label>
        <input class="mypage-form__input" type="text" name="building" value="{{ old('building', $profile->building ?? '') }}">

        <button class="mypage-form__button" type="submit">更新する</button>
    </form>
</div>
<script src="{{ asset('js/image_preview.js') }}?v=1"></script>
@endsection
