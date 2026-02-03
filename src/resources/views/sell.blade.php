@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<form class="sell" action="" method="post" enctype="multipart/form-data">
    @csrf
    <div class="sell-heading">
        <h2 class="sell-heading__title">商品の出品</h2>
    </div>
    <section class="sell-section__image">
        <label class="sell-label" for="">商品画像</label>
        <div class="sell-image__box">

        </div>
    </section>

    <section class="sell-section__detail">
        <h3 class="sell-title">商品の詳細</h3>
        <div class="sell-category">
            <label class="sell-label" for="">カテゴリー</label>
            ここはforeach
        </div>
        <div class="sell-condition">
            <label class="sell-label" for="">商品の状態</label>
            <select class="sell-select" name="" id="">
                <option value=""></option>
            </select>
        </div>
    </section>

    <section class="sell-section__description">
        <label class="sell-label" for="">商品名</label>
        <input class="sell-input" type="text">
        
        <label class="sell-label" for="">ブランド名</label>
        <input class="sell-input" type="text">

        <label class="sell-label" for="">商品の説明</label>
        <textarea class="sell-textarea" name="" id="" cols="30" rows="10"></textarea>

        <label class="sell-label" for="">販売価格</label>
        <input class="sell-input" type="text">
    </section>
</form>

@endsection