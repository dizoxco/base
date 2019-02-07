<form action="{{ route('profile.info.update') }}" method="post">
    {{ csrf_field() }}
    <div>
        <label for="name">
            نام
        </label>
        <input id="name" type="text" name="name" value="{{ $user->name }}">
    </div>
    <div>
        <button type="submit"> به روز رسانی </button>
    </div>
</form>