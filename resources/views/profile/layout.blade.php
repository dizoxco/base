@extends('layout', ['profile_mode' => true, 'title' => $title ?? 'عنوان بده'])
@section('content')
    <div id="profile-layout">
        <div class="profile-nav fixed h-full" style="top:64px">
            <div class="side__loged-user text-left -mr-16 bg-grey-darker rounded-l-full flex items-center justify-end ml-12 mt-4">
                <a href="/profile" class="text-white bg-grey-dark rounded-full py-2 px-5 pl-12 -ml-6 text-sm">پروفایل  {{auth()->user()->name}}</a>
                <img class="w-24 h-24 rounded-full border-8 border-solid border-grey-darker " src="{{auth()->user()->getFirstMedia('avatar') ? auth()->user()->getFirstMedia('avatar')->getUrl() : '/images/avatar.jpg'}}" alt="">
            </div>
            <ul class="mdc-list profile-mdc-list">
                <a href="{{ route('profile.wishlist.index') }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">favorite_border</span>
                        <span class="mdc-list-item__text">لیست علاقه مندی ها</span>
                    </li>
                </a>
                <a href="{{ route('profile.addresses.index') }}" class="block">
                    <li class="mdc-list-item mdc-ripple mdc-list-item--activated">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">place</span>
                        <span class="mdc-list-item__text">آدرس ها</span>
                    </li>
                </a>
                <a href="{{ route('profile.orders.index') }}" class="block">
                    <li class="mdc-list-item mdc-ripple">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">attach_money</span>
                        <span class="mdc-list-item__text">سفارشات</span>
                    </li>
                </a>
                <a href="{{ route('profile.chats.index') }}">
                    <li class="mdc-list-item mdc-ripple">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">chat</span>
                        <span class="mdc-list-item__text">چت ها</span>
                    </li>
                </a>
                <a href="{{ route('profile.tickets.index') }}">
                    <li class="mdc-list-item mdc-ripple">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">chat_bubble_outline</span>
                        <span class="mdc-list-item__text">تیکت ها</span>
                    </li>
                </a>
                <a href="{{ route('profile.edit') }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">people</span>
                        <span class="mdc-list-item__text">ویرایش پروفایل</span>
                    </li>
                </a>
                <a href="{{ route('profile.businesses.create') }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">people</span>
                        <span class="mdc-list-item__text">افزودن کسب و کار خود</span>
                    </li>
                </a>
                <a href="{{ route('logout') }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">power_settings_new</span>
                        <span class="mdc-list-item__text">خروج</span>
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
            <div class="bg-white -mt-8 rounded-t-lg overflow-hidden @if($fit ?? false) p-0 @else p-12 @endif">
                @yield('profile-content')
            </div>
        </div>
    </div>
@endsection