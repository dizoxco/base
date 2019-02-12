@extends('layout')
@section('content')
    <div class="swiper simple -mx-4 overflow-hidden" column="3" >
        <div class="swiper-wrapper">
            @forelse ($posts as $post)
                <div class="swiper-slide">
                    <div class="p-4">
                        {{$post->title}}
                    </div>
                </div>
            @empty
                There is no posts yet!
            @endforelse
        </div>
    </div>    
@endsection