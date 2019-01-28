@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-4/5 mb-10">
            {{-- @php print_r($post) @endphp --}}
            <img src="{{$post->banner[0]->getUrl('banner')}}" alt="">
            <div class="py-2"><time datetime="YYYY.MM.DD">{{$post->published_at}}</time></div>
            <h1 class="mb-4">{{$post->title}}</h1>
            <div>
                {{$post->body}}
            </div>
            <div class="related-post" column="2">
                <div class="">
                    {{-- @foreach ($posts as $post)
                        @component('components.post.card-horizontal',['post'=>$post])@endcomponent
                    @endforeach --}}
                </div>
            </div>
        </div>
        <div class="w-1/5">
            <h1>sidebar</h1>
        </div>
    </div>    
@endsection