کاربر محترم {{ $user->fullname }}

برای فعال شدن حساب کاربری خود روی لینک زیر کلیک کنید.

@if(count(explode("_", $user->activation_token)) > 1)
    {{ route('api.auth.activate', ['token' => explode("_", $user->activation_token)[1]]) }}
@else
    {{ route('api.auth.activate', ['token' => $user->activation_token]) }}
@endif    