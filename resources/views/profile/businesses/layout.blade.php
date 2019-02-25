@extends('layout', ['profile_mode' => true, 'title' => $title ?? 'عنوان بده'])
@section('content')
    <div id="profile-layout">
        <div class="profile-nav fixed h-full">
            <br>
            <br>
            <br>
            <ul class="mdc-list">
                <a href="{{ route('profile.businesses.products.index',$business->slug) }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">people</span>
                        <span class="mdc-list-item__text">محصولات</span>
                    </li>
                </a>
                <a href="{{ route('profile.businesses.orders.index',$business->slug) }}" class="block">
                    <li class="mdc-list-item mdc-ripple">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">place</span>
                        <span class="mdc-list-item__text">سفارشات</span>
                    </li>
                </a>
                <a href="{{ route('profile.businesses.chats.index',$business->slug) }}">
                    <li class="mdc-list-item mdc-ripple">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">chat</span>
                        <span class="mdc-list-item__text">چت ها</span>
                    </li>
                </a>
            </ul>
        </div>
        <div class="profile-content">
            <div class="bg-grey-darker">
                <div class="flex items-center px-12 pt-6 pb-12 justify-between">
                    <h1 class="text-white title my-6">{{$title ?? 'عنوان بده'}}</h1>
                    <div>
                        @yield('profile-actions')
                    </div>
                </div>
            </div>
            <div class="bg-white -mt-8 rounded-t-lg overflow-hidden">
                @yield('profile-content')
            </div>
        </div>
    </div>
@endsection