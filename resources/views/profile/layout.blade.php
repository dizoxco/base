@extends('layout', ['mode' => 'profile'])
@section('content')
    <div class="container flex flex-wrap">
        <div class="w-1/3">
            <div class="bg-white">
                <ul>
                    <li>asdsd</li>
                    <li>asdsd</li>
                    <li>asdsd</li>
                    <li>asdsd</li>
                </ul>
            </div>
        </div>
        <div class="w-2/3">
            @yield('profile-content')
        </div>
    </div>
@endsection