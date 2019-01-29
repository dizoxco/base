@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-4/5">
            <img src="{{$business->logo->first()->getUrl()}}" alt="">
            <h1>{{$business->brand}}</h1>
            <div>
                {{$business->address}}
            </div>
        </div>
        <div class="w-1/5">
            <h1>sidebar</h1>
        </div>
    </div>    
@endsection