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
    







@component('components.dialog',[
    'id' => 'fff',
    'title' => 'sdfdf'
])
    @component('components.form.field')
        @component('components.form.select', [
            'label' => 'افزودن کسب و کار',
            'options' => [
                'aa' => 'aaa',
                'bb' => 'bbb',
                'cc' => 'ccc',
                'dd' => 'ddd',
            ],
        ])
        @endcomponent
    @endcomponent
@endcomponent


<button type="button" class="mdc-button" dialog="fff">
        <span class="mdc-button__label">Cancel</span>
      </button>


@endsection