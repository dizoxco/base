@extends('profile.layout', ['title' => 'چت ها'])
@section('profile-content')
dddddddddddddd
    @forelse($comments as $comment)
        <div>
            {{ $comment->user->fullname }} : {{ $comment->body }}
        </div>
    @empty
        <div>
            مکالمه ای با {{ $chat->business->brand }} ندارید.
        </div>
    @endforelse
    @component('components.form', [
        'action' => route('profile.chats.store', $chat->business->slug),
        'method' => 'post',
    ])
        @component('components.form.textarea',[
            'name' => 'body',
        ])
        @endcomponent
        @component('components.form.button', [
            'label' => 'ارسال'
        ])
        @endcomponent
    @endcomponent
@endsection