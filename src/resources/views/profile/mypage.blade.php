@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/mypage.css')}}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage-header">
        <div class="mypage-header--left">
            <div class="image-preview" id="imagePreview">
                @if(!empty($profile->image)) <img src="{{ asset('storage/'.$profile->image) }}" alt=""> @endif
            </div>
            <p class="profile-name">{{ $profile->name }}</p>
        </div>
        <div class="mypage-header--right">
            <a class="link-edit" href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>
    <div class="mypage-tab">
        <div class="mypage-tablist" role="tablist">
            <button class="mypage-tab__button" role="tab" id="tab-sell" aria-controls="panel-sell" aria-selected="true" tabindex="0">
                出品した商品
            </button>
            <button class="mypage-tab__button" role="tab" id="tab-purchase" aria-controls="panel-purchase" aria-selected="false" tabindex="-1">
                購入した商品
            </button>
        </div>
        <div class="mypage-tab__panel" role="tabpanel" id="panel-sell" aria-labelledby="tab-sell" tabindex="0">
            @foreach($products as $product)
            <div class="product-card">
                <a href="/item/{{ $product->id }}">
                    <div class="product-img--square">
                        <img class="product-img" src="{{ asset('storage/' . $product->image) }}" alt="">
                    </div>
                </a>
                <p class="product-label">{{ $product->name }}</p>
            </div>
            @endforeach
        </div>

        <div class="mypage-tab__panel" role="tabpanel" id="panel-purchase" aria-labelledby="tab-purchase" tabindex="0" hidden>
            @foreach($purchases as $purchase)
            <div class="product-card">
                <a href="/item/{{ $purchase->product->id }}">
                    <div class="product-img--square">
                        <img class="product-img" src="{{ asset('storage/' . $purchase->product->image) }}" alt="">
                    </div>
                </a>
                <p class="product-label">{{ $purchase->product->name }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script src="{{ asset('js/tab.js') }}"></script>
@endsection