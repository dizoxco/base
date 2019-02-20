@extends('layout')
@section('content')
<br>
    <div class="container large flex">
        <div class="w-2/3">
            <form action="{{ route('payment.store') }}" method="POST">
                {{ csrf_field() }}
                    <div class="side__cart-product flex py-3 px-5 relative bg-white mb-4 ml-2">
                        <div class="side__cart-product-img w-1/3 ">
                            روش های پرداخت
                        </div>
                        @forelse($paymentMethods as $key => $method)
                        <div class="side__cart-product-detail caption pr-2 w-2/3">
                          <div class="side__cart-product-name text-sm text-black">
                            <div class="font-bold text-black text-lg mt-3">
                                <input type="radio" name="payment" value="{{ $key }}">
                                <span class="text-sm font-normal text-black">
                                روش : {{ $method['description'] }}
                                </span>
                            </div>
                          </div>
                        </div>
                        @empty
                            سبد خرید شما خالی است.
                        @endforelse
                    </div>
                @component('components.form.button',[
                    'label' => 'انتخاب روش پرداخت',
                ])
                @endcomponent
            </form>
        </div>
        <div class="w-1/3">
            <div class="bg-white mr-2 p-4 text-center">
                <h4>مجموع سفارش</h4>
                <h6>@toman(auth()->user()->cartCost)</h6>
                <br>
                @component('components.form.button',[
                    'label' => 'ادامه خرید',
                ])
                @endcomponent
            </div>
        </div>
    </div>
@endsection