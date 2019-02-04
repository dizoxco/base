@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-1/4">
            <h1>فیلترها</h1>
            <form target="_self">
                @forelse($options as $name => $option)
                    <label >{{ $option['label'] }}</label>
                    <hr>
                    @forelse(array_wrap($option[$option['query']]) as $index => $filter)
                        @isset($filter['label'])
                            <label >{{ $filter['label'] }}</label>
                        @endisset
                        @switch($option['query'])
                            @case('tag')
                                @include('searchpanels.inputs.checkbox', compact('name'))
                                @break
                            @case('like')
                                @include('searchpanels.inputs.textbox', compact('name', 'option'))
                                @break
                            @case('order')
                                @include('searchpanels.inputs.link', compact('name','index', 'filter'))
                                @break
                        @endswitch
                    @empty
                        <p>هیچ فیلتری تعریف نشده است</p>
                    @endforelse
                @empty
                    <h1>انتخابی وجود ندارد.</h1>
                @endforelse
                <button type="submit" class="-btn border-blue-dark border-2">search</button>
            </form>
        </div>
        <div class="w-3/4">
            <div class="flex flex-wrap">
                @forelse($products as $product)
                    <div class="w-1/3">
                        @if($product->getMedia(enum('media.product.banner'))->isNotEmpty())
                            <img src="{{$product->getFirstMedia(enum('media.product.banner'))->getFullUrl()}}" class="">
                        @else
                            <img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt="">
                        @endisset
                        <a href="{{route('products.show', $product->slug)}}">
                            <h3> {{ $product->title }}</h3>
                        </a>
                        <p>{{ $product->created_at->diffForHumans() }}</p>
                        <p>@toman($product->price)</p>
                    </div>
                @empty
                    <h1> هیچ محصولی برای این پنل تعریف نشده است. </h1>
                @endforelse
            </div>
        </div>
    </div>
@endsection