@extends('layout', ['profile_mode' => true, 'title' => $title ?? 'عنوان بده'])
@section('content')
    <div id="profile-layout">
        <div class="profile-nav fixed h-full ">
            <br>
            <br>
            <br>
            <ul class="mdc-list">
                @if(!auth()->user()->hasBusiness())
                <a href="{{ route('profile.businesses.create') }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">people</span>
                        <span class="mdc-list-item__text">ایجاد کسب و کار</span>
                    </li>
                </a>
                @endif
                <a href="{{ route('profile.wishlist.index') }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">people</span>
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
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">place</span>
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
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">chat</span>
                        <span class="mdc-list-item__text">تیکت ها</span>
                    </li>
                </a>
                <a href="{{ route('profile.edit') }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">people</span>
                        <span class="mdc-list-item__text">ویرایش پروفایل</span>
                    </li>
                </a>
                <a href="{{ route('logout') }}" class="block">
                    <li class="mdc-list-item mdc-ripple" tabindex="0">
                        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">people</span>
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