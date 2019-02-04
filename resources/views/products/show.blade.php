@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-full p-4">
            <div class="swiper simple -mx-6 px-10 overflow-hidden" column="3" >
                <div class="swiper-wrapper">
                    @forelse($product->getMedia(enum('media.product.gallery')) as $picture)
                        <img src="{{$picture->getFullUrl()}}" class="">
                    @empty
                        <img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt="">
                    @endforelse
                </div>
            </div>
        </div>
        <div class="w-full">
            <h1>{{$product->title}}</h1>
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