@extends('layout')
@section('content')
    <div class="flex flex-wrap container">
        <div class="w-1/4 pl-4">
            <div class="relative rounded-lg bg-white shadow-lg pt-2 pb-4 px-4 mb-4">
                    <p>
                        <a href="{{ route('profile.credentials.edit') }}">
                            تغییر رمز عبور
                        </a>
                    </p>
                    <a href="{{ route('web.authlogout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logoutـform').submit();">
                        خروج
                    </a>

                    <form id="logoutـform" action="{{ route('web.authlogout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            <div class="relative rounded-lg bg-white shadow-lg pt-2 pb-4 px-4 mb-4">
                <a id="orders_link" href="{{ route('profile.orders') }}">
                    همه سفارش ها
                </a>
            </div>
            <div class="relative rounded-lg bg-white shadow-lg pt-2 pb-4 px-4 mb-4">
                <a id="orders_link" href="{{ route('profile.wishlist.index') }}">
                    لیست عاقه مندی ها
                </a>
            </div>
        </div>
        <div class="w-3/4 pr-4">
            <div class="relative rounded-lg bg-white shadow-lg py-4 mb-2">
                <span class="absoulute text-grey-light pin-r mx-4"><i class="material-icons" style="transform:scaleX(-1)">sort</i></span>
                <span class="absolute text-grey-light pin-l mx-4">
                    <i class="material-icons ">view_module</i>
                    <i class="material-icons">toc</i>
                </span>
            </div>
            <div class="flex flex-wrap">
                    <div class="w-1/3 px-2 py-2">
                        {{--@component('web.businesses.card', ['business' => $user])@endcomponent--}}
                    </div>
            </div>
        </div>
    </div>
@endsection