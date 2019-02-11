@extends('profile.businesses.layout')
@section('profile-content')
    @forelse($businesses as $business)
        <div>
            <a href="{{ route('profile.businesses.show', $business->slug) }}">
                {{ $business->brand }}
            </a>
        </div>
    @empty
        There is no business registered by you.
    @endforelse
@endsection