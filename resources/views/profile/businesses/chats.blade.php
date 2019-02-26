@extends('profile.businesses.layout', ['title' => "مخاطبین $business->brand", 'fit' => true])
@section('profile-content')
    @component('components.chat',[
        'chats' => $business->chats,
        'chatwith' => 'users'
    ])
    @endcomponent
@endsection