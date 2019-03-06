@extends('profile.layout', ['title' => 'افزودن سایز جدید'])
@section('profile-content')
    @component('components.form',[
        'action' => route('profile.sizes.store'),
        'method' => 'POST'
    ])

        @component('components.form.text', [
            'label' => 'نام',
            'name' => 'name',
            'half' => true,
            'value' => old('name')
        ])
        @endcomponent

        @component('components.form.text', [
            'label' => 'اندازه',
            'name' => 'size',
            'half' => true,
            'value' => old('size')
        ])
        @endcomponent

        @component('components.form.field')
            @component('components.form.button',[
                'label' => 'ایجاد'
            ])
            @endcomponent
        @endcomponent
    @endcomponent
    
@endsection