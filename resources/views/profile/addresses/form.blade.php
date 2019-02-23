@extends('profile.layout')
@section('profile-content')
    @component('components.form',[
        'action' => isset($address)? route('profile.addresses.update', $address): 
                        route('profile.addresses.store'),
        'method' => isset($address)? 'PUT': 'POST'
    ])
        @component('components.form.text', [
            'label' => 'گیرنده',
            'name' => 'receiver',
            'half' => true,
            'value' => old('receiver', $address->receiver ?? '')
        ])
        @endcomponent

        @component('components.form.text', [
            'label' => 'موبایل',
            'name' => 'mobile',
            'half' => true,
            'value' => old('mobile', $address->mobile ?? '')
        ])
        @endcomponent

        @component('components.form.select',[
            'label' => 'شهر',
            'name' => 'city_id',
            'value' => old('city_id', $address->city_id ?? ''),
            'half' => true,
            'options' => cities()->pluck('name', 'id')
        ])
        @endcomponent
        
        @component('components.form.text', [
            'label' => 'کد پستی',
            'name' => 'postal_code',
            'value' => 1,
            'half' => true,
            'value' => old('postal_code', $address->postal_code ?? '')
        ])
        @endcomponent

        @component('components.form.textarea', [
            'label' => 'آدرس',
            'name' => 'address',
            'value' => old('address', $address->address ?? '')
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
