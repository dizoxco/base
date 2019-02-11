@extends('layout', ['profile_mode' => true, 'title' => $title ?? 'عنوان بده'])
@section('content')
    <div id="profile-layout">
        <div class="profile-nav fixed h-full">
            <br>
            <br>
            <br>
            <ul class="mdc-list">
                <a href="/profile/edit" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">people</span>
                        <span class="mdc-list-item__text">محصولات</span>
                    </li>
                </a>
                <a href="{{ route('profile.businesses.index') }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">business</span>
                        <span class="mdc-list-item__text">کسب و کارهای شما</span>
                    </li>
                </a>
                <a href="/profile/orders" class="block">
                    <li class="mdc-list-item mdc-ripple">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">place</span>
                        <span class="mdc-list-item__text">سفارسات</span>
                    </li>
                </a>
                <a href="/profile/chats">
                    <li class="mdc-list-item mdc-ripple">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">chat</span>
                        <span class="mdc-list-item__text">چت ها</span>
                    </li>
                </a>
                <a href="/profile/edit" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">people</span>
                        <span class="mdc-list-item__text">خروج</span>
                    </li>
                </a>
            </ul>
        </div>
        <div class="profile-content">
            <div class="bg-blue">
                <div class="container">
                    <br>
                    <h1 class="text-white">{{$title ?? 'عنوان بده'}}</h1>
                    <br><br>
                </div>
            </div>
            <div class="bg-white p-8 -mt-8 rounded-lg">
                @yield('profile-content')
            </div>
        </div>
    </div>
@endsection