@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection



@section('content')
<div class="tab">
    <div class="tablist" role="tablist">
        <button class="tab-button" role="tab" id="tab-recommend" aria-controls="panel-recommend" aria-selected="true" tabindex="0">
            おすすめ
        </button>
        <button class="tab-button" role="tab" id="tab-mylist" aria-controls="panel-mylist" aria-selected="false" tabindex="-1">
            マイリスト
        </button>
    </div>
    <div class="tab-panel" role="tabpanel" id="panel-recommend" aria-labelledby="tab-recommend" tabindex="0">
    @foreach($products as $product)
    <div class="product-card">
        <a href="/item/{{ $product->id }}">
            <div class="product-img--square">
                <img class="product-img" src="{{ asset('storage/' . $product->image) }}" alt="">
            </div>
        </a>
        <p class="product-label">{{ $product->name }}</p>
        @if(in_array($product->id, $purchasedProducts))
            SOLD
        @endif
    </div>
    @endforeach
</div>
    <div class="tab-panel" role="tabpanel" id="panel-mylist" aria-labelledby="tab-mylist" tabindex="0" hidden>
        @foreach($likedProducts as $likedProduct)
        <div class="product-card">
            <a href="/item/{{ $likedProduct->id }}">
                <div class="product-img--square">
                    <img class="product-img" src="{{ asset('storage/' . $likedProduct->image) }}" alt="">
                </div>
            </a>
            <p class="product-label">{{ $likedProduct->name }}</p>
            @if(in_array($likedProduct->id, $purchasedProducts))
                SOLD
            @endif
        </div>
        @endforeach
    </div>
</div>
<script src="{{ asset('js/tab.js') }}"></script>
@endsection