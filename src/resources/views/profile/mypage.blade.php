@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/mypage.css')}}">
@endsection

@section('content')

<div class="mypage-form__image">
            <div class="image-preview" id="imagePreview">
            @if(!empty($profile->image)) <img src="{{ asset('storage/'.$profile->image) }}" alt=""> @endif
            </div>
            <p>{{ $profile->name }}</p>
        </div>

@endsection