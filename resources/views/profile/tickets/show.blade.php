@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-1/4 pl-4">
            <a href="{{ route('profile.tickets') }}">back</a>
        </div>
        <div class="w-3/4 pr-4">
            <div><label for="">{{ $ticket->title }}</label></div>
            <div class="relative rounded-lg bg-white shadow-lg px-8 py-6 mb-6">
                <form action="{{ route('profile.tickets.reply', $ticket) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <textarea name="body" id="body" cols="30" rows="10" placeholder="متن پیام" required></textarea>
                    <button type="submit">پاسخ</button>
                </form>
            </div>
            <ol>
                @forelse($ticket->comments as $comment)
                    <li>
                        {{ $comment->body }}
                    </li>
                @empty
                    No comment
                @endforelse
            </ol>
            <div class="relative rounded-lg bg-white shadow-lg px-8 py-6 mb-4 ">
            </div>
            <div class="flex flex-wrap">
            </div>
        </div>

    </div>
@endsection