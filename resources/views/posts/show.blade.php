@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-4/5">
            <img src="{{$post->banner[0]->getUrl('banner')}}" alt="">
            <h1>{{$post->title}}</h1>
            <div>
                {{$post->body}}
            </div>
        </div>
        <div class="w-1/5">
            <h1>sidebar</h1>
        </div>
    </div>    
@endsection