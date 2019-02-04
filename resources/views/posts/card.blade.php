<div class="relative rounded shadow-lg h-full" >
        <a class="no-underline" href="{{ route('posts.show', $post->slug) }}"><img class="w-full" src="{{$post->banner[0]->getUrl('banner')}}" alt=""></a>
        <div class="px-6">
            <a class="no-underline" href="{{ route('posts.tag', $post->tags[0]->slug) }}"><span class="bg-grey-lighter rounded px-3 py-1 mt-2 absolute pin-t pin-r">{{ $post->tags[0]->label }}</span></a>
            <a class="no-underline" href="{{ route('posts.show', $post->slug) }}"><h2 class="title">{{ $post->title }}</h2></a>
            <div class="post-info ">
                <span class="caption pl-2">{{$post->user->name}}</span>
                <span class="caption pl-2"><time>{{ jdate($post->published_at)->format('Y F d')}}</time></span>
                <span class="caption pl-2">{{$post->comments->count()}} دیدگاه</span>
            </div>
            <p class="body-1 ">{{ $post->abstract }}</p>
            <a class="no-underline" href="{{ route('posts.show', $post->slug) }}"><span class="px-6 mb-6 absolute pin-b pin-r">جزئیات بیشتر</span></a>
        </div>

        <div class="px-6 py-4">
            {{-- @php print_r(($post->tags)[0]->slug) @endphp
            @forelse($post->tags as $tag)
                <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2"><a href="{{ route('posts.tag', $tag->slug) }}">{{ $tag->label }}</a></span>
            @empty
            @endforelse --}}
        </div>
    </div>
