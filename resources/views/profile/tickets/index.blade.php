@extends('profile.layout', ['title' => 'تیکت ها' , 'fit' => true])
@section('profile-actions')
    @component('components.form.button',[
        'label' => 'تیکت جدید',
        'link' => route('profile.tickets.create')
    ])                    
    @endcomponent
@endsection
@section('profile-content')
    @component('components.chat',[
        'chats' => $tickets,
        'chatwith' => 'modella'
    ])
    @endcomponent
@endsection