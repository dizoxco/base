@extends('profile.businesses.layout', ['title' => "مخاطبین $business->brand"])
@section('profile-content')
    <table>
        <tr>
            <th>مخاطب</th>
            <th>آخرین پیام</th>
            <th>تاریخ ایجاد</th>
        </tr>
        @forelse($chats as $chat)
            <tr>
                <td>
                    <a href="{{ route('profile.businesses.show.chats.show', [$business->slug, $chat]) }}">
                        {{ $chat->user->fullname }}
                    </a>
                </td>
                <td>{{ optional($chat->comments->last())->body }}</td>
                <td>{{ $chat->created_at->diffForHumans() }}</td>
            </tr>
        @empty
        @endforelse
    </table>
@endsection