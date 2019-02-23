@extends('layout')
@section('content')
<br>
    <div class="container">
        <div class="bg-red flex justify-center">
            <div>stepper</div>
        </div>
        <div class="flex">
            <div class="w-3/4">
                <div class="title bg-white mb-4 rounded-lg px-10 flex items-center py-1"><i class="material-icons pl-6">place</i>انتخاب آدرس تحویل سفارش</div>
                <div class="px-2 ">
                    @component('components.form', [
                        'action' => route('shipping.store'),
                        'method' => 'POST',
                    ])
                        @if($addresses->isNotEmpty())
                            <div class="w-full">
                                @foreach($addresses as $i => $address)
                                    <div class="flex items-center p-10 relative bg-white mb-4 rounded-lg">
                                        @component('components.form.radio',[
                                            'name' => 'address',
                                            'value' => $address->id,
                                            'checked' => $i == 0
                                        ])
                                        @endcomponent
                                        <div>
                                            <div class="mb-4 font-bold">
                                                گیرنده : {{ $address->receiver }}
                                            </div>
                                            <div class="flex text-sm">
                                                <div class="pl-10 mb-4 ">
                                                    موبایل : {{ $address->mobile }}
                                                </div>
                                                <div class="">
                                                    کدپستی : {{ $address->postal_code }}
                                                </div>
                                            </div>
                                            <div class="text-sm">
                                                آدرس : {{ $address->city->name }} - {{ $address->address }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @component('components.form.button',[
                                'label' => 'انتخاب آدرس',
                            ])
                            @endcomponent
                        @else
                            @component('components.form.button',[
                                'label' => 'افزودن آدرس',
                                'name' => 'btn_shipping_add_address',
                            ])
                            @endcomponent
                        @endif
                    @endcomponent
                </div>
            </div>
            <div class="w-1/4">
                <div class="bg-white mr-2 p-10 mr-6 text-center rounded-lg mb-2">
                    <h4>مجموع سفارش</h4>
                    <h6>@toman(auth()->user()->cartCost)</h6>
                    <br>
                    @component('components.form.button',[
                        'label' => 'تایید و ادامه ثبت سفارش',
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
@section('script')
    <script>
        $('#btn_shipping_add_address').click(function (event) {
            event.preventDefault();
            alert('open modal');
        });
    </script>
@endsection