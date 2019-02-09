<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="theme-color" content="#002f6c" />
    <title>مدلا - @yield('title')</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
    <body class="portal" dir="rtl">
        @forelse($errors->all() as $error)
            <p>{{ $error }}</p>
        @empty
            there is no errors
        @endforelse
        <form action="{{ route('profile.credentials.update') }}" method="post">
            {{ csrf_field() }}
        @component('components.form.text',[
            'label' => 'ایمیل',
            'id' => 'email',
            'name' => 'email',
            'value' => $user->email,
        ])
        @endcomponent

        @component('components.form.text',[
            'label' => 'رمز عبور قبلی',
            'id' => 'old_password',
            'name' => 'old_password',
            'type' => 'password',
        ])
        @endcomponent

        @component('components.form.text',[
            'label' => 'رمز عبور',
            'id' => 'password',
            'name' => 'password',
            'type' => 'password',
        ])
        @endcomponent

        @component('components.form.text',[
            'label' => 'رمز عبور',
            'id' => 'password_confirmation',
            'name' => 'password_confirmation',
            'type' => 'password',
        ])
        @endcomponent

        @component('components.form.button',[
            'label' => 'به روزرسانی',
            'type' => 'raised',
            'name' => 'submit',
        ])
        @endcomponent
    </form>
    </body>
</html>