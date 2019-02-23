<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="{{ env('GOOGLE_CLIENT_ID') }}">
    <meta name="X-CSRF-Token" content="{{ csrf_token() }}">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="theme-color" content="#002f6c" />
    <title>مدلا - @yield('title')</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body class="@isset($profile_mode) profile @endisset" dir="rtl">
@component('components.nav.simple') @endcomponent

<div id="content" class="min-h-screen/7">
    @yield('content')
</div>

{{-- @component('components.links', ['nav' => 'main'])@endcomponent --}}
@if(!isset($profile_mode))
    <div class="footer bg-white">
        @component('components.footer') @endcomponent
    </div>
@endif
<script src="/js/app.js"></script>
@yield('script')
</body>
</html>