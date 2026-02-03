@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection


@section('content')
<div class="product-detail">
    <div class="product-card">
        <img class="product-img" src="{{ asset('storage/' . $product->image) }}" alt="">
    </div>
    <div class="product-content">
        <div class="product-summary">
            <h2 class="product__title">{{ $product->name }}</h2>
            <p class="product-brand">{{ $product->brand }}</p>
            <p class="product-price">¥{{ number_format($product->price) }} (税込)</p>
            <div class="product-actions">
                <form action="/item/{{ $product->id }}" method="post">
                    @csrf
                    <button class="product-action--like {{ $liked ? 'is-liked' : ''}}" type="submit">
                        <span class="icon"> {!! file_get_contents(public_path('svg/like.svg')) !!}</span>
                        <span class="count">{{ $product->likes_count }}</span>
                    </button>
                </form>

                <div class="product-comment">
                    <span class="icon">{!! file_get_contents(public_path('svg/comment.svg')) !!}</span>
                    <span class="count">{{ $product->comments_count }}</span>
                </div>
            </div>
            <a class="link-purchase" href="/purchase/{{ $product->id }}">購入手続きへ</a>
        </div>

        <div class="product-description">
            <h3 class="product-description__title">商品説明</h3>
            <p class="product-description__text">{{ $product->description }}</p>
        </div>

        <div class="product-info">
            <h3 class="product-info__title">商品情報</h3>
            <dl class="product-info__list">
                <div class="product-info__category">
                    <dt class="product-info__term">カテゴリー</dt>
                    <dd class="category-description">
                        @foreach($product->categories as $category)
                            <span>{{ $category->name }}</span>
                        @endforeach
                    </dd>
                </div>
                <div class="product-info__condition">
                    <dt class="product-info__term">商品の状態</dt>
                    <dd class="condition-description">{{ $product->condition->name }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>



@endsection