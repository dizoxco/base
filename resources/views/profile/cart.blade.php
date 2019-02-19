@extends('layout')
@section('content')
<br>
    <div class="container large flex">
        <div class="w-2/3">
            @forelse($cart as $item)
                <div class="side__cart-product flex py-3 px-5 relative bg-white mb-4 ml-2">
                    <div class="side__cart-product-img w-1/3 ">
                      <img src="{{$item->product->getFirstMedia(enum('media.product.banner'))->getFullUrl()}}" class="w-24">
                    </div>
                    <div class="side__cart-product-detail caption pr-2 w-2/3">
                      <div class="side__cart-product-name text-sm text-black">
                        <div>{{$item->product->title}}</div>
                        <div class="font-bold text-black text-lg mt-3">@toman($item->price)  <span class="text-sm font-normal text-black">تومان</span> </div>
                        <a href="{{route('cart.destroy', $item)}}"><i class="material-icons absolute pin-l pin-t text-black ml-2 p-1 text-grey-dark">close</i></a>
                      </div>
                    </div>
                  </div>
            @empty
                    You have no products in your cart yet!
            @endforelse
        </div>
        <div class="w-1/3">
            <div class="bg-white mr-2 p-4 text-center">
                @forelse($errors->all() as $error)
                    {{ $error }}
                @empty
                @endforelse
                <h4>مجموع سفارش</h4>
                <h6>@toman(auth()->user()->cartCost)</h6>
                <br>
                @component('components.form.button',[
                    'label' => 'نهایی کردن سفارش',
                    'link' => route('shipping.index'),
                ])
                @endcomponent
            </div>
        </div>
    </div>
@endsection