@extends('layout')
@section('content')
    <div class="flex flex-wrap -mx-2">
        @forelse($posts as $post)
        <div class="w-1/3 px-2 py-2">
            @component('posts.card', ['post' => $post])@endcomponent
        </div>
        @empty
            <div>No content</div>
        @endforelse
    </div>
@endsection