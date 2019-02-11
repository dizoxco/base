@extends('profile.layout', ['title' => 'ویرایش پروفایل'])
@section('profile-content')
    @component('components.form',[
        'action' => route('profile.update'),
        'method' => 'PUT'
    ])

        @component('components.form.text', [
            'label' => 'نام',
            'name' => 'name',
            'half' => true,
            'value' => old('name', Auth::user()->name)
        ])
        @endcomponent

        @component('components.form.text', [
            'label' => 'ایمیل',
            'name' => 'email',
            'half' => true,
            'value' => old('email', Auth::user()->email)
        ])
        @endcomponent

        @component('components.form.text', [
            'label' => 'رمز عبور قدیم',
            'name' => 'old_password',
            'type' => 'password'
        ])
        @endcomponent

        @component('components.form.text', [
            'label' => 'رمز عبور',
            'name' => 'password',
            'half' => true,
            'type' => 'password'
        ])
        @endcomponent
        
        @component('components.form.text', [
            'label' => 'تکرار رمز عبور',
            'name' => 'password_repeat',
            'half' => true,
            'type' => 'password'
        ])
        @endcomponent

        @component('components.form.field')
            @component('components.form.button',[
                'label' => 'ذخیره'
            ])
            @endcomponent
        @endcomponent
    @endcomponent
@endsection
