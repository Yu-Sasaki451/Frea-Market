@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection



@section('content')
<div class="tab">
    <div class="tablist" role="tablist">
        <button
            class="tab-button"
            role="tab"
            id="tab-recommend"
            aria-controls="panel-recommend"
            aria-selected="{{ $activeTab === 'recommend' ? 'true' : 'false' }}"
            tabindex="{{ $activeTab === 'recommend' ? '0' : '-1' }}"
        >
            おすすめ
        </button>
        <button class="tab-button" role="tab" id="tab-mylist" aria-controls="panel-mylist" aria-selected="{{ $activeTab === 'mylist' ? 'true' : 'false' }}" tabindex="{{ $activeTab === 'mylist' ? '0' : '-1' }}">
            マイリスト
        </button>
    </div>
    <div class="tab-panel" role="tabpanel" id="panel-recommend" aria-labelledby="tab-recommend" tabindex="0" {{ $activeTab === 'recommend' ? '' : 'hidden' }}>
        @foreach($products as $product)
        <div class="product-card">
            <a href="/item/{{ $product->id }}">
                <div class="product-img--square">
                    <img class="product-img" src="{{ asset('storage/' . $product->image) }}" alt="">
                </div>
            </a>
            <p class="product-label">
                {{ $product->name }}
                <span class="sold-label">
                @if(in_array($product->id, $purchasedProducts))
                    Sold
                @endif
                </span>
            </p>
        </div>
        @endforeach
    </div>
    <div class="tab-panel" role="tabpanel" id="panel-mylist" aria-labelledby="tab-mylist" tabindex="0" {{ $activeTab === 'mylist' ? '' : 'hidden' }}>
        @foreach($likedProducts as $likedProduct)
        <div class="product-card">
            <a href="/item/{{ $likedProduct->id }}">
                <div class="product-img--square">
                    <img class="product-img" src="{{ asset('storage/' . $likedProduct->image) }}" alt="">
                </div>
            </a>
            <p class="product-label">
                {{ $likedProduct->name }}
                <span class="sold-label">
                    @if(in_array($likedProduct->id, $purchasedProducts))
                        Sold
                    @endif
                </span>
            </p>
        </div>
        @endforeach
    </div>
</div>
<script src="{{ asset('js/tab.js') }}"></script>
@endsection
