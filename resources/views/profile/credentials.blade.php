<form action="{{ route('profile.credentials.update') }}" method="post">
    {{ csrf_field() }}
    <div>
        <label for="email">
            ایمیل
        </label>
        <input id="email" type="text" name="email" value="{{ $user->email }}">
    </div>
    <div>
        <label for="old_password">
            رمز عبور قبلی
        </label>
        <input id="old_password" type="password" name="old_password" >
    </div>
    <div>
        <label for="password">
            رمز عبور
        </label>
        <input id="password" type="password" name="password" >
    </div>
    <div>
        <label for="password_confirmation">
            رمز عبور
        </label>
        <input  id="password_confirmation" type="password" name="password_confirmation" >
    </div>
    <div>
        <button type="submit"> به روز رسانی </button>
    </div>
</form>