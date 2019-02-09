@extends('profile.layout')
@section('profile-content')
    @component('components.form',[
        'method' => 'POST',
        'action' => route('profile.info.update')
    ])
        @component('components.form.text',[
            'label' => 'نام',
            'name' => 'name',
            'value' => old('name', $user->name)
        ])
        @endcomponent
        @component('components.form.text',[
            'label' => 'ایمیل',
            'value' => old('name', $user->email)
        ])
        @endcomponent
        @component('components.form.field')
            @component('components.form.button',[
                'label' => 'ذخیره',
                'value' => old('name', $user->email)
            ])
            @endcomponent
        @endcomponent
        
    @endcomponent
@endsection