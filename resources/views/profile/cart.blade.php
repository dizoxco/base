@extends('layout')
@section('content')
<br>
    <div class="container">
        <div class="flex">
            <div class="w-3/4">
                <div class="title bg-white mb-4 rounded-lg px-10 flex items-center py-1"><i class="material-icons pl-6">card_travel</i>سبد خرید شما</div>
                @forelse($carts as $cart)
                    <div class="side__cart-product flex p-10 relative bg-white mb-4 rounded-lg ">
                        <div class="side__cart-product-img">
                            <img src="{{$cart->variation->product->getFirstMedia(enum('media.product.banner'))->getFullUrl()}}" class="w-32">
                        </div>
                        <div class="pr-6 flex">
                            <div class="text-black flex flex-col justify-between">
                            <div>{{$cart->variation->product->title}}</div>
                                <div class=" flex" data-value="grains">
                                    <div class="text-black pl-6">تعداد</div>
                                    <input type="number"
                                            value="{{ $cart->quantity > $cart->variation->quantity ? $cart->variation->quantity : $cart->quantity }}"
                                            min="1"
                                            max="{{ $cart->variation->quantity }}"
                                    >
                                </div>
                            <div class="font-bold text-black text-lg mt-3">@toman($cart->variation->price)<span class="text-sm font-normal text-black"></span></div>
                            
                            </div>
                            <a href="{{route('cart.destroy', $cart->variation)}}"><i class="material-icons absolute pin-l pin-t text-black m-8 text-grey-dark">close</i></a>
                        </div>
                        </div>
                @empty
                        سبد خرید شما خالی است!
                @endforelse
            </div>
            <div class="w-1/4">
                <div class="bg-white mr-6 rounded-lg p-10 mb-2">
                    <div class="flex justify-between mb-6">
                        <p>مبلغ کل سفارش شما:</p>@toman(auth()->user()->cartCost)
                    </div>
                    <div class="flex "></div>
                    <div class="flex justify-between">
                        <p>هزینه ارسال:</p>
                        <p>وابسته به آدرس</p>
                    </div>
                </div>
                <div class="bg-white mr-6 text-center rounded-lg p-10 mb-2">
                    @forelse($errors->all() as $error)
                        {{ $error }}
                    @empty
                    @endforelse
                    <h4>مجموع سفارش</h4>
                    @auth
                        <h6>@toman(auth()->user()->cartCost)</h6>
                    @endauth
                    @guest
                        @php
                            $cartCost = $carts->reduce(function ($carry, $cart) {
                                return $carry + ($cart->quantity * $cart->variation->price);
                            });
                        @endphp
                        <h6>@toman($cartCost)</h6>
                    @endguest
                    <br>
                    @component('components.form.button',[
                        'label' => 'ادامه ثبت سفارش',
                        'link' => route('shipping.index'),
                    ])
                    @endcomponent
                </div>
                <div class="bg-white mr-6 p-4 rounded-lg p-10 ">
                    <p class="flex items-center caption"><i class="material-icons pl-4">payment</i>پرداخت در محل با کارت بانکی</p>
                    <p class="flex items-center caption"><i class="material-icons pl-4">airport_shuttle</i>تحویل اکسپرس</p>
                    <p class="flex items-center caption"><i class="material-icons pl-4">high_quality</i>تضمین بهترین کیفیت</p>
                </div>
            </div>
        </div>
        
    </div>
@endsection