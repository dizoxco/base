<div class="bg-grey-light">
    <a class="no-underline" href="{{route('posts.show', $post->slug)}}">
        <div class="flex items-center ">
            <div class="w-1/5 m-2"><img class="rounded-full" src="{{$post->banner[0]->getUrl('teaser')}}" alt=""></div>
            <p class="w-4/5 m-2">{{$post->title}}</p>
        </div>
    </a>
</div>