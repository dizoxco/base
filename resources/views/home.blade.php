@extends('layout')
@section('content')
    <div class="swiper simple -mx-4 overflow-hidden" column="3" >
        <div class="swiper-wrapper">
            @foreach ($posts as $post)
                <div class="swiper-slide">
                    <div class="p-4">
                        {{$post->title}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>    
@endsection