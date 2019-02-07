@extends('layout')
@section('content')
    <ul>
        <li>
            <a href="{{ route('web.authlogout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('web.authlogout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
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