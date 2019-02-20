@extends('profile.layout', ['title' => 'افزودن کسب و کار'])
@section('profile-content')
    @component('components.form',[
        'action' => route('profile.businesses.store'),
        'method' => 'POST'
    ])

        @component('components.form.text', [
            'label' => 'نام تجاری',
            'name' => 'brand',
            'half' => true,
            'value' => old('brand')
        ])
        @endcomponent

        @component('components.form.text', [
            'label' => 'شهر',
            'name' => 'city_id',
            'half' => true,
            'value' => old('city_id')
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
