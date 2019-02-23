@extends('layout')
@section('content')
<br>
    <div class="container">
        <div class="bg-red flex justify-center">
            <div>stepper</div>
        </div>
        <div class="flex">
            <div class="w-3/4">
                <div class="title bg-white mb-4 rounded-lg px-10 flex items-center py-1"><i class="material-icons pl-6">place</i>انتخاب شیوه پرداخت</div>
                <form action="{{ route('payment.store') }}" method="POST">
                    {{ csrf_field() }}
                        <div class="flex p-10 relative bg-white rounded-lg mb-4 ">
                            @forelse($paymentMethods as $key => $method)
                            <div class="flex items-center pr-2 w-1/2">
                                <div class="font-bold text-black text-lg">
                                    @component('components.form.radio',[
                                        'name' => 'payment',
                                        'value' => $key,
                                        'checked' => $loop->first
                                    ])
                                    @endcomponent
                                    <span class="font-bold">
                                    روش : {{ $method['description'] }}
                                    </span>
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
            <div class="w-1/4">
                <div class="bg-white mr-2 p-4 text-center rounded-lg mb-2 mr-6">
                    <h4>مجموع سفارش</h4>
                    <h6>@toman(auth()->user()->cartCost)</h6>
                    <br>
                    @component('components.form.button',[
                        'label' => 'ادامه خرید',
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