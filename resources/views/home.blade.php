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
                        @component('components.post.card', ['post' => $post, 'class' => 'swiper-slide' ])@endcomponent
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="swiper simple overflow-hidden" column="5" >
        <div class="swiper-wrapper">
            @foreach ($posts as $post)
                <div class="swiper-slide">
                    @component('components.post.card', ['post' => $post, 'class' => 'swiper-slide' ])@endcomponent
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex flex-wrap -mx-2">
        @foreach (range(1,3) as $id)
            <div class="w-1/3 p-2">
                @component('components.post.card', ['post' => $posts[$id]])@endcomponent
            </div>
        @endforeach
    </div>

@endsection