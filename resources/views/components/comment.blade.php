<h3 class="py-4">{{$post->comments->count()}} دیدگاه</h3>
@foreach ($post->comments as $comment)
<div class="bg-grey-light p-2">
    
    <div class="w-1/5 m-2"><img class="rounded-full" src="{{$comment->user->getFirstMedia('avatar') ? $comment->user->getFirstMedia('avatar')->getUrl() : ''}}" alt=""/></p></div>
    <div class="w-4/5 m-2">
        <p>{{($comment->user->name)}}</p>
        <p>{{jdate($comment->user->created_at)->format('Y M d')}}</p>
    </div>
    <p>{{($comment->body)}}</p>
</div>
@endforeach