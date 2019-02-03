@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div>
            <img src="{{$business->getFirstMedia(enum('media.business.logo'))->getFullUrl()}}" alt="">
            <h1>{{$business->brand}}</h1>
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
            @forelse($business->products as $product)
                <div>
                    {{ $product->title }}
                </div>
            @empty
                There is no products submitted for this business
            @endforelse

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
@endsection