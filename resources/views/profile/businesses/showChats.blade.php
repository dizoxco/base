@extends('profile.businesses.layout')
@section('profile-content')
    <table>
        <tr>
            <th>نویسنده</th>
            <th>پیام</th>
            <th>تاریخ ایجاد</th>
        </tr>
        @forelse($comments as $comment)
            <tr>
                <td>{{ $comment->user->fullname }}</td>
                <td>{{ $comment->body }}</td>
                <td>{{ optional($comment->created_at)->diffForHumans() }}</td>
            </tr>
        @empty
        @endforelse
    </table>
@endsection