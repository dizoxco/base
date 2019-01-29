@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="mb-10">
            {{-- @php print_r($post) @endphp --}}
            <article class="mb-10">
                <img class="mb-4" src="{{$post->banner[0]->getUrl('banner')}}" alt="">
                <div class="my-4"><time>{{ jdate($post->published_at)->format('Y M d')}}</time></div>
                <h1 class="my-4">{{$post->title}}</h1>
                <div class="">
                    {{$post->body}}
                </div>
            </article>
            <div class="related-post">
                <h3 class="py-4">پست های مرتبط</h3>
                <div class="flex flex-row flex-wrap" column="2">
                    @foreach (range(1,3) as $id)
                    <div class="w-full sm:w-1/1 md:w-1/2 lg:w-1/2 xl:w-1/2 p-2">
                        @component('components.post.card-horizontal', ['post' => $recent[$id]])@endcomponent
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="comments">
            <h3>{{$post->comments->count()}} دیدگاه</h3>
                @foreach ($post->comments as $comment)
                <div class="bg-grey-light">
                    {{-- @php print_r($comment->user) @endphp --}}
                    <p>{{($comment->user->name)}}</p>
                    <p>{{($comment->body)}}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>    
@endsection