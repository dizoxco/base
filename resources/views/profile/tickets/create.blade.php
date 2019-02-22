@extends('profile.layout')
@section('profile-content')
    @component('components.form',[
        'action' => route('profile.tickets.store'),
        'method' => 'POST'
    ])
        @component('components.form.text', [
            'label' => 'عنوان',
            'name' => 'title',
            'half' => true,
            'value' => old('name')
        ])
        @endcomponent

        @component('components.form.select',[
            'label' => 'شهر',
            'name' => 'city_id',
            'half' => true,
            'value' => 1,
            'options' => enum('ticket.category')
        ])
        @endcomponent

        @component('components.form.textarea', [
            'label' => 'متن پیام',
            'name' => 'body',
            'value' => old('body')
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