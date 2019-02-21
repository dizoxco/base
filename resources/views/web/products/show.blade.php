@extends('layout')
@php
    $banner = $product->getMedia(enum('media.product.banner'))[0];
    $gallery = $product->getMedia(enum('media.product.gallery'));
@endphp
@section('content')
    <div class="bg-white flex flex-wrap container py-2 mt-8">
        
        <div class="swiper simple -mx-4 overflow-hidden md:hidden" column="1" >
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{$banner->getFullUrl()}}" alt="">
                </div>
                @foreach ($gallery as $media)
                    <div class="swiper-slide">
                        <div class="p-4">
                            <img src="{{$media->getFullUrl()}}" alt="">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="w-1/7 product-images hidden md:block">
            <div class="swiper simple overflow-hidden h-screen/7" column="3" direction="vertical" >
                <div class="swiper-wrapper">
                    @foreach ($gallery as $i => $media)
                        <div class="swiper-slide flex items-center justify-center p-1 border-box" style="box-sizing: border-box">
                            <img class="max-h-full" media-gallery="{{1+$i}}" src="{{$media->getFullUrl()}}" alt="">
                        </div>
                    @endforeach
                    @foreach ($gallery as $i => $media)
                        <div class="swiper-slide flex items-center justify-center p-1 border-box" style="box-sizing: border-box">
                            <img class="max-h-full" media-gallery="{{1+$i}}" src="{{$media->getFullUrl()}}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="product-image w-1/3 items-center justify-center h-screen/7 hidden md:flex">
            <img class="max-h-full" media-gallery="0" src="{{$banner->getFullUrl()}}" alt="">
        </div>

        <div class="mr-16">
            <h1 class="title">{{$product->title}}</h1>
            <div class="flex caption pb-6">
                @php
                    $number = 10;
                    $rating = 2.7;
                @endphp
                <div class="text-xs">
                @component('components.star-rating', [
                        'number' => $number,
                        'rating' => $rating,
                    ])@endcomponent
                </div>
                <p class="px-2">( {{$number}} رای )</p>
                <p class="px-2">{{$rating}}</p>

            </div>
            <div class="price flex items-center py-6">
                <p class="text-base text-grey-dark font-bold ml-10"><del>1,000,000 تومان</del></p>
                <p class="text-xl font-bold ml-10">@toman($product->price)</p>
                <div class="flex items-center">
                    <div class="text-white rounded-full h-16 w-16 flex items-center justify-center bg-black border-4 border-solid border-white z-10 ">38%</div>
                    <div class="text-white bg-grey-dark rounded-full py-2 px-4 pr-10 -mr-8 text-sm"> <span>تخفیف:</span><span class=""> 1,500,000 تومان</span></div>
                </div>
            </div>
            <div class="py-6">
                <div class="flex items-center py-2">
                    <i class="material-icons pl-2">store_mall_directory</i>
                    @forelse($product->businesses as $business)
                    <a class="text-sm" href="{{ route('businesses.show', $business->slug) }}">{{ $business->brand }}</a>
                    @empty
                        مدلا
                    @endforelse
                    <p class="rounded-full bg-black text-white px-4 py-2 text-sm mr-16">رضایت خرید : {{$rating*10}} %</p>
                </div>
                <div class="flex items-center py-2">
                    <i class="material-icons pl-2">access_time</i>
                    <span class="text-sm">زمان تحویل</span><span class="delivery-date pr-2 text-sm">۲۲ اسفند ماه</span>  
                </div>
            </div>   
            
            <div id="product-options">
                @foreach ($product->options as $option)
                    @component('components.form.field')
                        <div option="{{$option['name']}}">
                            <span class="title">{{$option['label']}}:</span><br>
                            @foreach ($option['values'] as $value)
                                <div value="{{$value['value']}}" class="check p-2 border-2 border-solid ml-4 inline-block border-black rounded-full cursor-pointer">
                                    @isset($value['color'])
                                        <span class="border-2 border-solid p-3 inline-block border-black rounded-full align-middle" style="background-color: {{ $value['color'] }}">
                                        </span>
                                    @endisset
                                    <span>
                                        {{$value['label']}}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endcomponent
                @endforeach
            </div>
            <div class="flex items-center py-6">
                <a href="{{ route('cart.store', $product->variations[0]) }}">
                    @component('components.form.button', [
                        'label' => 'افزودن به سبد خرید',
                        'raised' => true,
                    ])@endcomponent
                </a>
                <i class="material-icons p-2 rounded-full bg-grey-light mr-6">favorite_border</i>
                <i class="material-icons p-2 rounded-full bg-grey-light mr-6">share</i>
            </div>
            @if($is_favorite)
                <a
                        style="text-decoration: none"
                        href="{{ route('wishlist.destroy', $product->slug) }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('remove_product_from_wishlist').submit();"
                >
                    حذف از علاقه مندی ها
                </a>
                <form id="remove_product_from_wishlist" action="{{ route('wishlist.destroy', $product->slug) }}" method="post" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}}
                </form>
            @else
                <a
                        style="text-decoration: none"
                        href="{{ route('wishlist.store', $product->slug) }}"
                >
                    افزودن به علاقه مندی ها
                </a>
            @endif
            @if (!$product->single && count(auth()->user()->businesses))
                <br>
                @if (count(auth()->user()->businesses) > 1)
                    @component('components.form.button', [
                        'label' => 'افزودن به محصولات خود',
                        'raised' => true,
                        'dialog' => 'addp2b'
                    ])@endcomponent

                    @component('components.dialog',[
                        'id' => 'addp2b',
                        'title' => 'sdfdf',
                        'buttons' => [
                            'save' => 'ذخیره'
                        ],
                        'cancel' => 'انصراف'
                    ])
                        @foreach (auth()->user()->businesses as $business)
                            {{$business->brand}} <br>
                        @endforeach
                        @component('components.form.field')
                            @component('components.form.select', [
                                'label' => 'افزودن کسب و کار',
                                'options' => [
                                    'aa' => 'aaa',
                                    'bb' => 'bbb',
                                    'cc' => 'ccc',
                                    'dd' => 'ddd',
                                ],
                            ])
                            @endcomponent
                        @endcomponent
                    @endcomponent
                @else
                    link
                @endif
                
            @endif
        </div> 

        <div class="product-gallery bg-white hidden pin-y pin-x w-full h-full z-50 ">
            <div class="w-full flex">
                <div class="w-1/8 flex flex-col">
                    <div class="close hover:bg-grey-lighter h-screen/15 flex items-center justify-center" >
                        <i class="material-icons">close</i>
                    </div>
                    <div class="prev hover:bg-grey-lighter w-full flex items-center justify-center h-screen/7">
                        <i class="material-icons">chevron_right</i>
                    </div>
                </div>
                <div class="banner w-full flex items-center justify-center p-4">
                    <img src="{{$banner->getFullUrl()}}" >
                </div>
                <div class="w-1/8 flex items-center justify-center">
                    <div class="next hover:bg-grey-lighter w-full flex items-center justify-center h-screen/7">
                        <i class="material-icons">chevron_left</i>
                    </div>
                </div>
            </div>
            <div class="w-1/7 b-r">
                <div class="swiper  overflow-hidden h-full" column="5" direction="vertical" >
                    <div class="swiper-wrapper">
                        <div class="swiper-slide flex justify-center p-1" style="box-sizing: border-box">
                            <img class="max-h-full" src="{{$banner->getFullUrl()}}" >
                        </div>
                        @foreach ($gallery as $media)
                            <div class="swiper-slide flex justify-center p-1" style="box-sizing: border-box">
                                <img class="max-h-full" src="{{$media->getFullUrl()}}" >
                            </div>
                        @endforeach
                        @foreach ($gallery as $media)
                            <div class="swiper-slide flex justify-center p-1" style="box-sizing: border-box">
                                <img class="max-h-full" src="{{$media->getFullUrl()}}" >
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full">
            <table class="product-variations">
                <thead></thead>
                <tbody>
                    @foreach ($product->variations as $variation)
                        <tr class="hidden" @foreach ($variation['options'] as $opt => $val) {{$opt}} = {{$val}} @endforeach>
                            <td>{{ $variation->business->brand }}</td>
                            <td>{{ $variation->quantity }}</td>
                            <td>{{ $variation->price }}</td>
                            <td>
                                <a href="{{ route('cart.store', $variation) }}">
                                    @component('components.form.button', [
                                        'label' => 'افزودن به سبد خرید',
                                        'raised' => true,
                                    ])@endcomponent
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="w-full">
            <table class="table-auto">
                <h2 class="bg-green-dark">فروشندگان</h2>
                <th>
                    <td>ردیف</td>
                    <td>لوگو</td>
                    <td>نام</td>
                    <td>ادرس</td>
                </th>
                @forelse($product->businesses as $business)
                <tr class="table-row">
                    <td>{{ $loop->index+1 }}</td>
                    <td><img class="w-1/4" src="{{ $business->getFirstMediaUrl(enum('media.business.logo')) }}" alt=""></td>
                    <td><a href="{{ route('businesses.show', $business->slug) }}">{{ $business->brand }}</a></td>
                    <td>{{ $business->address }}</td>
                </tr>
                @empty
                    این محصول هیچ فروشنده ای ندارد.
                @endforelse
            </table>
        </div>
        <div class="w-full">
            <table class="table-auto">
                <h2 class="bg-green-dark">انواع مختلف محصول</h2>
                <th>
                <td>ردیف</td>
                <td>قیمت</td>
                <td>افزودن به کارت</td>
                </th>
                @forelse($product->relatedVariations as $variation)
                    <tr class="table-row">
                        <td>{{ $loop->index+1 }}</td>
                        <td><img class="w-1/4" src="{{ $business->getFirstMediaUrl(enum('media.business.logo')) }}" alt=""></td>
                        <td><a href="{{ route('businesses.show', $business->slug) }}">{{ $business->brand }}</a></td>
                    </tr>
                    @empty
                        این محصول هیچ فروشنده ای ندارد.
                    @endforelse
                </table>
            </div>
            <div class="w-full">
                <table class="table-auto">
                    <h2 class="bg-green-dark">انواع مختلف محصول</h2>
                    <th>
                    <td>ردیف</td>
                    <td>قیمت</td>
                    <td>افزودن به کارت</td>
                    </th>
                    @forelse($product->relatedVariations as $variation)
                        <tr class="table-row">
                            <td>{{ $loop->index+1 }}</td>
                            <td>@toman($variation->price)</td>
                            <td>
                                <a href="{{ route('cart.store', $variation) }}">
                                    افزودن به سبد خرید
                                </a>
                            </td>
                        </tr>
                    @empty
                        این محصول هیچ فروشنده ای ندارد.
                    @endforelse
                </table>
            </div> --}}
            <div class="w-1/3 m-12 pin-l">
                <div class="pb-6 font-bold">توضیحات محصول</div>
               <div class="text-sm leading-loose">
                    {{$product->body}}
               </div>
            </div>
            <div class="w-full">
                <h3 class="text-xl font-normal flex justify-center my-6 text-black">شاید به این محصولات علاقه‌مند باشید</h3>
                <div class="swiper simple overflow-hidden" column="5" >
                    <div class="swiper-wrapper mb-8 flex items-stretch">
                        @foreach ($product->related() as $product)
                            <div class="swiper-slide ">
                                <div class="bg-white swiper-slide px-2 flex">
                                    <div class="p-3 m-3">
                                        <a class="flex" href="{{route('products.show', $product->slug)}}">
                                            <div class="text-center text-black">
                                                <img src="{{$product->getFirstMedia(enum('media.product.banner'))->getFullUrl()}}" alt="">
                                                <div class="pt-3">{{$product->title}}</div>
                                                <div class="pt-3 ">@toman($product->price)</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- <div class="w-full">
                <h3 class="bg-red-light">نظرات</h3>
                <ol>
                    @forelse($product->comments as $comment)
                        <li> {{ $comment->body }}</li>
                    @empty
                        اولین کسی باشید که برای این محضول نظر میدهد.
                    @endforelse
                </ol>
            </div> --}}
        </div>
    </div>
@endsection