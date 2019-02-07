@extends('layout')
@php
    $banner = $product->getMedia(enum('media.product.banner'))[0];
    $gallery = $product->getMedia(enum('media.product.gallery'));
@endphp
@section('content')
    <div class="flex flex-wrap bg-white container">
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
        <div class="w-1/6">
            <div class="swiper simple overflow-hidden h-screen/7" column="3" direction="vertical" >
                <div class="swiper-wrapper">
                    @foreach ($gallery as $media)
                        <div class="swiper-slide w-full">
                            <img class="w-full absolute pin-y m-auto" src="{{$media->getFullUrl()}}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-1/2 p-4 flex flex-wrap items-center">
            <img class="hidden md:block" src="{{$product->getMedia(enum('media.product.banner'))[0]->getFullUrl()}}" alt="">
        </div>
        <div class="md:w-1/3 p-4">
            <h1 class="headline">{{$product->title}}</h1>
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