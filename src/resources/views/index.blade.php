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
                <img class="product-img" src="{{ asset('storage/' . $product->image) }}" alt="">
            </a>
            <p class="product-label" for="">{{ $product->name }}</p>
        </div>
        @endforeach
    </div>
    <div class="tab-panel" role="tabpanel" id="panel-mylist" aria-labelledby="tab-mylist" tabindex="0" hidden>
        マイリスト表示
    </div>
</div>
<script src="{{ asset('js/tab.js') }}"></script>
@endsection