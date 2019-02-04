@extends('layout')
@section('content')
    @forelse($posts as $post)
        <h1><a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a></h1>
        @forelse($post->tags as $tag)
            <h3><a href="{{ route('posts.tag', $tag->slug) }}">{{ $tag->label }}</a></h3>
        @empty
        @endforelse
        <hr>
        <p>{{ $post->abstract }}</p>
    @empty
    @endforelse
@endsection