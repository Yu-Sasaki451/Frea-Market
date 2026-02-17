@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
<link rel="stylesheet" href="{{ asset('css/validate.css') }}">
@endsection

@section('content')
<form class="sell" action="/sell" method="post" enctype="multipart/form-data">
    @csrf
    <div class="sell-heading">
        <h1 class="sell-heading__title">商品の出品</h1>
    </div>
    <section class="sell-section__image">
        <label class="sell-label" for="">商品画像</label>
        <div class="sell-image__box">
            <input
            class="sell-image__input"
            type="file"
            name="image"
            id="imageInput"
            accept="image/*">

            <label class="sell-image__button" for="imageInput">画像を選択する</label>
            <div class="sell-image__preview" id="imagePreview"></div>
        </div>
        <div class="validate-error">
                @error('image','exhibition')
                {{ $message }}
                @enderror
        </div>
    </section>

    <section class="sell-section__detail">
        <h2 class="sell-title">商品の詳細</h2>
        <div class="sell-category">
            <label class="sell-label" for="">カテゴリー</label>
            <div class="category-list">
                @foreach($categories as $category)
                    <input
                    type="checkbox"
                    name="categories[]"
                    id="cat-{{ $category->id}}" value="{{ $category->id}}">
                    <label for="cat-{{ $category->id}}">{{ $category->name }}</label>
                @endforeach
            </div>
            <div class="validate-error">
                @error('categories','exhibition')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="sell-condition">
            <label class="sell-label" for="">商品の状態</label>
            <select class="sell-select" name="condition_id">
                <option value="" selected disabled hidden>選択してください</option>
                @foreach($conditions as $condition)
                <option class="sell-option" value="{{ $condition->id}}">{{ $condition->name }}</option>
                @endforeach
            </select>
            <div class="validate-error">
                @error('condition_id','exhibition')
                {{ $message }}
                @enderror
            </div>
        </div>
    </section>

    <section class="sell-section__description">
        <h2 class="sell-title">商品名と説明</h2>
        <label class="sell-label" for="name">商品名</label>
        <input class="sell-input" type="text" id="name" name="name" value="{{ old('name') }}">
        <div class="validate-error">
                @error('name','exhibition')
                {{ $message }}
                @enderror
        </div>

        <label class="sell-label" for="brand">ブランド名</label>
        <input class="sell-input" type="text" id="brand" name="brand" value="{{ old('brand') }}">
        <div class="validate-error"></div>

        <label class="sell-label" for="description">商品の説明</label>
        <textarea class="sell-textarea" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
        <div class="validate-error">
                @error('description','exhibition')
                {{ $message }}
                @enderror
        </div>

        <label class="sell-label" for="price">販売価格</label>
        <input class="sell-input" type="text" id="price" name="price" placeholder="¥" value="{{ old('price') }}">
        <div class="validate-error">
                @error('price','exhibition')
                {{ $message }}
                @enderror
        </div>
    </section>
    <button class="sell-button" type="submit">出品する</button>
</form>
<script src="{{ asset('js/image_preview.js') }}"></script>
@endsection
