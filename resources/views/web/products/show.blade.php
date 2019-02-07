@extends('layout')
@section('content')
    <div class="flex flex-wrap bg-white">
        <div class="w-3/5 p-4 flex flex-wrap">
            <div class="w-full p-2 product-main-image">
                {{$product->getMedia(enum('media.product.gallery'))[0]}}
            </div>
            {{-- product-thumbnails-vertical --}}
            <div class="w-full swiper simple  -mx-4 overflow-hidden swiper-container-horizontal swiper-container-rtl">
                <div class="thumbnails swiper-wrapper">
                    @forelse($product->getMedia(enum('media.product.gallery')) as $picture)
                    <div class="thumbs-slide py-2"><a href="{{$picture->getFullUrl()}}"><img src="{{$picture->getFullUrl()}}" class=""></a></div>
                    @empty
                    <div class="thumbs-slide py-2"><img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt=""></div>
                    @endforelse
                </div>
            </div>
            {{-- <div class="swiper simple -mx-6 px-10 overflow-hidden" column="3" >
                <div class="swiper-wrapper">
                    @forelse($product->getMedia(enum('media.product.gallery')) as $picture)
                        <img src="{{$picture->getFullUrl()}}" class="">
                    @empty
                        <img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt="">
                    @endforelse
                </div>
            </div> --}}
        </div>
        <div class="w-2/5 p-4">
            <h1 class="headline">{{$product->title}}</h1>
        </div>
        <div class="w-full thumbnails-gallery ">
            <div class="w-4/5 canvas relative">
                <div class="">
                    <img class="canvas-image" src=""> 
                </div>
            </div>
            <div class="w-1/5 thumbs-container product-thumbnails-gallery  relative overflow-hidden" style="height: 94%; top: 3%;">
                <div class="absolute pin-t pin-l h-full bg-white rounded-sm" style=" width: 7px;">
                        <div class="scrollbar w-full absolute rounded-sm" style="height: 50%; background-color: rgba(0, 0, 0, .5);  transition: all .3s ease-out;"></div>
                </div>
                <div class="thumbs-wrapper" style="height: 100%; transition: all .3s ease-out;">
                        @forelse($product->getMedia(enum('media.product.gallery')) as $picture)
                        <div class="thumbs-slide swiper-slide center-align waves-effect waves-light py-2"><a href="{{$picture->getFullUrl()}}"><img src="{{$picture->getFullUrl()}}" class=""></a></div>
                        @empty
                        <div class="thumbs-slide py-2"><img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt=""></div>
                        @endforelse
                </div>
            </div>
        <div class="w-full">
            <h1>{{$product->title}}</h1>
            <a href="{{ route('wishlist.store', $product->slug) }}">
                افزودن به علاقه مندی ها
            </a>
        </div>
        <div class="w-full">
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
                        <td>@toman($variation->price)</td>
                        <td>
                            <a href="{{ route('cart.store', [$product->slug, $variation]) }}">
                                افزودن به سبد خرید
                            </a>
                        </td>
                    </tr>
                @empty
                    این محصول هیچ فروشنده ای ندارد.
                @endforelse
            </table>
        </div>
        <div class="w-full">
            {{$product->body}}
        </div>
        <div class="w-full">
            <h3 class="bg-blue-dark">محصولات مرتبط</h3>
            <div class="swiper simple overflow-hidden" column="5" >
                <div class="swiper-wrapper">
                    @foreach ($product->related() as $product)
                        <div class="swiper-slide">
                            <div class="bg-white swiper-slide px-2">
                                <a href="{{route('products.show', $product->slug)}}">
                                    <img src="{{$product->getFirstMedia(enum('media.product.banner'))->getFullUrl()}}" alt="">
                                    {{$product->title}}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full">
            <h3 class="bg-red-light">نظرات</h3>
            <ol>
                @forelse($product->comments as $comment)
                    <li> {{ $comment->body }}</li>
                @empty
                    اولین کسی باشید که برای این محضول نظر میدهد.
                @endforelse
            </ol>
        </div>
    </div>
@endsection