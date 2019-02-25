@extends('profile.layout', ['title' => 'چت ها', 'fit' => true])
@section('profile-content')
    @component('components.chat',[
        'chats' => $chats,
        'chatwith' => 'businesses'
    ])
    @endcomponent
@endsection