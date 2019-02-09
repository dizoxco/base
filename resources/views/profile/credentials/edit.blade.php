@extends('profile.layout')
@section('profile-content')
    @component('components.form',[
        'methos' => 'PUT',
        'action' => route('profile.credentials.update'),
    ])
        @component('components.form.text',[
            'label' => 'نام',
            'id' => 'email',
            'name' => 'email',
            'value' => $user->name,
        ])
        @endcomponent

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
            'half' => true,
        ])
        @endcomponent

        @component('components.form.text',[
            'label' => 'تکرار رمز عبور',
            'id' => 'password_confirmation',
            'name' => 'password_confirmation',
            'type' => 'password',
            'half' =>true
        ])
        @endcomponent

        @component('components.form.field')
            @component('components.form.button',[
                'label' => 'به روزرسانی',
                'type' => 'raised',
                'name' => 'submit',
            ])
            @endcomponent
        @endcomponent
    @endcomponent
@endsection
        
        

        
