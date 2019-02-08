@extends('layout')
@section('content')
<div class="container medium">
    @component('components.form', [
        'action' => route('profile.addresses.store'),
        'method' => 'POST'
    ])
        @component('components.form.text',[
            'label' => 'dd',
            'name' => 'name'
        ])
        @endcomponent
        @component('components.form.text',[
            'label' => 'dd',
            'name' => 'name'
        ])
        @endcomponent
        @component('components.form.text',[
            'label' => 'dd',
            'name' => 'name'
        ])
        @endcomponent
        @component('components.form.text',[
            'label' => 'dd',
            'name' => 'name'
        ])
        @endcomponent
        
    @endcomponent
</div>
@endsection
