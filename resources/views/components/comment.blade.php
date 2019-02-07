<p class="title-2">{{$post->comments->count()}} دیدگاه</p>
@foreach ($post->comments as $comment)
<div class="bg-grey-lighter p-4 my-4">
    <div class="flex items-start"> 
        <div class="w-1/12 hidden md:block">
            <img class="rounded-full" src="{{$comment->user->getFirstMedia('avatar') ? $comment->user->getFirstMedia('avatar')->getUrl() : '/images/avatar.jpg'}}" alt=""/>
        </div>
        <div class="w-11/12 px-4">
            <p class="subheading">{{($comment->user->name)}}<i class="material-icons body-1">reply</i></p>
            <p class="caption">{{jdate($comment->user->created_at)->format('Y F d')}}</p>
            <p class="body-1">{{($comment->body)}}</p>
        </div>
    </div>
</div>
@endforeach