@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-1/4 pl-4">
            <form target="_self">
                {{-- <p >{{ $options['order']['label'] }}</p> --}}
                @forelse($options as $name => $option)
                @if ($option['query'] !== 'order')
                <div class="relative bg-white rounded-lg pt-2 pb-4 px-4 mb-4">
                    <p class="body-2" >{{ $option['label'] }}</p>
                   @forelse(array_wrap($option[$option['query']]) as $index => $filter)
                        @switch($option['query'])
                            @case('tag')
                                    @include('searchpanels.inputs.checkbox', compact('name'))
                                    @isset($filter['label'])
                                        <label >{{ $filter['label'] }}</label>
                                    @endisset
                                    <br>
                                @break
                            @case('like')
                                @include('searchpanels.inputs.textbox', compact('name', 'option'))
                                @break
                            {{-- @case('order')
                                @include('searchpanels.inputs.link', compact('name','index', 'filter'))
                                @break --}}
                        @endswitch
                    @empty
                        <p>هیچ فیلتری تعریف نشده است</p>
                    @endforelse
                </div>
                @endisset

                @empty
                    <p>انتخابی وجود ندارد.</p>
                @endforelse
                {{-- 
                @foreach ($options as $name => $option)
                    
                    @if ($option['query'] == 'tag')
                    <div class="relative bg-white rounded-lg py-2 px-4 my-4">
                        <p class="body-2">{{$option['label']}}</p>
                        @foreach ($option['tag'] as $index => $tag)
                            <input 
                                class="body-1" 
                                type="checkbox" 
                                name="{{ $name }}[]" 
                                value="{{ $index }}" 
                                @if(request()->get($name) !== null)
                                @if(in_array($index, request()->get($name)))
                                    checked
                                @endif
                                @endisset
                            > {{$tag['label']}} </br>   
                        @endforeach
                    </div>
                    @endif
                    
                    @if ($option['query'] == 'like')
                        <p class="body-2">{{$option['label']}}</p>
                        <input 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                            type="text" 
                            name="{{ $name }}"
                            @if(request()->get($name) !== null)
                            value="{{ request()->get($name) }}"
                            @endisset
                        >

                    @endif
                @endforeach --}}
                <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">search</button>
            </form>
        </div>
        <div class="w-3/4 pr-4">
            <div class="relative bg-white rounded-lg p-4 mb-2">
                <span class="absoulute pin-r"><i class="material-icons">sort</i></span>
                @foreach ($options as $option)
                    @if ($option['query'] == 'order')
                        @foreach ($option['order'] as $index => $order)
                            <a class="no-underline rounded-full px-4 py-1" href="{{ request()->fullUrlWithQuery(['order' => $index]) }}">{{$order['label']}}</a>
                        @endforeach
                    @endif
                @endforeach
                <span class="absoulute pin-l">
                    <i class="material-icons">toc</i>
                    <i class="material-icons">view_list</i>
                </span>
            </div>
            <div class="flex flex-wrap">
                @forelse($products as $product)
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
                    <p> هیچ محصولی برای این پنل تعریف نشده است. </p>
                @endforelse
            </div>
        </div>
    </div>
@endsection