@extends('profile.layout', ['title' => 'اندازه ها'])
@section('profile-content')
    @forelse($sizes as $size)
        <div>
            <a href="{{ route('profile.sizes.show', $size) }}">
                {{ $size->id }}
            </a>
        </div>
    @empty
        There is no size defined by you. <a href="{{ route('profile.sizes.create') }}">create one</a>.
    @endforelse
@endsection