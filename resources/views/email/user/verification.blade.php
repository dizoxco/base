کاربر محترم {{ $user->fullname }}

برای تایید ایمیل روی لینک زیر کلیک کنید

<a href="{{ route('profile.verification.email.check', ['token' => $token]) }}">
    Confirm
</a>