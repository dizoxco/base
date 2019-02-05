@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-1/4 pl-4">
            <div class="relative rounded-lg bg-white shadow-lg h-full px-8 py-6" >
                @php
                    //print_r($business);
                @endphp
                <img src="{{$business->getFirstMedia(enum('media.business.logo'))->getFullUrl()}}" alt="">
                <h1 class="title text-center">{{$business->brand}}</h1>
                <div>
                    @forelse($business->contact as $key => $contact)
                        @if(is_array($infos = $contact))
                            @include('businesses.contact', $infos)
                        @else
                            <label >{{ $contact['label'] }}</label>
                            <p> {{ $contact['value'] }}</p>
                        @endif
                    @empty
                        There is no contacts submitted for this business
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
            <div class="flex flex-wrap">
                @forelse($business->products as $product)
                    <div class="w-1/3 px-2 py-2">
                        <div class="relative rounded-lg bg-white shadow-lg h-full px-8 py-6" >
                            @if($product->getMedia(enum('media.product.banner'))->isNotEmpty())
                                <img src="{{$product->getFirstMedia(enum('media.product.banner'))->getFullUrl()}}" class="">
                            @else
                                <img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt="">
                            @endisset
                            <div class="text-center">
                                <a class="no-underline" href="{{route('products.show', $product->slug)}}">
                                    <h3 class=" subheading"> {{ $product->title }}</h3>
                                </a>
                                {{-- <p>{{ $product->created_at->diffForHumans() }}</p> --}}
                                <p class="text-center body-1 my-4">@toman($product->price)</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p> There is no product submitted for this business </p>
                @endforelse
            </div>
        </div>

    </div>    
@endsection


    
