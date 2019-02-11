@extends('profile.businesses.layout')
@section('profile-content')
    <div>{{ $business->brand }}</div>
    <div>{{ $business->city->name }}</div>
    <div>{{ $business->contact['tel'][0]['label'] }}</div>
    <div>{{ $business->contact['tel'][0]['value'] }}</div>
    <div>{{ $business->created_at->diffForHumans() }}</div>
    <div>{{ $business->updated_at->diffForHumans() }}</div>
    <div>
        <a href="{{ route('profile.businesses.show.products', $business->slug) }}">products</a>
    </div>
@endsection