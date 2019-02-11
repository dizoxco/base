@extends('profile.layout', ['title' => 'چت ها'])
@section('profile-content')
    
<table>
    <th>
        <td></td>
    </th>
    @forelse($chats as $chat)
        <tr>
            <td>
                <img
                        width="100"
                        src="{{ $chat->business->getFirstMedia(enum('media.business.logo'))->getFullUrl() }}"
                        alt="{{ $chat->business->brand }}"
                >
            </td>
            <td>
                <a href="{{ route('businesses.chat.show', $chat->business->slug) }}">
                    {{ $chat->business->brand }}
                </a>
            </td>
        </tr>
    @empty
        <tr>
            You have no conversation with anyone.
        </tr>
    @endforelse
</table>
@endsection