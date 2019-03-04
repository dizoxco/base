@extends('layout')
@section('content')
    <div class="flex flex-wrap -mx-2 container">
        @forelse($posts as $post)
            <div class="w-full md:w-1/2 lg:w-1/3  px-2 py-2">
                <div class="relative rounded bg-white rounded-lg h-full overflow-hidden" >
                    <div class="relative">
                        @if($post->banner->isNotEmpty())
                            <a class="no-underline" href="{{ route('posts.show', $post->slug) }}"><img class="w-full" src="{{$post->banner[0]->getUrl('banner')}}" alt=""></a>
                        @endif
                        @if($post->tags->isNotEmpty())
                            <a class="no-underline" href="{{ route('posts.tag', $post->tags[0]->slug) }}"><span class="bg-grey-lighter px-4 py-1 mt-2 absolute pin-l pin-b mb-1">{{ $post->tags[0]->label }}</span></a>
                        @endif
                    </div>
                    
                    <div class="px-6">
                        <a class="no-underline" href="{{ route('posts.show', $post->slug) }}">
                            <h2 class="title">{{ $post->title }}</h2>
                        </a>
                        <div class="post-info ">
                            <span class="caption pl-2">{{$post->user->name}}</span>
                            <span class="caption pl-2"><time>{{ jdate($post->published_at)->format('Y F d')}}</time></span>
                            <span class="caption pl-2">{{$post->comments->count()}} دیدگاه</span>
                        </div>
                        <p class="body-1 mb-6 pb-6 ">{{ str_limit($post->abstract, 200, ' ...')  }}</p>
                        <a class="no-underline px-6 mb-6 absolute pin-b pin-r" href="{{ route('posts.show', $post->slug) }}">
                            جزئیات بیشتر
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div>No content</div>
        @endforelse
    </div>
    <div class="grid-pager container small mx-auto py-10">
         {{ $posts->links() }}
    </div>
@endsection