@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase-address.css')}}">
@endsection

@section('content')
<div class="purchase-address">
    <form class="purchase-address-form" action="/purchase/address/{{$product->id}}" method="post">
        @csrf
        <h2 class="purchase-address-form__header">住所の変更</h2>

        <label class="purchase-address-form__label" for="">郵便番号</label>
        <input class="purchase-address-form__input" type="text" name="post_code">

        <label class="purchase-address-form__label" for="">住所</label>
        <input class="purchase-address-form__input" type="text" name="address">

        <label class="purchase-address-form__label" for="">建物名</label>
        <input class="purchase-address-form__input" type="text" name="building">

        <button class="purchase-address-form__button" type="submit">更新する</button>
    </form>
</div>
@endsection