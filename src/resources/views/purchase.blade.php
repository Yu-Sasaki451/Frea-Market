@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<form class="purchase" action="/purchase/{{ $product->id }}" method="post">
    @csrf
    <div class="purchase-content">
        <div class="purchase-content__left">
            <div class="purchase-summary">
                <div class="purchase-summary__left">
                    <img class="product-img" src="{{ asset('storage/' . $product->image) }}" alt="">
                </div>
                <div class="purchase-summary__right">
                    <p class="purchase-summary__name">{{ $product->name }}</p>
                    <p class="purchase-summary__price">¥{{ number_format($product->price) }} (税込)</p>
                </div>
            </div>
            <div class="purchase-payment">
                <label class="purchase-label">支払い方法</label>
                <select class="payment-select" name="payment" id="paymentSelect">
                    <option value="" selected disabled hidden>選択してください</option>
                    <option value="convenience">コンビニ支払い</option>
                    <option value="card">カード支払い</option>
                </select>
            </div>
            <div class="purchase-address">
                <div class="address-header">
                    <label class="purchase-label">配送先</label>
                    <a class="link-address" href="/purchase/address/{{ $product->id }}">変更する</a>
                </div>
                <div class="address-content">
                    <p class="post_code">〒{{ $profile->post_code }}</p>
                    <p class="address">{{ $profile->address }} {{ $profile->building }}</p>
                </div>
            </div>
        </div>
        <div class="purchase-content__right">
            <dl class="purchase-info">
                <div class="info-row">
                    <div class="info-row--top">
                        <dt class="info-title">商品代金</dt>
                        <dd class="info-value">¥{{ number_format($product->price) }}</dd>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-row--bottom">
                        <dt class="info-title">支払い方法</dt>
                        <dd class="info-value" id="paymentPreview"></dd>
                    </div>
                </div>
            </dl>
            <button class="purchase-button" type="submit">購入する</button>
        </div>
    </div>
</form>
<script src="{{ asset('js/payment.js') }}"></script>
@endsection