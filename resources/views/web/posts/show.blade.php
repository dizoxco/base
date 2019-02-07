@extends('layout')
@section('content')
    <div class="bg-white">
    <div class="flex flex-wrap container medium pb-10">
        <article class="">
            <div class="post-header relative">
                <img class="align-bottom" src="{{$post->banner[0]->getUrl('banner')}}" alt="">
                <div class="absolute pin-b pin-l bg-grey text-white py-1 px-4">
                    <time>{{ jdate($post->published_at)->format('Y/m/d')}}</time>
                </div>
            </div>
            <div class="post-content md:px-16 my-10">
                <h1 class="headline">{{$post->title}}</h1>
                <div class="body-2">
                    {{$post->body}}
                </div>
            </div>
        </article>
        <div class="related-post my-4">
            <h3 class="title-2">مطالب مرتبط</h3>
            <div class="flex flex-row flex-wrap -mx-2" column="2">
                @foreach (range(1,4) as $id)
                    <div class="w-full md:w-1/2 p-2">
                        <div class="bg-grey-lighter">
                            <a class="no-underline" href="{{route('posts.show', $post->slug)}}">
                                <div class="flex items-center ">
                                    <div class="w-1/5 my-2 ml-2 mr-4"><img class="rounded-full align-bottom" src="{{$post->banner[0]->getUrl('teaser')}}" alt=""></div>
                                    <p class="w-4/5 subheading p-2">{{$post->title}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="comments my-4">
            @component('components.comment',['post' => $post]) @endcomponent
        </div>
        <div class="flex flex-wrap my-4">
            <div class="w-1/5"></div>
            <div class="comment-form w-3/5">
                @component('components.comment-form')@endcomponent
            </div>
            <div class="w-1/5"></div>
        </div>
    </div>   
    </div> 
@endsection