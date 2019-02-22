@extends('profile.layout', ['title' => 'تیکت ها'])
@section('profile-content')
    @component('components.chat',[
        'chats' => $tickets,
        'chatwith' => 'modella'
    ])
    @endcomponent
@endsection