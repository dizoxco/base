@extends('profile.layout', ['title' => 'چت ها'])
@section('profile-content')
    @component('components.chat',[
        'chats' => $chats,
        'chatwith' => 'businesses'
    ])
    @endcomponent
@endsection