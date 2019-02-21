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

        @component('components.form.field')
        @endcomponent

        @component('components.form.text', [
            'label' => 'ایمیل',
            'name' => 'email',
            'half' => true,
            'value' => old('email', Auth::user()->email)
        ])
        @endcomponent

        @if(Auth::user()->email !== null && Auth::user()->hasNotVerified('email') && !session('token'))
            <a href="{{ route('profile.verification.email.send') }}">
                Email Verification
            </a>
        @endif

        @component('components.form.field')
        @endcomponent

        @component('components.form.text', [
            'label' => 'تلفن همراه',
            'name' => 'mobile',
            'half' => true,
            'value' => old('mobile', Auth::user()->mobile)
        ])
        @endcomponent

        @if(Auth::user()->mobile && Auth::user()->hasNotVerified('mobile') && !session('token'))
            <a href="{{ route('profile.verification.mobile.send') }}">
                Mobile Verification
            </a>
        @endif

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
            'name' => 'password_confirmation',
            'half' => true,
            'type' => 'password'
        ])
        @endcomponent

        @component('components.form.field')
            @component('components.form.button',[
                'label' => 'به روز رسانی'
            ])
            @endcomponent
        @endcomponent
    @endcomponent
@endsection
