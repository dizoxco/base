@extends('layout')
@section('content')
    <div class="container flex flex-wrap">
        <div class="w-1/4 pl-4">
            <div class="relative rounded-lg bg-white shadow-lg px-8 py-6" >
                <img src="{{$business->getFirstMedia(enum('media.business.logo'))->getFullUrl()}}" alt="">
                <h1 class="title text-center">{{$business->brand}}</h1>
                <div class="address">
                    @forelse ($business->contact['address'] as $address)
                        <p class="body-1"><span>آدرس</span> <span>{{$address['label']}}</span>:</p>
                        <p class="caption">{{$address['value']}}</p>
                    @empty
                        There is no address submitted for this business
                    @endforelse
                </div>
                <div class="tel">
                    @forelse ($business->contact['tel'] as $tel)
                        <p class="body-1"><span>تلفن</span> <span>{{$tel['label']}}</span>:</p>
                        <p class="caption">{{$tel['value']}}</p>
                    @empty
                        There is no tel submitted for this business
                    @endforelse
                </div>
                <div class="instagram">
                    @forelse ($business->contact['instagram'] as $instagram)
                        {{-- <p class="body-1"><span>اینستاگرام</span> <span>{{$instagram['label']}}</span>:</p> --}}
                        <a class="caption" href="{{$instagram['value']}}"><i class="material-icons">link</i></a>
                    @empty
                        There is no Social media submitted for this business
                    @endforelse
                </div>                
                <ol>
                    @forelse($business->comments as $comment)
                    <li>
                        {{ $comment->body }}
                    </li>
                    @empty
                        <li>
                            There is no comment submitted for this business
                        </li>
                    @endforelse
                </ol>
            </div>

        </div>
        <div class="w-3/4 pr-4">
            <div class="relative rounded-lg bg-white shadow-lg px-8 py-6 mb-6">
                <ul class="list-reset">
                    <li class="no-underline inline-block border border-black align-top rounded-full px-6 py-2">معرفی</li>
                </ul>
            </div>
            <div class="relative rounded-lg bg-white shadow-lg px-8 py-6 mb-4 ">
                @isset($chat->comments)
                    @foreach($chat->comments as $comment)
                        @component('components.form.field')
                            {{ $comment->body }}
                        @endcomponent
                    @endforeach
                @else
                    پیامی که میخواهید برای {{ $business->brand }} بفرستید را بنویسید.
                @endisset

                @component('components.form', [
                    'action' => route('businesses.chat.store', $business->slug),
                    'method' => 'post'
                    ])
                    @component('components.form.text',[
                        'name' => 'body',
                        'label' => 'Message',
                    ])
                    @endcomponent
                    @component('components.form.button',[
                        'type' => 'submit',
                        'label'=> 'Send'
                    ])
                    @endcomponent
                @endcomponent
            </div>
        </div>

    </div>    
@endsection