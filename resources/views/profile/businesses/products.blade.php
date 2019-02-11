@extends('profile.businesses.layout')
@section('profile-content')
    @forelse($products as $product)
        <div>{{ $product->title }}</div>
        <div>{{ $product->abstract }}</div>
        <div>{{ $product->price }}</div>
        <div>{{ $product->created_at->diffForHumans() }}</div>
        <div>{{ $product->updated_at->diffForHumans() }}</div>
        <hr>
    @empty
    @endforelse
@endsection