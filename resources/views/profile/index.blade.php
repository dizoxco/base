@extends('profile.layout')
@section('profile-content')
    <div class="flex flex-wrap">
        <h1>پروفایل</h1>
    </div>
    <br><br>
    <a href="{{route('profile.businesses.create')}}">
        @component('components.form.button', [
            'label' => 'افزودن کسب و کار'
        ])
        @endcomponent
    </a>
    <br><br>
    









@component('components.form.button',[
    'label' => 'dfdf',
    'dialog' => 'fff'
])
    
@endcomponent

@endsection