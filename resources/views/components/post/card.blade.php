<div class="bg-white {{$class ?? ''}}">
    <a href="{{route('posts.show', $post->slug)}}">
        <img src="{{$post->banner[0]->getUrl('teaser')}}" alt="">
        {{$post->title}}
    </a>
</div>