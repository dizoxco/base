@extends('profile.layout', ['title' => 'size'])
@section('profile-content')
    @forelse($size->toArray() as $name => $value)
        {{ $name }} : {{ $value }}
        <br>
    @empty
        ...
    @endforelse
    <a href="{{ route('profile.sizes.edit', $size) }}">edit</a>

    <a
            href="{{ route('profile.sizes.destroy', $size) }}"
            onclick="e.preventDefault(); document.getElementById('frm_delete').submit();"
    >
        delete
    </a>
    <form action="{{ route('profile.sizes.destroy', $size) }}">
        {{ csrf_field() }}
        {{ method_field('delete') }}
    </form>
@endsection