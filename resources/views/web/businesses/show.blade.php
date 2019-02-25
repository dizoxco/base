@extends('layout')
@section('content')
<br>
    <div class="container flex flex-wrap">
        <div class="w-1/4 pl-4">
            <div class="relative rounded-lg bg-white px-8 py-6 flex flex-col" >
                <div class="flex justify-center items-center">
                <img src="{{$business->getFirstMedia(enum('media.business.logo'))->getFullUrl()}}" alt="" class="w-1/2">
                </div>
                <h1 class="title text-center my-3">{{$business->brand}}</h1>
                <div class="address">
                    @isset($business->contact['address'])
                        @forelse ($business->contact['address']['title'] as $index => $title)
                            <p class="body-1"><span>آدرس</span> <span>{{ $title }}</span>:</p>
                            <p class="caption">{{$business->contact['address']['value'][$index]}}</p>
                        @empty
                            There is no tel submitted for this business
                        @endforelse
                    @endisset
                </div>
                <div class="tel">
                    @isset($business->contact['tel'])
                        @forelse ($business->contact['tel']['title'] as $index => $title)
                            <p class="body-1"><span>تلفن</span> <span>{{ $title }}</span>:</p>
                            <p class="caption">{{$business->contact['tel']['value'][$index]}}</p>
                        @empty
                            There is no tel submitted for this business
                        @endforelse
                    @endisset
                </div>
                <div class="instagram flex justify-center">
                    @isset($business->contact['instagram'])
                        @forelse ($business->contact['instagram']['title'] as $index => $title)
                            <p class="body-1"><span>اینستاگرام</span> <span>{{ $title }}</span>:</p>
                            <p class="caption">{{$business->contact['instagram']['value'][$index]}}</p>
                        @empty
                            There is no instagram submitted for this business
                        @endforelse
                    @endisset
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
            <div class="text-center">
                <br><br>
                @component('components.form.button', [
                    'label' => 'ارسال پیام',
                    'raised' => true,
                    'shaped' => true,
                    'custom_class' => 'p-10',
                    'link' => route('profile.chats.show', $business->slug)
                ])@endcomponent
            </div>

        </div>
        <div class="w-3/4 pr-4">
            <div class="relative rounded-lg bg-white px-6 py-6 mb-6">
                <ul class="list-reset">
                    <li class="no-underline inline-block border border-black align-top rounded-full py-2">معرفی</li>
                </ul>
            </div>
            <div class="relative rounded-lg bg-white px-6 py-6 mb-4 ">
                    There is no comment submitted for this business
                    There is no comment submitted for this business
                    There is no comment submitted for this business
                    There is no comment submitted for this business
                    There is no comment submitted for this business

            </div>
            <div class="flex flex-wrap -m-3">
                @forelse($business->products as $product)
                    <div class="w-1/2 lg:w-1/3 p-1 md:p-3">
                        @component('web.products.card', ['product' => $product])@endcomponent
                    </div>
                @empty
                    <p> There is no product submitted for this business </p>
                @endforelse
            </div>
        </div>

    </div>    
@endsection