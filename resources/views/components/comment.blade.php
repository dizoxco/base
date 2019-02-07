<p class="title-2">{{$post->comments->count()}} دیدگاه</p>
@foreach ($post->comments as $comment)
<div class="bg-grey-light p-2  my-4">
    <div class="flex items-center"> 
        <div class="m-2"><img class="rounded-full" src="{{$comment->user->getFirstMedia('avatar') ? $comment->user->getFirstMedia('avatar')->getUrl() : ''}}" alt=""/></p></div>
        <div class="m-2">
            <p class="subheading">{{($comment->user->name)}}</p>
            <p class="caption">{{jdate($comment->user->created_at)->format('Y F d')}}</p>
            <p class="body-1">{{($comment->body)}}</p>
        </div>
    </div>
</div>
@endforeach