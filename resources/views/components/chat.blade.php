@php
    switch ($chatwith) {
        case 'users':
            $chat = request()->route()->parameters['chat'] ?? $chats->first();  
            break;
        case 'businesses':
            $chat = isset(request()->route()->parameters['business'])? 
                    $chats->where('business_id', request()->route()->parameters['business']->id)->first(): 
                    $chats->first();  
            break;
        case 'modella':
            $chat = request()->route()->parameters['ticket'] ?? $chats->first();  
            break;
    }
@endphp
<div class="flex h-screen/7 shadow rounded-lg overflow-hidden">
    <div class="w-1/4 h-full swiper-container scroll-swiper bg-grey-lighter ">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="height:auto">
                @forelse($chats as $c)
                    @php
                        switch ($chatwith) {
                            case 'businesses':
                                $href = route('profile.chats.show', [$c->business->slug]);
                                $ajax_href = route('profile.chats.show', [$c->business]);
                                $img = $c->business->getFirstMedia(enum('media.business.logo')) ? $c->business->getFirstMedia(enum('media.business.logo'))->getFullUrl() : '/images/avatar.jpg';
                                $title = $c->business->brand;
                                break;
                            case 'users':
                                $business = request()->route()->parameters['business'];
                                $href = route('profile.businesses.chats.show', [$business->slug, $c]);
                                $ajax_href = route('profile.businesses.chats.show', [$business, $c]);
                                $img = $c->user->getFirstMedia('avatar') ? $c->user->getFirstMedia('avatar')->getUrl() : '/images/avatar.jpg';
                                $title = $c->user->fullname;
                                break;
                            case 'modella':
                                $href = route('profile.tickets.show', $c);
                                $ajax_href = route('profile.tickets.show', $c);
                                $title = $c->attributes['title'];
                                break;
                        }
                    @endphp
                    <div class="p-2 border-b border-solid border-grey-lighter hover:bg-grey-light">
                        <a class="chat-id flex" href="{{$href}}" api-href="{{$ajax_href}}">
                            @if ($chatwith == 'modella')
                                <span class="bg-grey-darkest text-white w-12 h-12 rounded-full text-align-center">
                                    123
                                </span>
                            @else
                                <img class="rounded-full w-12 self-center" src="{{$img}}" alt=""/>
                            @endif
                            <div class="w-4/5">
                                <p class="p-4">
                                    {{ $title }}
                                </p>
                            </div>
                        </a>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
        <div class="swiper-scrollbar"></div>
    </div>
    <div class="w-3/4 h-full chat-comments bg-grey-lighter flex flex-col">
        <div class="bg-grey-darkest flex items-center px-8 z-10 p-2 z-50 w-full shadow-lg">
            <img class="w-10 rounded-full" src="/images/avatar.jpg" alt="">
            <div class="font-bold text-white p-4">
                    @switch($chatwith)
                    @case('users')
                        {{ $chat->user->name }}
                        @break
                    @case('businesses')
                        {{ $chat->business->brand }}
                        @break
                    @default
                        
                @endswitch
            </div>
        </div>
        <div class="w-full swiper-container scroll-swiper h-full">
            <div class="swiper-wrapper">
                <div class="swiper-slide py-4 px-8" style="height:auto; box-sizing: border-box">
                    @foreach ($chat->comments as $comment)
                        @php
                            switch ($chatwith) {
                                case 'users':
                                    $me = $comment->user_id == $chat->user_id;
                                    $business = request()->route()->parameters['business'];
                                    $href = route('profile.businesses.chats.show', [$business->slug, $chat]);
                                    $ajax_href = route('profile.businesses.chats.show', [$business, $chat]);
                                    break;
                                default:
                                    $me = $comment->user_id == auth()->id();
                            }
                        @endphp
                        <div class="clearfix flex items-center ">
                            <p class=" w-2/5 py-4 px-6  my-1 rounded-xl flex @if($me) me bg-grey-darkest text-white @else tome bg-white mr-auto text-black @endif">
                                {{$comment->body}}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-scrollbar"></div>
        </div>
        <div class="w-full z-40 px-8 py-2 bg-grey-lightest ">
                @component('components.form',[
                    'method' => 'POST',
                    'action' => $href
                ])
                    @component('components.form.text',[
                        'label' => 'متن پیام',
                        'name' => 'body'
                    ])
                    @endcomponent
                @endcomponent
        </div>
    </div>
</div>