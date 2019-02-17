کاربر محترم {{ $user->fullname }}

برای فعال شدن حساب کاربری خود روی لینک زیر کلیک کنید.

{{ route('api.auth.activate', ['token' => explode("_", $user->activation_token)[1]]) }}